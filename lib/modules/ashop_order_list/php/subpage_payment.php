<?php

if (isRequest('GoToPayOrder')) {
    if (md5(date('Y-m-d').$order_id) == $_POST['KEY']) {
        $payee = new plugin_payment_payee($order_id, 0,  se_baseCurrency(), 'Оплата с лицевого счета:');
        if ($payee->execute() < 0) {
            $blank = '<span class="payResult">Оплата невозможна! Недостаточно средств на лицевом счете</span>';    
        } else {
            $blank = '<span class="payResult">Оплата с лицевого счета успешно проведена!</span>';
        }
        $type = '';
    }
} 
else if (!$payment_id) {
    $key = md5(date('Y-m-d') . $order_id);
    $so = new seShopOrder();
    $so->find($order_id); 
    $idauth = $so->id_author;
    $summa = $so->getSumm();
    $summa= se_MoneyConvert($summa, $so->curr, se_baseCurrency());
    $useraccount = new seUserAccount();
    $paysumm = $useraccount->getSumm($idauth);
    $blank = ' 
        <div class="warning">Подтвердите оплату заказа </div>
        <div class="title"><span class="txt">Оплата с лицевого счета:</span><b id="iduseracc">' . seUserId() . '</b>
        <span class="order">Оплата заказа: </span><span class="num">&nbsp;' . "{$order_id}" . '</span></div>
        <div class="summ"><span class="txt">Сумма заказа</span><span class="num">' . se_formatMoney($summa, se_baseCurrency()) . '</span></div>';
    if ($summa > $paysumm) {
        $blank .= '<span class="notEnoughMoney">Оплата невозможна! Недостаточно средств на лицевом счете</span>';
    } else { 
        $blank .= ' 
        <form style="margin:0px;" action="" method="post">
        <input type="hidden" name="KEY" value="' . $key . '">
        <input class="buttonSend send" type="submit" name="GoToPayOrder" value="Оплатить"></form>
        ';
    }
    $type = '';
} 
else {
    $spay = new plugin_payment($order_id, $payment_id);
    $blank = $spay->blank();
    $type = $spay->blanktype();
}

?>