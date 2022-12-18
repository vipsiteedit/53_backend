<?php
/**
 * @copyright EDGESTILE
 */ 
class plugin_shopdelivery53
{
	private static $instance = null;
	private $basecurr;
	private $total;
	private $ems_locations = null;
	private $ems_params = array();
	public $delivery_type_id = 0;
	private $not_delivery;
	private $geo_data = array();
	public function __construct($not_delivery = array()) 
	{
		define('DATA_DIR', SE_ROOT . 'data/');
		$this->not_delivery = $not_delivery;
		$plugin_cart = new plugin_shopcart53(array('curr' => se_baseCurrency()));
		$this->total = $plugin_cart->getTotalCart();

		$this->basecurr = se_getMoney();

		if (isRequest('delivery_type_id'))
			$this->delivery_type_id = $_SESSION['delivery_type_id'] = getRequest('delivery_type_id', VAR_INT);
		elseif (!empty($_SESSION['delivery_type_id']))
			$this->delivery_type_id = $_SESSION['delivery_type_id'];
		$this->checkUserRegion();
		/*
		$sql_cache = "SELECT
			  'delivery' AS type,
			  COUNT(*) AS cnt,
			  UNIX_TIMESTAMP(GREATEST(MAX(sdt.updated_at), MAX(sdt.created_at))) AS time
			FROM shop_deliverytype sdt
			UNION
			SELECT
			  'param',
			  COUNT(*),
			  UNIX_TIMESTAMP(GREATEST(MAX(sdp.updated_at), MAX(sdp.created_at)))
			FROM shop_delivery_param sdp
			UNION ALL
			SELECT
			  'region',
			  COUNT(*),
			  UNIX_TIMESTAMP(GREATEST(MAX(sdr.updated_at), MAX(sdr.created_at)))
			FROM shop_delivery_region sdr
			UNION ALL
			SELECT
			  'group',
			  COUNT(*),
			  UNIX_TIMESTAMP(GREATEST(MAX(sdg.updated_at), MAX(sdg.created_at)))
			FROM shop_deliverygroup sdg";
			
		$result = se_db_query($sql_cache);

		if (!empty($result)) {
			while ($line = se_db_fetch_assoc($result)) {
				print_r($line);
			}
		}
		
		
		$this->cache_dir = SE_SAFE . 'projects/' . SE_DIR . 'cache/shop/deliveries/';
		
		if (!is_dir($this->cache_dir)) {      
			if (!is_dir(SE_SAFE . 'projects/' . SE_DIR . 'cache/'))
				mkdir(SE_SAFE . 'projects/' . SE_DIR . 'cache/');
			if (!is_dir(SE_SAFE . 'projects/' . SE_DIR . 'cache/shop/'))
				mkdir(SE_SAFE . 'projects/' . SE_DIR . 'cache/shop/');
			mkdir($this->cache_dir);				
		}
		*/
	}
	
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function checkUserRegion(){
		$plugin_shopgeo = new plugin_shopgeo(); 
		$this->geo_data = $plugin_shopgeo->getSelected();
	}
	
	private function getGroupsTree($group_id)
	{
		$id = $group_id;
		$groups = new seTable('shop_group', 'sg');
		$groups->select('sg.upid, (SELECT sdg.id_group FROM shop_deliverygroup sdg WHERE sdg.id_group = sg.id) AS id_group');
		$groups->where('sg.id=?', $group_id);
		$groups->fetchOne();
		if ($groups->upid && $groups->id_group < 1){
			$id = $this->getGroupsTree($groups->upid);
		}

		return $id;
	}
	
