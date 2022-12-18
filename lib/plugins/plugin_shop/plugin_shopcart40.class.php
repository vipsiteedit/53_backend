<?php
/**
 * Базовый класс для взаимодействия с корзиной 
 * @filesource plugin_shopcart.class.php
 * @copyright EDGESTILE
 */
class plugin_shopCart40        
{
    private $options = array();                   
    public $incart;
    
	public function __construct($options = array())  
  	{
        $default = array(             
            'round' => false, 
            'type_price' => 0, 
            'presence' => '', 
            'curr' => se_getMoney() 
            );
        $this->options = array_merge((array)$default, (array)$options);
        $this->getInCart();        
        return $this;
  	}
    
    public function clearCart()
    {
        unset($_SESSION['shopcart']);
        unset($_SESSION['code_coupon']);
        unset($_SESSION['cartcontact']);
        $this->incart = null;
    }

    public function getCartTotal()
    {
        $incart = $this->incart;
        $total_cart = 0;
        $shopprice = new seShopPrice();
        foreach ($incart as $key => $val){
            $plugin_amount = new plugin_shopAmount40($val['id'], '', $this->options['type_price'], $val['count'], $val['params'], $this->options['curr']);
            $total_cart += $plugin_amount->getAmount(false);
        }
	return $total_cart;
    }

    public function getTotalCart()
    {
        $total = $total_cart = $discount = $weight = $volume = $count = 0;
        $goods_id = array();
        $incart = $this->incart;
        $shopprice = new seShopPrice();
        $total_cart = $this->getCartTotal();
        foreach ($incart as $key => $val){
            $plugin_amount = new plugin_shopAmount40($val['id'], '', $this->options['type_price'], $val['count'], $val['params'], $this->options['curr']);
            $plugin_amount->sum_cart = $total_cart;
            $total += $plugin_amount->getAmount();
            $presence_count = $plugin_amount->getActualCount();
            $count += $presence_count;
            $discount += $plugin_amount->getDiscount() * $presence_count;
            $shopprice->find($val['id']);
            $weight += $shopprice->weight * $presence_count;
            $volume += $shopprice->volume * $presence_count;
            $goods_id[] = $val['id'];    
        }
        //$coupon = $this->getCoupon();
        return array(
            'goods_id' => $goods_id,
            'count' => $count,
            'sum_total' => $total, 
            'sum_discount' => $discount, 
            'show_total' => se_formatMoney($total, $this->options['curr'], '&nbsp;', $this->options['round']),
            'show_discount' => se_formatMoney($discount, $this->options['curr'], '&nbsp;', $this->options['round']), 
            'weight' => ($weight > 0) ? $weight/1000 : 0.001,
            'volume' => ($volume > 0) ? $volume : 1, 
            'curr' => $this->options['curr']
            );    
    }
    
   	public function getInCart() 
    {
		$this->incart = array();
        if (!empty($_SESSION['shopcart'])){
       		$this->incart = $_SESSION['shopcart'];
   		}
		elseif (!empty($_COOKIE['shopcart'])){
       		$this->incart = $_COOKIE['shopcart'];
		}

        if (!empty($this->incart)){
            foreach ($this->incart as $key => $val) {
                if (empty($val['id'])){
                    unset($this->incart[$key]);
                    continue;
                }
                $total_cart = $this->getCartTotal();
                $plugin_amount = new plugin_shopAmount40($val['id'], '', $this->options['type_price'], $val['count'], $val['params'], $this->options['curr']);
                $plugin_amount->sum_cart = $total_cart;
                $count = $plugin_amount->getActualCount();
                if ((int)$count > 0){
                    $_SESSION['shopcart'][$key]['count'] = $this->incart[$key]['count'] = $count;
                    $this->incart[$key]['sum'] = $plugin_amount->showAmount(true, $this->options['round']);
                }
                else {
                    unset($_SESSION['shopcart'][$key], $this->incart[$key]);
                }
                                                                 
            }    
        }                             
        return $this->incart;
	}
    
