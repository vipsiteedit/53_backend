<?php

/**
 * Класс создания заказа
 * 
 */

class plugin_shopOrder40
{
	private $incart = array();
	private $indelivery = array();
	private $lang = 'rus';
	private $basecurr = 'RUR';
	private $email;
	private $param = array('Код', 'Наименование', 'Цена', 'Скидка', 'Кол-во', 'Сумма');

	private $user = null;
	private $user_id;
	private $username = '';
	private $userdiscount = 0;
	private $usergroup = 1;
	private $useremail = '';
	private $charset = 'Win-1251';
	private $encode = 'KOI8-R';
	private $goodslist = '';
	private $summ_discount = 0;
	private $summ_delivery = 0;
	private $summ_order = 0;
	private $show_summ_order = '';
	private $show_summ_discount = '';
	private $show_summ_delivery = '';
	private $show_summ_all = '';
  
	public $commentary = '';
	public $inpayee = false;
	public $date_credit='null';
	public $payment_type = '';

	/**
	* @param integer $user_id	ID пользователя
	* @param array	$incart		Массив товаров	array('price_id'=>1,'count'=>1,'name'=>'','action'=>'1000011122:version=6')
	**/
	function __construct($user_id, $incart = array(), $name_user = '')
	{
		$this->lang = se_getlang();
		$this->incart = $incart;
		$this->user_id = $user_id;
		// ### Данные о клиенте

		$this->basecurr = se_baseCurrency();
		if ($this->user_id){
			$this->user = new seUser();
			$this->user->find($user_id);
			$person = $this->user->getPerson();

			$this->username = trim($person->last_name . ' ' . $person->first_name . ' ' . $person->sec_name);
			$this->userdiscount = $person->discount;

			//$this->usergroup = $this->user->a_group;
			$this->useremail = $person->email;
		} else {
			$this->userdiscount = 0;
			$this->username = $name_user;
		}
	}

	public function getItemList()
	{
		$data = array();
		$shopprice = new seShopPrice();
		$sum_cart = 0;
		foreach ($this->incart as $item)
		{
			$price_id = $item['price_id'];
			$countitem = intval($item['count']);
			$shopprice->select();
			$shopprice->where('id=?', $price_id);
			$shopprice->andWhere("enabled='Y'");
			$shopprice->fetchOne();

			if ($shopprice->id && $countitem > 0)
			{
				$sum_cart += se_MoneyConvert($shopprice->price * $countitem, strval($shopprice->curr), strval($this->basecurr));
			}
		}

		foreach ($this->incart as $item)
		{
			$price_id = $item['price_id'];
			$count = intval($item['count']);
			$shopprice->select();
			$shopprice->where('id=?', $price_id)->andWhere("enabled='Y'")->fetchOne();


			if ($shopprice->id)
			{
				$summ = se_MoneyConvert($shopprice->price * $count, $shopprice->curr, $this->basecurr);
				$bonus = se_MoneyConvert($shopprice->bonus, $shopprice->curr, $this->basecurr);

				$shopdiscount = new plugin_shopDiscount40($shopprice->id, $sum_cart, $summ, $count, $this->user_id);
				$discountproc = $shopdiscount->execute();
				
                                // Рассчет скидок на товар вычисляется из бонусной стоимости
				$bonus = floatval($bonus);

				if (isset($item['discount']))
				{
					$discount = $item['discount'];
                                        $discount = se_MoneyConvert($discount, $item['curr'], $this->basecurr);
				} 
				else 
				{
					if (empty($bonus))
						$bonus = $shopprice->price;
					if ($this->userdiscount > $discountproc) 
						$discountproc = $this->userdiscount;
          
					$discount = round($discountproc / 100 * $bonus, 2);
				}
			    if (empty($item['name'])){
					$item['name'] = $shopprice->name;
				}
				
				/*if (empty($item['action']))
				{
					$item['name'] = (empty($item['name']) ? $shopprice->name : $item['name']);
				}
				else
				{
					// Если заказ определяется по типу
					list($action_serial, ) = explode(":", $item['action']);
					if (empty($item['name']))
					{
						$item['name'] = $shopprice->name;
					}
					$item['name'] .= ' :: ' . $action_serial;
				}*/
				
				if (!empty($item['paramsname'])){
					$item['name'] .= ' ('.$item['paramsname'].')';
				} elseif(!empty($item['params'])){
					$param = new plugin_ShopParams40($value['params']);
					$item['name'] .= ' ('.$param->getParamsName().')';
					unset($param);    
				}
 
				if (!empty($item['action'])){
					// Если заказ определяется по типу
					$action = $item['action'];
					list($action_serial, ) = explode(":", $item['action']);
					$item['name'] .= ' :: ' . $action_serial;
				} else $action = '';
        
				if (isset($item['price'])) 
				{
					if ($item['curr'] == '')
						$item['curr'] = $this->basecurr;
				
					$price = se_MoneyConvert($item['price'], $item['curr'], $this->basecurr);
				}
				else 
				{
					$price = se_MoneyConvert($shopprice->price, $shopprice->curr, $this->basecurr);
				}
        
				$data[] = array('price_id' => $price_id, 'code' => $shopprice->article, 'discount' => $discount, 'count' => $count, 
								'action' => $action, 'name' => $item['name'], 'price' => $price, 
								'curr' => $this->basecurr, 'commentary'=>$item['commentary']);

			} 
			else 
			{
				if (!empty($item['curr'])){
					$price = se_MoneyConvert($item['price'], $item['curr'], $this->basecurr);
                                        $discount = se_MoneyConvert($item['discount'], $item['curr'], $this->basecurr);  
				}
		
				$data[] = array('price_id' => $price_id, 'code' => $item['code'], 'discount' => $discount, 'count' => $item['count'], 
								'action' => $item['action'], 'name' => $item['name'], 'price' => $price,
								'curr' => $this->basecurr,'commentary'=>$item['commentary']);
			}
		}
    
		return $data;
	}