	public function getDeliveryList() {
		$this->checkUserRegion();
		
		$incart_arr = array();
		$groups = new seTable('shop_price');
		$groups->select('DISTINCT id_group');
		$groups->where('id IN (?)', join(',', $this->total['goods_id']));
		$groups->andwhere("enabled='Y'");

		foreach($groups->getlist() as $line) {
			$incart_arr[] = $this->getGroupsTree($line['id_group']);
		}
		$find_delivery = false;
		$rdeliv = new seTable('shop_deliverytype', 'sdt');
		$rdeliv->select('DISTINCT sdt.id, sdt.name, sdt.code, sdt.time, sdt.price, sdt.curr, sdt.forone, sdt.note, sdt.week, sdt.need_address');
		$rdeliv->innerjoin('shop_deliverygroup sdg', 'sdg.id_type=sdt.id');
		$rdeliv->where("sdg.id_group IN (?)", join(',', $incart_arr));
		$rdeliv->andWhere("sdt.status ='?'", 'Y');
		$rdeliv->andWhere("(sdt.max_weight >= '?' OR sdt.max_weight IS NULL OR sdt.max_weight = 0)", floatval($this->total['weight']));
		$rdeliv->andWhere("(sdt.max_volume >= '?' OR sdt.max_volume IS NULL OR sdt.max_volume = 0)", floatval($this->total['volume']));
		
		if ($rdeliv->isFindField('sort'))
			$rdeliv->orderBy('sort');
		
		$deliveries = $rdeliv->getList();
		if (!empty($deliveries)){
			$day_week = (date('w') + 6) % 7;
			foreach($deliveries as $key => $delivery){
				$delivery['code'] = strtolower($delivery['code']);
				if ($delivery['code'] == 'region'){
					$delivery_param = $this->getDeliveryPriceParam($delivery);
					if (empty($delivery_param)){
						unset($deliveries[$key]);
						continue;
					}
					else 
						$delivery = $delivery_param;
				}
				elseif ($delivery['code'] == 'ems'){
					$delivery_ems = $this->getDeliveryPriceEms($delivery['curr']);
					if (empty($delivery_ems)){
						unset($deliveries[$key]);
						continue;
					}
					else{
						$delivery['price'] += se_Money_Convert($delivery_ems['price'], 'RUR', $delivery['curr']);
						$delivery['time'] = $delivery_ems['time'];
					}
				}
				if ($delivery['price'] > 0)
					$delivery['price'] = se_Money_Convert($delivery['price'] * ($delivery['forone'] == 'Y' ? $this->total['count'] : 1), $delivery['curr'], $this->basecurr);
				$delivery['curr'] = $this->basecurr;
				$delivery['week'] = $delivery['week'][$day_week];
				$delivery['addr'] = ($delivery['need_address'] == 'Y');
				$deliveries[$key] = $delivery;
				if (!$find_delivery)
					$find_delivery = ($delivery['id'] == $this->delivery_type_id);
			}
		}
		if (!empty($this->not_delivery))
			array_unshift($deliveries, $this->not_delivery);
		if (!$find_delivery){
			$this->delivery_type_id = $_SESSION['delivery_type_id'] = $deliveries[0]['id'];
		}
		return $deliveries;
	}
	
