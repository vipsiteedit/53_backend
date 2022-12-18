<?php

/**
 * @author Roman Kinyakin
 * @copyright 2013
 */

define('SHOP_SEARCH',1);
define('SHOP_GROUP',2);
define('SHOP_VITRINE',3);
 
class plugin_shopsearch40 {
	
	private $search;
	private static $instances;
	
	private function __construct() {
		//var_dump($_POST);
		if (get('SHOP_SEARCH',6,2)) {
			 $search = $_POST['SHOP_SEARCH'];
			$this->request($search);
		} else
		if (get('shopsearch',6,2)) {
			$search['text']['string'] = $_POST['shopsearch'];
			$this->request($search);
		}
		
		return $this->search = (isset($_SESSION['SHOP_SEARCH'])) ? $_SESSION['SHOP_SEARCH'] : array();
	}
	
	public function newrequest(){
	    unset($_SESSION['SHOP_SEARCH']);
	    if (get('SHOP_SEARCH',6,2)) {
			$search = $_POST['SHOP_SEARCH'];
			$this->request($search);
	    }
	    return $this->search = (isset($_SESSION['SHOP_SEARCH'])) ? $_SESSION['SHOP_SEARCH'] : array();
	}
	
	public function request($search)
	{
			$_SESSION['SHOP_SEARCH']['pagesearch'] = '';
			unset($_SESSION['SHOP_SEARCH']['manufacturer']);
			if (isset($search['clear'])) $_SESSION['SHOP_SEARCH'] = array();
			else {
				if (isset($search['text']) && isset($search['text']['string'])) {
					$text = filterRequest($search['text']['string'],3);
					if (!empty($text))
						$_SESSION['SHOP_SEARCH']['text'] = array(
							'string'=>$text,											//строка поиска
							'type'=>preg_replace('/[^a-z0-9\_\+]/','',filterRequest(@$search['text']['type'],3))				//поля поиска
							);
					else unset($_SESSION['SHOP_SEARCH']['text']);
				}
				if (isset($search['manufacturer'])) {
					$manufacturer = array();
					if (isset($search['manufacturer']) && is_array($search['manufacturer'])) 
						foreach($search['manufacturer'] as $m)  $manufacturer[] = intval($m);
					$_SESSION['SHOP_SEARCH']['manufacturer'] = implode(',',$manufacturer);
					//var_dump($_SESSION['SHOP_SEARCH']['manufacturer']);
				}
				if (isset($search['discount']) && isset($search['discount']['has'])) {
					$_SESSION['SHOP_SEARCH']['discount'] = array('has'=>(boolean)($search['discount']['has']));			//скидка
				}
				if (isset($search['price'])) {
					$_SESSION['SHOP_SEARCH']['price'] = array(
						'max'=>(isset($search['price']['max']) && $search['price']['max']!=0) 
							? floatval($search['price']['max']) : false,			//максимальная цена
						'min'=>(isset($search['price']['min']) && $search['price']['min']!=0) 
							? floatval($search['price']['min']) : false				//минимальная цена
						);
				}
				if (isset($search['flag'])) {
					$_SESSION['SHOP_SEARCH']['flag'] = array(
						'hit'=>(isset($search['flag']['hit'])) ? (boolean)($search['flag']['hit']) : false,				//хиты продаж
						'new'=>(isset($search['flag']['new'])) ? (boolean)($search['flag']['new']) : false,				//новинки
						'old'=>(isset($search['flag']['old'])) ? (boolean)($search['flag']['old']) : false				//залежалые товары
						);
				}
				if (isset($search['presence'])) {
					$_SESSION['SHOP_SEARCH']['presence'] = array(
						'from'=>(isset($search['presence']['from'])) ? intval($search['presence']['from']) : false,		//количество - от
						'to'=>(isset($search['presence']['to'])) ? intval($search['presence']['to']) : false			//количество - до
						);
				}
				if (isset($search['params'])) {
					//var_dump($search['params']);
					$_SESSION['SHOP_SEARCH']['params'] = array();
					foreach ($search['params'] as $k=>$v) {
						if ((int)$k<=0) continue;
						$_SESSION['SHOP_SEARCH']['params'][$k] = $v;									//параметры
					}
				}
			}
			return $this->search = (isset($_SESSION['SHOP_SEARCH'])) ? $_SESSION['SHOP_SEARCH'] : array();
	}
	
