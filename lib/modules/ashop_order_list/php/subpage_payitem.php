<?php

$id_order = $order['id'];
$order_amount = $order['amount'];

$spay = new plugin_payment($id_order);
$paylist = $spay->getList($order['delivery_type'], false, true);

$lang = se_getlang();
unset($section->paymentlist);   
foreach ($paylist as $val) {  
    $val['linkblank'] = '/' . $__data->req->page . '/merchant/blank/';
    if (!empty($val['logoimg'])) { 
        $val['image'] = '/images/' . $lang . '/shoppayment/' . $val['logoimg'];
    }
    $hash_pay = md5($val['id'] . '_' . $id_order . '3dfgvj');
    $val['invnum'] = seMultiDir() . '/' . $__data->req->page . '/invnum/' . $val['id'] . '_' . $id_order . '/' . $hash_pay . '/';
    $__data->setItemList($section, 'paymentlist', $val);
}

?>