	private function getDeliveryPriceEms()
	{
		$delivery = array();
		
		if (!file_exists(DATA_DIR))
			mkdir(DATA_DIR);
		if (empty($this->ems_params['max_weight'])){
			$this->ems_params['max_weight'] = 0;
			if (!file_exists(DATA_DIR.'ems_max_weight.dat') || filemtime(DATA_DIR.'ems_max_weight.dat') < (time()-(3600 * 24))){
				$ems_response = $this->getContentsEms('?method=ems.get.max.weight');
				if ($ems_response){
					$ems_options = json_decode($ems_response, true);
					if (isset($ems_options['rsp']['stat']) && $ems_options['rsp']['stat'] == 'ok'){
						$max_weight = (float)$ems_options['rsp']['max_weight'];
						$this->ems_params['max_weight'] = $max_weight;
						$f = fopen(DATA_DIR.'ems_max_weight.dat', 'w+');
						fwrite($f, $max_weight);
						fclose($f);
					}
				}
			}
			else{
				$this->ems_params['max_weight'] = file_get_contents(DATA_DIR.'ems_max_weight.dat');
			}	
		}
		
		if ($this->ems_params['max_weight'] >= $this->total['weight']){
				if (empty($this->ems_params['city_to'])){
					$this->ems_params['city_to'] = $this->geo_data['city'];
					$this->ems_params['region_to'] = $this->geo_data['region'];
				}
				if (empty($this->ems_params['city_from'])){
					$tlb_main = new seTable('main');
					$tlb_main->select('city_from_delivery as city');
					$tlb_main->where("lang = '?'", se_getLang());
					$tlb_main->fetchOne();
					$this->ems_params['city_from'] = $tlb_main->city;
					unset($tlb_main); 
				}
				
				if (!empty($this->ems_params['city_from']) && (!empty($this->ems_params['city_to']) || !empty($this->ems_params['region_to'])) && (empty($this->ems_params['ems_from']) || empty($this->ems_params['ems_to']))){
					$ems_region_to = '';
					$this->ems_params['ems_from'] = $this->ems_params['ems_to'] = '';
					if (empty($this->ems_locations)){
						if (!file_exists(DATA_DIR.'ems_locations.dat') || filemtime(DATA_DIR.'ems_locations.dat') < (time() - (3600 * 24))){
							$ems_response = $this->getContentsEms('?method=ems.get.locations&type=russia&plain=true');
							if ($ems_response){
								$ems_options = json_decode($ems_response, true); 
								$this->ems_locations = $ems_options['rsp']['locations'];
								$f = fopen(DATA_DIR.'ems_locations.dat', 'w+');
								fwrite($f, serialize($this->ems_locations));
								fclose($f);
							}
						}
						else{
							$locations = file_get_contents(DATA_DIR . 'ems_locations.dat');
							$this->ems_locations = unserialize($locations);
						}
							
					}
					if (!empty($this->ems_locations)){
						$find = 0;
						foreach($this->ems_locations as $val){
							if (3 == $find){
								break;
							}
							if (empty($this->ems_params['ems_to']) && utf8_strtoupper($val['name']) == utf8_strtoupper($this->ems_params['city_to'])){
								$this->ems_params['ems_to'] = $val['value'];
								$find += 2;
							}
							if (empty($ems_region_to) && utf8_strtoupper($val['name']) == utf8_strtoupper($this->ems_params['region_to'])){
								$ems_region_to = $val['value'];
								$find++;
							}
							if (empty($this->ems_params['ems_from']) && utf8_strtoupper($val['name']) == utf8_strtoupper($this->ems_params['city_from'])){
								$this->ems_params['ems_from'] = $val['value'];
								$find++;
							}
						}
					}
					if (empty($this->ems_params['ems_to']) && !empty($ems_region_to)){
						$this->ems_params['ems_to'] = $ems_region_to;
					}
				}
				
				if (empty($this->ems_param['price']) || empty($this->ems_param['time'])){
					if (!empty($this->ems_params['ems_from']) && !empty($this->ems_params['ems_to'])){
						$url = '?method=ems.calculate&from=' . $this->ems_params['ems_from'] . '&to=' . $this->ems_params['ems_to'] . '&weight=' . $this->total['weight'];
						$ems_response = $this->getContentsEms($url);
						if ($ems_response){
							$ems_options = json_decode($ems_response, true);
							if (isset($ems_options['rsp']['stat']) && $ems_options['rsp']['stat'] == 'ok'){
								$delivery['price'] = $this->ems_param['price'] = $ems_options['rsp']['price'];
								$delivery['time'] = $this->ems_param['time'] = $ems_options['rsp']['term']['min'] . '-' . $ems_options['rsp']['term']['max'];
							}	
						}
					}
				}
				else{
					$delivery['price'] = $this->ems_param['price'];
					$delivery['time'] = $this->ems_param['time'];
				}
		}
		return $delivery;
	}
	
	private function getContentsEms($query)
	{
		$url = 'http://emspost.ru/api/rest/' . $query;
		if (extension_loaded('curl')){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
			$contents = curl_exec($ch);
			curl_close($ch);
		} 
		else{
			$contents = file_get_contents($url);
		}
		return $contents;
	}
	