	/**
	* Формирование заказа
	* @param array	$indelivery	Параметры доставки ([id], [phone],[calltime],[address],[postindex])
	* @param string $email		Email пользователя, куда отправлять заказ
	* @param array	$param		Список заголовков  array('Код', 'Наименование','Цена','Скидка','Кол-во','Сумма')
	*/
	public function execute($indelivery = array(), $email = '', $param = array(), $discount = 0)
	{
	//$mass_order[][id],[article],[name],[valuta],[count],[price],[skidka];
    //$mass_delivery[type], [phone],[calltime],[address],[postindex];
    //$action=   (serial;host=50)
    // next = заказ продление программы;
    // host = заказ тарифный план хостинга
    // version = заказ новой версии

		// Формирование данных для отображения заказа
		if (!empty($email)) 
			$this->useremail = $email;
    
		if (!empty($parametr))
			$this->param = $param;

		$this->indelivery = $indelivery;
		
		if (!empty($this->incart))
		{
			$this->summ_discount = 0;
			$this->summ_delivery = 0;
			$this->summ_order = 0;
			$this->goodslist = '';

			// Создание заказа
			$this->summ_delivery = 0.00;
      
			$itemlist = $this->getItemList();
			
			// Доставка
			if (empty($this->indelivery['summ']))
			{
				if (!empty($this->indelivery['id']))
				{
					$delivery = new seTable();
					$delivery->from('shop_deliverytype', 'dt')->find($this->indelivery['id']);
					$deliveryone = ($delivery->forone == 'Y');
					$delsumm = se_MoneyConvert($delivery->price, $delivery->curr, $this->basecurr);
				}
				
				if ($deliveryone) 
				{
					$this->summ_delivery = 0;
					foreach($itemlist as $item){
						$this->summ_delivery += $delsumm * $item['count'];
					}
				} 
				else 
				{
					$this->summ_delivery = $delsumm;
				}
			} 
			else 
			{
				$this->summ_delivery = $this->indelivery['summ'];
			}

			if ($this->user_id)
			{
				$order = new seShopOrder();
				$order->user_id = $this->user_id;
				$order->date_order = date('Y-m-d');
				$order->discount = $discount;
				$order->curr = $this->basecurr;
				$order->status = 'N';
				$order->commentary = $this->commentary;
                                $order->payment_type = $this->payment_type;
				if ($this->inpayee)
					$order->inpayee = 'Y';
				else 
					$order->inpayee = 'N';
      
				if ($this->date_credit != 'null')
					$order->date_credit = $this->date_credit;

				$order->delivery_payee = $this->summ_delivery;
				if ($this->indelivery['id'] > 0)
				{
					$order->delivery_type = $this->indelivery['id'];
				}
				
				$order->delivery_status = 'N';
				// Создаем заказ
				$order_id = $order->save();

				$this->order_id = $order_id;
				if ($order_id > 0)
				{
					// Доставка
					if (!empty($this->indelivery))
					{
						$delivery = new seTable();
						$delivery->from('shop_delivery', 'sd');
						$delivery->id_order = $order_id;
						$delivery->telnumber = $this->indelivery['phone'];
						$delivery->email = $this->useremail;
						$delivery->calltime = $this->indelivery['calltime'];
						$delivery->address = $this->indelivery['address'];
						$delivery->postindex = $this->indelivery['postindex'];
						$delivery->save();
					}
          
					// позиции товаров
					$goods = $order->getGoods();
					foreach ($itemlist as $item)
					{ // Добавляем позиции товаров в заказ
					// ���� ���������� � ������ ���������� - �� ������ ������ � ������ � ��������� ����������
						
						$prices = new seShopPrice();
						$prices->select('presence_count');
						$prices->find($item['price_id']);
						if ($prices->isFind() && $prices->presence_count > 0)
						{
							if ($item['count'] >= $prices->presence_count) 
							{
								$item['count'] = $prices->presence_count;
							}
							$newcount = intval($prices->presence_count - $item['count']);
							$prices->update('presence_count', "'$newcount'");
							$prices->where('id=?', $item['price_id']);
							$prices->save();
						}
						
						$goods->insert();
						$goods->order_id = $order_id;
						$goods->price_id = $item['price_id'];
						$goods->discount = $item['discount'];
						$goods->code = $item['code'];
						$goods->count = $item['count'];
						$goods->nameitem = $item['name'];
						$goods->action = $item['action'];
						$goods->price = $item['price'];
						$goods->commentary = $item['commentary'];
						$goods->save();
						$this->mail_item($item);
					}
    	    
					$this->setShopAccount($this->order_id);
					$this->setShopContract($this->order_id);
				} 
				else
				{
					return 0;
				}
			} 
			else 
			{
				$this->order_id = time() - strtotime('2012-01-01');//date('ymdHis');
				foreach ($itemlist as $item)
				{ // Добавляем позиции товаров в заказ
					// ���� ���������� � ������ ���������� - �� ������ ������ � ������ � ��������� ����������
					$prices = new seShopPrice();
					$prices->select('presence_count');
					$prices->find($item['price_id']);
					if ($prices->isFind() && $prices->presence_count > 0)
					{
						if ($item['count'] >= $prices->presence_count) 
						{
							$item['count'] = $prices->presence_count;
						}
					}
					
					$this->mail_item($item);
				}
			}

			$this->summ_all = floatval($this->summ_order - $this->summ_discount + $this->summ_delivery);

			$this->show_summ_order = se_formatMoney($this->summ_order, $this->basecurr);
			$this->show_summ_discount = se_formatMoney($this->summ_discount, $this->basecurr);
			$this->show_summ_delivery = se_formatMoney($this->summ_delivery, $this->basecurr);
			$this->show_summ_all = se_formatMoney($this->summ_all, $this->basecurr);

			$vars = $this->mailtemplate();

			// письмо клиенту
			$mails = new plugin_shopmail($this->order_id, 0, 'html');
			$mails->sendmail('orderuser', $this->useremail, $vars);
			$mails->sendmail('orderadm', '', $vars);
			
			return $order_id;
		}
	}