    public function getGoodsCart()
    {
        $goods_list = array();
        $incart = $this->incart;
        if (empty($incart)) return;
        
        $shop_price = new seShopPrice();
        foreach ($incart as $key => $value){
            if (!$value['id']) continue;
            $goods['key'] = $key;
            $goods['price_id'] = $value['id'];
            $goods['params'] = $goods['paramsname'] = '';
            if ($value['params']){
                $goods['params'] = $value['params'];
                $param = new plugin_ShopParams40($value['params']);
                $goods['paramsname'] = $param->getParamsName();
                unset($param);        
            }
            
            $shop_price->find((int)$value['id']);
            $goods['name'] = $shop_price->name;
            $goods['code'] = $shop_price->code;
            $goods['article'] = $shop_price->article;;
            $goods['img'] = $shop_price->img;
            $goods['manufacturer'] = $shop_price->manufacturer;
            
            $plugin_amount = new plugin_shopAmount40($value['id'], '', $this->options['type_price'], $value['count'], $value['params'], $this->options['curr']);
            $plugin_amount->sum_cart = $this->getCartTotal();
            $goods['price'] = $plugin_amount->getPrice(false);
            $goods['oldprice'] = $plugin_amount->showPrice(false, $this->options['round']);
            $goods['newprice'] = $plugin_amount->showPrice(true, $this->options['round']);
            $goods['sum'] = $plugin_amount->getAmount(true);
            $goods['oldsum'] = $plugin_amount->showAmount(false, $this->options['round']);
            $goods['newsum'] = $plugin_amount->showAmount(true, $this->options['round']);
            $goods['discount'] = $plugin_amount->getDiscount();
            $goods['show_discount'] = $plugin_amount->showDiscount($this->options['round']);
            $goods['presence_count'] = $plugin_amount->showPresenceCount($this->options['presence']);  
            $goods['count'] = $plugin_amount->getActualCount();
            $goods['show_count'] = $goods['count'].'&nbsp;'.$shop_price->measure;
            $goods['curr'] = $this->options['curr'];
            $goods_list[] = $goods;    
        }  
        return $goods_list;
    }
    
    public function updateCart($items = array())
    {
        $count_items = (!empty($items)) ? $items : $_POST['countitem'];
        $sum_cart = $this->getCartTotal();
        if (!empty($count_items)){
            foreach ($count_items as $key => $count){
                $cart = $this->incart[$key];
                if ($cart){
                    $count = max(1, (int)$count);
                    $plugin_amount = new plugin_shopAmount40($cart['id'], '', $this->options['type_price'], $count, $cart['params'], $this->options['curr']);
                    $count = (int)$plugin_amount->getActualCount();
                    $_SESSION['shopcart'][$key]['count'] = $this->incart[$key]['count'] = $count;
    		    $plugin_amount->sum_cart = $this->getCartTotal();
                    
                    $this->incart[$key]['sum'] = $plugin_amount->showAmount(true, $this->options['round']);
                }    
            }
        }        
    }
    
    public function delCart($params = array())
    {
        $del_cart_name = (!empty($params['delcartname'])) ? $params['delcartname'] : getRequest('delcartname', 3);
        if (!$del_cart_name){
            $del_cart_id = (!empty($params['id'])) ? $params['id'] : getRequest('delcart', 1);
            $del_cart_param = (!empty($params['param'])) ? $params['param'] : getRequest('delcartparam', 3);  
            if (is_array($del_cart_param)) 
                $del_cart_param = 'param:'.join(',', $add_cart_param);

            $del_cart_name = md5($del_cart_id.'_'.$del_cart_param);
        }
        if ($del_cart_name && isset($_SESSION['shopcart'][$del_cart_name])){
            unset($_SESSION['shopcart'][$del_cart_name], $this->incart[$del_cart_name]);
            return $del_cart_name;    
        }
        return;  
    }
    
