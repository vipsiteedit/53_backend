<?php

/**
 * Plugin for calculate price
 * 
 */

class plugin_shopAmount40
{
  private $shopprice;
  private $typprice = 0;
  private $curr = '';
  private $count = 0;
  private $params;
  private $goodStyle = 1;
  public $sum_cart = 0;
          

  /**
   * @param integer $user_id	ID пользователя
   * @peram byte $typprice	Тип цены (0- Розничная, 1- корпоративная, 2- оптовая)
   * @param char $basecurr	Базовая валюта
   * @param array $goods	item good with fields (id,price,price_opt_corp,price_opt,bonus,discount,special_price,curr,presence_count,presence,measure)
   **/
    public function __construct($price_id, $goods='', $typprice = 0, $count=1, $params='',$basecurr = '')
    {
	if (empty($basecurr)) $basecurr = se_BaseCurrency();
	$this->curr = $basecurr;
	$this->count = $count;

	$this->typprice = $typprice;
	if (empty($goods)){
	    $this->shopprice = new seShopPrice();
	    $this->shopprice->select('id,price,price_opt_corp,price_opt,bonus,discount,special_price,curr,presence_count,presence,measure');
	    $this->goods = $this->shopprice->find($price_id);
	    $goods['params'] = 1;
	} else {
	    if (empty($goods['discount'])) {
	      $goods['discount'] = 'N';
	    }
	    if (empty($goods['spec_proc'])) {
	      $goods['special_price'] = 'N';
	    };

	    $this->goods = $goods;
	}
	if (isset($goods['params']) && $goods['params']) {
	  $this->params = new plugin_ShopParams40($params);
	  $this->params->notnull = true;
	  list($this->param_price, $param_count) = $this->params->getRootPrice();
	} else {
	  $param_count = -1;
	  $this->param_price = 0;
	}

	$this->presence_count = -1;
	if ($this->goods['presence_count'] == '') $this->goods['presence_count'] = -1;
	
	if ($param_count == '') $param_count = -1;
	$this->presence_count = $this->goods['presence_count'];

	if ($this->goods['presence_count'] != -1) {
	    if ($param_count > -1 && ($this->goods['presence_count'] > $param_count)) {
    		$this->presence_count = $param_count;
	    }
	} else {
    		$this->presence_count = $param_count;
	}

	if ($this->presence_count != -1 && $this->count > $this->presence_count)
	$this->count = $this->presence_count;
    }

    public function getGoodPrice() 
    {
        if (2 == $this->typprice) { 
            $goodsprice = se_MoneyConvert($this->goods['price_opt_corp'], $this->goods['curr'], $this->curr);
        } else if (1 == $this->typprice) {   
            $goodsprice = se_MoneyConvert($this->goods['price_opt'], $this->goods['curr'], $this->curr);
        } else {
            $goodsprice = se_MoneyConvert($this->goods['price'], $this->goods['curr'], $this->curr);
        }
	return round($goodsprice, 2);
    }


    public function getDiscountProc($round = true) 
    {
        if ($this->goods['special_price'] == 'Y' || $this->goods['discount'] == 'Y') {
            if ($this->goods['special_price'] == 'Y' && !empty($this->goods['spec_proc'])) {
        	$discountproc = $this->goods['spec_proc'];
            } else {
        	$shopdiscount = new plugin_shopDiscount40($this->goods['id'],$this->sum_cart, 0, $this->count);
        	$discountproc = $shopdiscount->execute();
            }
            return ($round) ? round($discountproc) : $discountproc;
        }
    }

	// Получаем цену товара
    public function getDiscount() 
    {
        if ($this->goods['special_price'] == 'Y' || $this->goods['discount'] == 'Y') {
    	    if ($this->goods['bonus'] > 0){
        	$goodsprice = se_MoneyConvert($this->goods['bonus'], $this->goods['curr'], $this->curr);
	    } else {
		$goodsprice = $this->getGoodPrice();
	    }
            $discountproc = $this->getDiscountProc(false);
            return round($goodsprice * ($discountproc / 100), 2);
        }
    }
	
	// Получаем комбинированную цену учитывая параметры и скидки
	// $discounted - включить скидку
    public function getPrice($discounted = true)
    {
	$goodsprice = $this->getGoodPrice();
        $paramprice = round(se_MoneyConvert($this->param_price, $this->goods['curr'], $this->curr), 2);
        $discountproc = 0;
        if ($discounted){
    	    $discountproc = $this->getDiscount();
        }

        $goodsprice += $paramprice;
        return $goodsprice - $discountproc;
    }  
  

    public function getAmount($discounted = true)
    {
	return round($this->getPrice($discounted)* $this->count, 2);
    }

    // Показать стоимость $round - округлить, $space - разделитель
    public function showPrice($discounted = true, $round = false, $separator = '&nbsp;')
    {
	$price = $this->getPrice($discounted);
        $price = (!$round) ? $price : ceil($price);
	return se_formatMoney($price, $this->curr, $separator, $round);
    }

    public function showAmount($discounted = true, $round = false, $separator = '&nbsp;')
    {
	$price = $this->getPrice($discounted) * $this->count;
        $price = (!$round) ? $price : ceil($price);
	return se_formatMoney($price, $this->curr, $separator, $round);
    }

    public function showDiscount($round = false, $separator = '&nbsp;')
    {
	$price = $this->getDiscount();
        $price = (!$round) ? $price : floor($price);
	return se_formatMoney($price, $this->curr, $separator, $round);
    }


    // Возврашает текст доступного количества и стиль поля
    public function showPresenceCount($alt_text = '') 
    {
        $this->goodStyle = 1;
	$pcount = $this->presence_count;
        if ($this->presence_count != -1) {
            if ($this->presence_count == 0) {
                if (!empty($this->goods['presence'])) {
                    $pcount = $this->goods['presence'];
                } else {
                    $pcount = '--';
                }
                $this->goodStyle = 0;
            } else {
                $pcount .= '&nbsp;' . $this->goods['measure'];
            }
        } else {
            if (!empty($this->goods['presence'])) {
                $pcount = $this->goods['presence'];
            } else {
                $pcount = $alt_text;
            }
        }
        return $pcount;
    }

    // Получаем актуальное количество
    public function getActualCount()
    {
	return $this->count;
    }
   
    public function getPresenceCount()
    {
	return $this->presence_count;
    }
   
    public function getCountStyle()
    {
	return $this->goodStyle;
    }
}
?>