	// Подготовка данных для отправки письма (строка заказа в виде html и подсчет общей суммы)
	private  function mail_item($item)
	{
		$summ_price = ($item['price'] - $item['discount']) * $item['count'];
        $this->goodslist .= 
			'<tr vAlign=middle>
			<td width=200>' . $item['code'] . '&nbsp;</td>
			<td>' . $item['name'] . '&nbsp;</td>
			<td>' . se_formatNumber($item['price']) . '&nbsp;</td>
			<td>' . se_formatNumber($item['discount']) . '&nbsp;</td>
			<td>' . $item['count'] . '&nbsp;</td>
			<td>' . se_formatNumber($summ_price) . '&nbsp;</td>
			</tr>';
		$this->summ_discount += $item['discount'] * $item['count'];
		$this->summ_order += $item['price'] * $item['count'];
	}

	private function setShopAccount($order_id)
	{
		$table = new seShopAccount();
		$max = $table->maxAccount();
		$table->insert();
		$table->order_id = $order_id;
		$table->account = $max + 1;
		$table->date_order = date('Y-m-d H:i:s');
		$table->save();
	}

	private function setShopContract($order_id)
	{
		$table = new seShopContract();
		$max = $table->maxNumber();
		$table->insert();
		$table->id_author = $this->user_id;
		$table->id_order = $order_id;
		$table->number = $max + 1;
		$table->date = date('Y-m-d');
		$table->save();
	}

