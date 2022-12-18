<?php

if (!function_exists('showPaymentList')) {
function showPaymentList($section, $path, $order) {
    $__data = seData::getInstance();
    ob_start();
    include $path . '/php/subpage_payitem.php';
    include $path . '/tpl/subpage_payitem.tpl';
    //include $__data->include_tpl($section, 'subpage_payitem');
    $content = ob_get_contents(); 
    ob_end_clean();
    return $content;
}
}

if (!function_exists('isPostPayment')){
function isPostPayment($id_order) {
    $shop_order = new seTable('shop_order', 'so');
    $shop_order->select('so.id');
    $shop_order->innerJoin('shop_payment sp', 'so.payment_type=sp.id');
    $shop_order->where('so.id=?', $id_order);
    $shop_order->andWhere('sp.way_payment="a"');
    $shop_order->fetchOne();
    return $shop_order->isFind();
}
}
?>