	private function getDeliveryPriceParam($delivery) {
		$deliv = array();
		if (!empty($delivery)) {
			$id_delivery = $delivery['id'];
			$country = $this->geo_data['id_country'];
			$region = $this->geo_data['id_region'];
			$city = $this->geo_data['id_city'];
						
			$delivery_region = new seTable('shop_delivery_region');
			$delivery_region->select('id');
			$delivery_region->where('id_delivery=?', $id_delivery);
			$delivery_region->andWhere("(id_country=$country OR id_region=$region OR id_city=$city)");
			$delivery_region->fetchOne();
			if ($delivery_region->isFind()) {
				
				$sdt = new seTable('shop_deliverytype', 'sdt');
				$sdt->select('DISTINCT sdt.id, sdt.name, sdt.code, sdt.time, sdt.price, sdt.curr, sdt.forone, sdt.note, sdt.week, sdt.need_address');
				$sdt->innerJoin('shop_delivery_region sdr', 'sdt.id=sdr.id_delivery');
				$sdt->where('sdt.id_parent=?', $id_delivery);
				$sdt->andWhere("(sdr.id_country=$country OR sdr.id_region=$region OR sdr.id_city=$city)");
				$sdt->andWhere("sdt.status='Y'");
				//$sdt->andWhere("(sdt.max_weight >= '?' OR sdt.max_weight IS NULL OR sdt.max_weight = 0)", floatval($this->total['weight']));
				//$sdt->andWhere("(sdt.max_volume >= '?' OR sdt.max_volume IS NULL OR sdt.max_volume = 0)", floatval($this->total['volume']));
				$list = $sdt->getList(); 
				if ($list) {
					foreach ($list as $val) {
						if (!empty($val['price']))
							$delivery['price'] = $val['price'];
						if (!empty($val['time']))
							$delivery['time'] = $val['time'];
						if (!empty($val['note']))
							$delivery['note'] = $val['note'];
					}
				}
				
				$deliv = $delivery;
				$current_price = $delivery['price'];
				$current_priority = 0;
				$current_key = -1;
				$delivery_param = new seTable('shop_delivery_param');
				$delivery_param->select('type_param, price, min_value, max_value, priority, type_price, operation');
				$delivery_param->where("id_delivery = ?", $id_delivery);
				$param_list = $delivery_param->getList();
				if (!empty($param_list)){
					foreach ($param_list as $key => $param){
						$param_defined = false;
						switch ($param['type_param']) {
							case 'sum':
								if ($param['min_value'] <= $this->total['sum_total'] && ($param['max_value'] > $this->total['sum_total'] || $param['max_value'] == 0)){
									$param_defined = true;
								}
								break;
							case 'weight':
								if ($param['min_value'] <= $this->total['weight'] && ($param['max_value'] > $this->total['weight'] || $param['weight'] == 0)){
									$param_defined = true;
								}
								break;
							case 'volume':
								if ($param['min_value'] <= $this->total['volume'] && ($param['max_value'] > $this->total['volume'] || $param['volume'] == 0)){
									$param_defined = true;
								}
								break;
							default:
								break;
						}
						if ($param_defined && $param['priority'] >= $current_priority){
							$current_key = $key;
							$current_priority = $param['priority'];
						}
					}
					if ($current_key >= 0){
						$param = $param_list[$current_key];
						$add_price = 0;
						if ($param['type_price'] == 'a')
							$add_price = $param['price'];
						else{
							$percent = $param['price'] <= 100 ? $param['price']/100 : 1;
							$add_price = $percent * ($param['type_price'] == 's' ? $this->total['sum_total'] : $current_price);
						}	
						$current_price = ($param['operation'] == '+') ? $current_price + $add_price : ($param['operation'] == '-' ? $current_price - $add_price : $add_price);
					}
				}
				$deliv['price'] = $current_price > 0 ? $current_price : 0;
			}
		}
		return $deliv;
	}
	
	public function getDelivery($id_delivery = null, $base_curr = false)
	{
		$id = (!empty($id_delivery)) ? $id_delivery : $this->delivery_type_id;
		$delivery = array();
		if ($id){
			$delivery_type = new seTable('shop_deliverytype', 'sdt');
			$delivery_type->select('sdt.id, sdt.name, sdt.code, sdt.time, sdt.price, sdt.curr, sdt.forone, sdt.note, sdt.need_address');
			$delivery_type->where("sdt.id = ?", $id);
			$delivery_type->andWhere("sdt.status ='?'", 'Y');
			$delivery = $delivery_type->fetchOne();
			if ($delivery_type->isFind()){
				$delivery['code'] = strtolower($delivery['code']);
				if ($delivery['code']== 'region'){
					$delivery = $this->getDeliveryPriceParam($delivery);
				}
				elseif ($delivery['code'] == 'ems' && $delivery_ems = $this->getDeliveryPriceEms()){
					$delivery['price'] += $delivery_ems['price'];
					$delivery['time'] = $delivery_ems['time'];
				}
				$delivery['price']= se_Money_Convert($delivery['price'] * ($delivery['forone'] == 'Y' ? $this->total['count'] : 1), $delivery['curr'], $this->basecurr);
				
				$delivery['addr'] = ($delivery['need_address'] == 'Y');

			}
		}
		elseif($id === 0 && !empty($this->not_delivery)) $delivery = $this->not_delivery;
		return $delivery;
	} 
}