	private function mailtemplate()
	{
		// Создание шаблона письма
		if (!empty($this->indelivery))
		{
			$mail['ORDER.TELNUMBER'] = $this->indelivery['phone'];
			$mail['ORDER.CALLTIME'] = $this->indelivery['calltime'];
			$mail['ORDER.ADDRESS'] = $this->indelivery['address'];
			$mail['ORDER.POSTINDEX'] = $this->indelivery['postindex'];
			//        $delivery->telnumber = $this->indelivery['phone'];
			//        $delivery->email = $this->useremail;
			//        $delivery->calltime = $this->indelivery['calltime'];
			//        $delivery->address = $this->indelivery['address'];
			//        $delivery->postindex = $this->indelivery['postindex'];
			$mail['ORDER.VOLUME'] = $this->indelivery['volume'];
			$mail['ORDER.WEIGHT'] = $this->indelivery['weight'];
		}

		$mail['ORDER.COMMENTARY'] = $this->commentary;
		$mail['ORDER.EMAIL'] = $this->useremail;
		$mail['THISNAMESITE'] = $_SERVER['HTTP_HOST'];
		$mail['CURDATE'] = date("d.m.Y H:i:s");
		$mail['NAMECLIENT'] = $this->username;
		$mail['SHOP_ORDER_NUM'] = sprintf("%06u", $this->order_id);
		$mail['SHOP_ORDER_VALUE_LIST'] = '
			<table cellSpacing="1" cellPadding="3" border="0" width="100%">
  			<tr class="tableRow" id="tableHeader" vAlign="middle">
    			<td class="cartorder_art" width="50">' . $this->param[0] . '</td>
    			<td class="cartorder_name">' . $this->param[1] . '</td>
    			<td class="cartorder_price" width="50">' . $this->param[2] . '</td>
    			<td class="cartorder_discount" width="50">' . $this->param[3] . '</td>
    			<td class="cartorder_cn" width="50">' . $this->param[4] . '</td>
    			<td class="cartorder_summ" width="50">' . $this->param[5] . '</td>
  			</tr>
  			' . $this->goodslist . '
			</table>';
		$mail['SHOP_ORDER_SUMM'] = se_formatMoney($this->summ_order - $this->summ_discount, $this->basecurr);
		$mail['SHOP_ORDER_DEVILERY'] = $this->show_summ_delivery;
		$mail['SHOP_ORDER_TOTAL'] = $this->show_summ_all;
		$mail['SHOP_ORDER_DISCOUNT'] = $this->show_summ_discount;
		
		return $mail;
	}
}
?>