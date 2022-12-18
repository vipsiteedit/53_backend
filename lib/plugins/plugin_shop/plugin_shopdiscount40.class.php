<?php

/**
 * Класс создания заказа
 * 
 */

class plugin_shopDiscount40
{
  private $shopprice;
  private $sum_cart = 0;
  private $summa = 0;
  private $count_goods = 1;
  private $userdiscount = 0;

  /**
   * @param integer $user_id	ID пользователя
   * @param array	$incart		Массив товаров	array('price_id'=>1,'count'=>1,'name'=>'','action'=>'1000011122:version=6')
   **/
  function __construct($price_id, $sum_cart = 0, $summa = 0, $count_goods = 1, $user_id = 0)
  {
    $this->shopprice = new seShopPrice();
    $this->shopprice->find($price_id);
    $this->sum_cart = $sum_cart;
	$this->summa = $summa;
	$this->count_goods = $count_goods;
    if (!$user_id) 
        $user_id = seUserId();
    $this->userdiscount = $this->getUserDiscount($user_id);
  }


  /**
   * Проверка условий
   */
  private function ifparam($data1, $data2, $logic)
  {
    switch ($logic)
    {
      case '>=':
        $res = ($data1 >= $data2);
        break;
      case '<=':
        $res = ($data1 <= $data2);
        break;
      case '==':
        $res = ($data1 == $data2);
        break;
      case '<>':
        $res = ($data1 != $data2);
        break;
      default:
        $res = 1;
    }
    return $res;
  }

  public function discount_price()
  {
    if ($this->shopprice->discount == 'N') 
        return 0;
        
    $summa = $this->summa;
	$shopprice = $this->shopprice;
    $discountproc = 0;
    $weeks = array('1', '2', '3', '4', '5', '6', '7');
    
    $discountlist = $shopprice->getDiscount();
    $pers_discount_gr_1 = $pers_discount_gr_2 = $pers_discount_pr_1 = $pers_discount_pr_2 = 0;
    
    if (!empty($discountlist))
    {
      foreach ($discountlist as $discount)
      {
	$fl = 1;
        //if ($discount['type'] == 'g')
        //{
          $summa = $this->sum_cart;
        //}

        if (!empty($discount['if_date1']) || !empty($discount['if_date2']))
        {
          $fl = $fl * ((!empty($discount['if_date1']) || !empty($discount['if_date2'])) 
		  * $this->ifparam(date('Y-m-d'), $discount['date1'], $discount['if_date1']) 
		  * $this->ifparam(date('Y-m-d'), $discount['date2'], $discount['if_date2']));
        }

        if (!empty($discount['if_summ1']) || !empty($discount['if_summ2']))
        {
          if ($discount['summ_type'] == 1)
          {
            // Общие заказы
            $orders = new seShopOrder();
            $summ = $orders->getUserSumm(seUserId());
            $summa = $summa + (!empty($summ) ? $summ : 0);
          }
          $fl = $fl * ($this->ifparam($summa, $discount['summ1'], $discount['if_summ1']) 
		  * $this->ifparam($summa, $discount['summ2'], $discount['if_summ2']));
        }

        if (!empty($discount['if_count1']) || !empty($discount['if_count2']))
        {
    	    $fl = $fl * $this->ifparam($this->count_goods, $discount['count1'], $discount['if_count1']) 
            * $this->ifparam($this->count_goods, $discount['count2'], $discount['if_count2']);
        }


        $week = $discount['week'];
        if (isset($week[date('w')-1]))
        {
            $fl = $fl && ($week[date('w')-1] == 1);
        }

        if ($fl)
        {
            if (($discount['type'] == 'i'))
            {
                if (($discount['id_group']) && ($discount['priority'] == 1))
                    $pers_discount_gr_1 = $discount['percent']; // Персональная скидка на группу с приоритетом 1
                elseif (($discount['id_group']) && ($discount['priority'] == 2))
                    $pers_discount_gr_2 = $discount['percent']; // Персональная скидка на группу с приоритетом 2
                elseif (($discount['id_price']) && ($discount['priority'] == 1))
                    $pers_discount_pr_1 = $discount['percent']; // Персональная скидка на товар с приоритетом 1
                elseif (($discount['id_price']) && ($discount['priority'] == 2))
                    $pers_discount_pr_2 = $discount['percent']; // Персональная скидка на товар с приоритетом 2       
            }
            else                        
                $discountproc = $discount['percent'];
        }
      }
    }

    // Определяем, какую из скидок выбрать окончательной
    if ($pers_discount_gr_2)
        $discountproc = $pers_discount_gr_2;
    elseif ($pers_discount_gr_1)
        $discountproc = $pers_discount_gr_1;
    elseif ($pers_discount_pr_2)
        $discountproc = $pers_discount_pr_2;
    elseif ($pers_discount_pr_1)
        $discountproc = $pers_discount_pr_1;   


    if ($discountproc < $this->userdiscount)
    {
        $discountproc = $this->userdiscount;
    }

    if ($shopprice->max_discount > 0 && $shopprice->max_discount < $discountproc)
    {
        $discountproc = $shopprice->max_discount;
    }
    return $discountproc;
  }

  /**
   * Специальное предложение
   */
  public function special_price($dateorder = '')
  {
    if ($this->shopprice->special_price == 'N') return 0;
    $shopprice = $this->shopprice;
    $discountproc = 0;
    $discount = $shopprice->getSpecial($dateorder);
    if (empty($discount)) {
        return $this->userdiscount;
    } 
    $discountproc = $discount->newproc;
    if ($shopprice->max_discount > 0 && $shopprice->max_discount < $discountproc)
    {
        $discountproc = $shopprice->max_discount;
    }

    return $discountproc;
  }

  public function execute()
  {
 	$specialproc = $this->special_price();

	if ($specialproc == 0)
 	{
    	    $discountproc = $this->discount_price();
  	} else {
    	    $discountproc = $specialproc + ($this->userdiscount*(100-$specialproc)/100);
	}
	if ($this->shopprice->max_discount > 0 && $this->shopprice->max_discount < $discountproc) {
    	    $discountproc = $this->shopprice->max_discount;
	}
 	return $discountproc;
  }

  public function getUserDiscount($user_id){
    if (class_exists('seCompany')){
	$companys = new seCompany();
	$company_id = $companys->getIdInCompany($user_id);
	// If not is client
	if ($companys->getUserStatus($user_id) != 1){
    	    $companys->find($company_id);
    	    $cstatuss = new seTable('se_company_status');
    	    $cstatuss->find($companys->status_id);
    	    return $cstatuss->discount;
	}
    } else {
	$user = new sePerson();
        $user->select('discount');
        $user->find($user_id);
        return intval($user->discount);
    } 
    return 0;
  }

}