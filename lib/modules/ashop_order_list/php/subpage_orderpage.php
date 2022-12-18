<?php

$order = new seTable('shop_order', 'so');
$order->select('so.*, sa.`account` AS accounts,sm.name_payment');
$order->leftjoin('shop_payment sm', 'sm.id = so.payment_type'); 
$order->leftjoin('shop_account sa', 'sa.id_order = so.id'); 
$order->where('so.id=?', $order_id);
$order->andwhere('so.id_author=?', $id_user);
$order->fetchOne();

$show_cancel = (!in_array($order->status, array('Y', 'K', 'P')));

$curr_order = $order->curr;
$order_num = sprintf("%06u", $order_id);
$order_paid = ($order->status == 'Y');
$delivery_type = $order->delivery_type;
$discount = se_MoneyConvert($order->discount, $curr_order, $showcurr);

### Список товаров в заказе ###
$torder = new seTable('shop_tovarorder', 'st');
$torder->select('sp.measure, sp.id, sp.article, sp.name, st.nameitem, st.price, st.discount, st.count, st.license, st.commentary, so.date_order');
$torder->leftjoin('shop_price sp', 'sp.id = st.id_price');
$torder->innerjoin('shop_order so', 'so.id = st.id_order');
$torder->where("st.id_order = ?", $order_id);
$goods = $torder->getList();
unset($torder);

$amount = 0; 
foreach ($goods as $key => $line) {
    $price = se_MoneyConvert($line['price'] - $line['discount'], $curr_order, $showcurr);
    $line['price'] = se_formatMoney($price, $showcurr);
    $line['count'] = round($line['count']*1000)/1000;
    $sum = $price * $line['count'];
    $line['amount'] =  se_formatMoney($sum, $showcurr);
    $line['key'] = $key + 1;      
        
    $amount += $sum; 
    
    $__data->setItemList($section, 'orderpagelist', $line);
}
$amount = se_formatMoney($amount - $discount, $showcurr);
$discount = se_formatMoney($discount, $showcurr);

// Информация о доставке 
if ($delivery_type) {
    $delivery = new seTable('shop_deliverytype');
    $delivery->find($delivery_type);
    $delivery_name = $delivery->name;
    $delivery_sum = se_formatMoney(se_MoneyConvert($order->delivery_payee, $curr_order, $showcurr), $showcurr);
        
    switch ($order->delivery_status) {
            case 'Y':
                $delivery_status = $section->language->lang039 . ' <span>' . date('d.m.Y', strtotime($order->delivery_date)) . '</span>'; 
                break;
            case 'P':
                $delivery_status = $section->language->lang040; 
                break;
            case 'N':
            default:
                $delivery_status = $section->language->lang041;
    }
    unset($delivery);
}

// ### Информация об оплате ###
if ($order_paid) {
    $payment_name = ($order->name_payment != '') ? $order->name_payment : $section->language->lang042;
    $payment_sum = se_formatMoney($order->transact_amount, $order->transact_curr);
    $transact_id = $order->accounts;                   
}      

?>