	public function useCoupon()
	{
		if (!file_exists(SE_ROOT . '/system/logs/shop_coupons_history.upd')) {
			$sql = "CREATE TABLE IF NOT EXISTS `shop_coupons_history` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`code_coupon` varchar(50) NOT NULL,
				`id_coupon` int(10) unsigned NOT NULL,
				`id_user` int(10) unsigned DEFAULT NULL,
				`id_order` int(10) unsigned NOT NULL,
				`discount` float(10,2) DEFAULT NULL,
				`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY (`id`),
				KEY `id_coupon` (`id_coupon`),
				KEY `id_user` (`id_user`),
				KEY `id_order` (`id_order`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		
			if (se_db_query($sql)) {
			    se_db_query("ALTER TABLE `shop_coupons_history`
			    ADD CONSTRAINT `shop_coupons_history_fk1` FOREIGN KEY (`id_order`) REFERENCES `shop_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
			    ADD CONSTRAINT `shop_coupons_history_fk` FOREIGN KEY (`id_coupon`) REFERENCES `shop_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

				$file = fopen(SE_ROOT . '/system/logs/shop_coupons_history.upd', 'w+');
				fclose($file);
			}
		}    
		$r_coupon = array('discount' => 0, 'id' => null);
		if (!empty($_SESSION['code_coupon']) && $coupon = $this->getCoupon($_SESSION['code_coupon'])) {
			$r_coupon['discount'] = se_Money_Convert($coupon['discount'], $this->options['curr'], se_baseCurrency());
			$shop_coupon = new seTable('shop_coupons');
			$shop_coupon->select('id, count_used, status');
			$shop_coupon->where("code = '?'", $coupon['code']);
			if ($shop_coupon->fetchOne()){
				$r_coupon['id'] = $shop_coupon->id;
				if ($shop_coupon->count_used <= 1) {
					$shop_coupon->update('status', "'N'");  
				}
				$shop_coupon->addupdate('count_used', "count_used-1");
				$shop_coupon->where("code = '?'", $coupon['code']);
				$shop_coupon->save();          
			}        
		}
		return $r_coupon;
	}
    
    public function getCoupon($code = '')
    {
        $coupon = array();
        $code_coupon = '';
        if (!empty($code)){ 
            $code_coupon = $code;
        }
        elseif (getRequest('code_coupon', 3)){
            $code_coupon = getRequest('code_coupon', 3);
        }
        elseif (!empty($_SESSION['code_coupon'])){
            $code_coupon = $_SESSION['code_coupon'];
        }
        unset($_SESSION['code_coupon']);
        unset($_SESSION['promo_payment']);        
        if ($code_coupon){
            $coupon_valid = true;
            $shop_coupon = new seTable('shop_coupons');
            $shop_coupon->select('type, discount, currency, expire_date, min_sum_order, count_used, payment_id, only_registered');
            $shop_coupon->where("status = '?'", 'Y');
            $shop_coupon->andwhere("code = '?'", $code_coupon);
            if ($shop_coupon->fetchOne()){
                
                $total = $this->getTotalCart();
                $sum_cart = $total['sum_total'];
                
                if ($shop_coupon->expire_date > 0 && $shop_coupon->expire_date < date('Y-m-d')){
                    $coupon_valid = false;   
                }
                
                if ($shop_coupon->only_registered == 'Y' && !seUserGroup() && !seUserId()){
                    $coupon_valid = false;   
                }
                
                if ($shop_coupon->min_sum_order > 0){   
                    if ($sum_cart < se_Money_Convert($shop_coupon->min_sum_order, $shop_coupon->currency, $this->options['curr']))
                        $coupon_valid = false;
                }
                
                if (!$shop_coupon->count_used > 0){
                    $coupon_valid = false;
                    $shop_coupon->update('status', "'N'");
                    $shop_coupon->addupdate('count_used', 0);
                    $shop_coupon->where("code = '?'", $code_coupon);
                    $shop_coupon->save(); 
                }
                if ($coupon_valid){
                    if ($shop_coupon->payment_id){
                        $_SESSION['promo_payment'] = $shop_coupon->payment_id;
                    }
                    
                    $_SESSION['code_coupon'] = $coupon['code'] = $code_coupon;
                    if ($shop_coupon->type == 'p'){
                        $value = ($shop_coupon->discount <= 100) ? $shop_coupon->discount : 100;
                        $coupon['discount'] = ($sum_cart) * ($value/100);
                        $coupon['value'] = $value.' %';      
                    }
                    else{
                        $discount = se_Money_Convert($shop_coupon->discount, $shop_coupon->currency, $this->options['curr']);
                        $value = ($discount <= $sum_cart) ? $discount : $sum_cart;
                        $coupon['discount'] = $value;
                        $coupon['value'] = se_FormatMoney($shop_coupon->discount, $shop_coupon->currency);                       
                    }
                    $coupon['show'] = se_FormatMoney($coupon['discount'], $this->options['curr'], '&nbsp;', $this->options['round']);
                    if ($this->options['round'])  $coupon['discount'] = round($coupon['discount']);
                }            
            }
            else return;
        }
        return $coupon;       
    }

	public function addCart($params = array())
	{
		$pr = new seShopPrice();
        
        // Существующие товары в корзине сохраняем неизменными	 
        $incart = $this->incart;

        // Новый товар, кладущийся в корзину
   		$add_cart_id = (!empty($params['id'])) ? $params['id'] : getRequest('addcart', 1);// id-шник
   		$add_cart_count = (!empty($params['count'])) ? $params['count'] : getRequest('addcartcount', 1);	// количество
   		    
   		// Комментарий или дополнительные параметры 
   		$add_cart_param = (!empty($params['param'])) ? $params['param'] : getRequest('addcartparam', 3);  
   		if (is_array($add_cart_param)) $add_cart_param = 'param:'.join(',', $add_cart_param);

   		$cart_name = md5($add_cart_id.'_'.$add_cart_param);
   		$incart[$cart_name]['params'] = $add_cart_param;
   		$incart[$cart_name]['id'] = $add_cart_id;

		if (!$add_cart_count)
   			$add_cart_count = 1;							// как минимум 1 шт.
	
        // Находим в базе запрошенный товар (определяем количество в наличии)
   		$pr->select('article, name, presence_count, curr');
		$pr->find($add_cart_id);
		$count = $pr->presence_count;
		$price = $pr->price;
   		$name = $pr->name;
		$incart[$cart_name]['article'] = $pr->article;
		
		$pcount = '';
		if (strpos($add_cart_param,'param:')!==false){
		    $prm = new plugin_shopparams40($add_cart_param);
		    
		    //list(,$this_id) = explode(':', $add_cart_param);
		    list($pprice, $pcount) = $prm->getRootPrice();
		    if ($pcount != '') $count = $pcount;
		    $price += $pprice;
   		    $incart[$cart_name]['price'] = $price;
   		    $incart[$cart_name]['curr'] = $pr->curr;
			$name .= ' ('.$prm->getParamsName().')'; 
		    unset($prm);
		}
   		$incart[$cart_name]['name'] = $name;
		
		if (empty($pcount)) $pcount = $pr->presence_count;
				
   		if (!empty($incart[$cart_name]['count'])) // Если в корзине уже есть запрошенный товар 
		{
   			if ( ($pcount > 0 // если есть в наличии и...
			     && ((intval($incart[$cart_name]['count']) + $add_cart_count) <= $pcount)) // и товара хватит
       		        || ($pcount == '') || $pcount<0) {// null - обозначение бесконечного количества
			    $incart[$cart_name]['count'] = intval($incart[$cart_name]['count']) + $add_cart_count; // помещаем в корзину новое количество
   			}
   		}
   		else // Если в корзине нет запрошенного товара
   		{
   		
   			if (($pcount > 0 // если есть в наличии и...
			     && ($add_cart_count <= $pcount)) // и товара хватит
       		     || ($pcount == null) || ($count == -1)) // null - обозначение бесконечного количества
   			{	
			    $incart[$cart_name]['count'] = $add_cart_count;
			}
			else
			{
				$incart[$cart_name]['count'] = $pcount;
			}
		}
    
        // Передаем товар из внутренней переменной в реальную корзину  
   		$_SESSION['shopcart'] = $incart;
 	}

}
?>