	public function get() {
		$arnum = func_num_args();
		if ($arnum<1) 
			return false;
		elseif ($arnum==1)
			$args = explode(':',array_shift(func_get_args()));
		else
			$args = func_get_args();
		$to_ret = &$this->search;
		foreach ($args as $v) {
			if (isset($to_ret[$v])) $to_ret = &$to_ret[$v];
			else return false;
		}
		return $to_ret;
	}
	public function fetchQuery($options=array()) {
		$defoptions = array(
			'noprice'=>false,
			'noparams'=>false
		);
		$options = array_merge($defoptions,$options);
		//static $where,$order,$fetched;												//условия поиска не меняются за время выполнения скрипта
		//if ($fetched===true) return array($where,$order);
		//var_dump($options);
		$where = $order = array();
		$p = $this->search;

		if (isset($p['text'])) {														//поиск по строкам
			$srch_text = utf8_strtolower($p['text']['string']);								//приводим нижний регистр
			$text = str_replace(array(' ',',','-'),'%',$srch_text);			//разделяем предложение на слова
			$queries = "LOWER([field]) LIKE '%$text%'";
				//шаблоны запроса для каждого слова
			$w = array();
			$fields = (!empty($p['text']['type'])) 
				? explode('+',$p['text']['type'])										//делим поля через знак +
				: array('name','article','name');	//','manufacturer'		//или используем полный набор
			//$textsecond = array_shift($text);
			foreach ($fields as $f) {
				$w[] = "(LOWER(sp.$f) LIKE '%$text%')";					//формируем условие выборки для каждого поля
				$order[] = array("LOWER(sp.$f) LIKE '%$text%'",1);					//сортируем по совпадениям всех слов
			}
			$where[] = '('.implode(' OR ',$w).')';										//общее условие выборки
			unset($text,$queries,$w,$t,$fields,$f);										//обнуляем лишние данные - на всякий случай
		}
		if (isset($p['manufacturer']) && !empty($p['manufacturer'])) {					//поиск по производителям
			$where[] = "(sp.id IN (SELECT price_id FROM shop_group_price WHERE group_id IN ($p[manufacturer])))";				//простой поиск
		}
		if (isset($p['discount']) && $p['discount']['has']) {							//скидки
			$where[] = "((sp.id IN (SELECT id_price FROM `shop_discount` WHERE sp.discount = 'Y')".
            " AND (SELECT date1 FROM `shop_discount` WHERE date1 <= CURRENT_TIMESTAMP())".
            " AND (SELECT date2 FROM `shop_discount` WHERE date2 >= CURRENT_TIMESTAMP()))".
            " OR (sp.id_group IN (SELECT id_group FROM `shop_discount` WHERE sp.discount = 'Y')".
            " AND (SELECT date1 FROM `shop_discount` WHERE date1 <= CURRENT_TIMESTAMP())".
            " AND (SELECT date2 FROM `shop_discount` WHERE date2 >= CURRENT_TIMESTAMP())))";
		}
		if (isset($p['price']) && !$options['noprice']) {								//цены
			$msql = "(SELECT kurs FROM `money` WHERE money_title_id=(SELECT id FROM money_title WHERE lang=sp.lang AND name=sp.curr) ORDER BY date_replace DESC LIMIT 1)";
			$price = $p['price'];
			if ($price['min']!==false) $where[] = "sp.price * $msql >= $price[min]";
			if ($price['max']!==false) $where[] = "sp.price * $msql <= $price[max]";			
			}
		if (isset($p['presence'])) {													//наличие товара
			$where[] = 'sp.presence_count <> 0';
			$presence = $p['presence'];
			if ($presence['from']!==false) $where[] = "sp.presence_count >= $presence[from]";
			if ($presence['to']!==false) $where[] = "sp.presence_count <= $presence[to]";
		}
		if (isset($p['params'])) {
																						//параметры
			foreach ($p['params'] as $k=>$v) {
				$v = implode('","',$v);
				$where[] = "(sp.id IN(SELECT price_id FROM `shop_price_param` WHERE param_id=$k AND value IN (\"$v\")))";
			}
		}
		$where = (!empty($where)) ? array('('.implode(' AND ',$where).')') : array();	//объединяем условия
		//$fetched = true;
		return array($where,$order);													//возврат значения
	}
	
	public static function getInstance($id_vitrine=0) {
		if (!is_array(self::$instances) || !isset(self::$instances[$id_vitrine]))
			self::$instances[$id_vitrine] = new plugin_shopsearch40($id_vitrine);
		return self::$instances[$id_vitrine];
	}
}
