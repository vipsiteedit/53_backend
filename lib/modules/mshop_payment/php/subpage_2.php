<?php

$FP = getRequest('FP', VAR_INT);
if (isRequest('GoToPayOrder')) {
    if (md5(date('Y-m-d').$ORDER_ID) == $_POST['KEY']) {
        $payee = new plugin_payment_payee($ORDER_ID, 0,  se_baseCurrency(), $section->parametrs->param22);
        if ($payee->execute() == -1) {
            $SUB_PAY_EXECUTE = "<span class=\"payResult\">" . $section->parametrs->param27 . "</span>";    
        } else {
            $SUB_PAY_EXECUTE = "<span class=\"payResult\">" . $section->parametrs->param28 . "</span>";
        }
    }
} else if (!$FP) {
    $key = md5(date('Y-m-d') . $ORDER_ID);
    $so = new seShopOrder();
    $so->find($ORDER_ID); 
    $idauth = $so->id_author;
    $summa = $so->getSumm();
    $summa= se_MoneyConvert($summa, $so->curr, se_baseCurrency());
    $useraccount = new seUserAccount();
    $paysumm = $useraccount->getSumm($idauth);
    $SUB_PAY_EXECUTE = ' 
        <div class="warning">'.$section->parametrs->param23.'</div>
        <div class="title"><span class="txt">' . $section->parametrs->param22 . '</span><b id="iduseracc">' . seUserId() . '</b>
        <span class="order">' . $section->parametrs->param12 . '</span><span class="num">&nbsp;' . "{$ORDER_ID}" . '</span></div>
        <div class="summ"><span class="txt">' . $section->parametrs->param26.
        '</span><span class="num">' . se_formatMoney($summa, se_baseCurrency()) . '</span></div><br>';
    if ($summa > $paysumm) {
        $SUB_PAY_EXECUTE .= "<span class=\"notEnoughMoney\">" . $section->parametrs->param27 . "</span>";
    } else { 
        $SUB_PAY_EXECUTE .= ' 
        <form style="margin:0px;" action="" method="post">
        <input type="hidden" name="ORDER_ID" value="' . $ORDER_ID . '">
        <input type="hidden" name="KEY" value="' . $key . '">
        <input class="buttonSend send" type="submit" name="GoToPayOrder" value="' . $section->parametrs->param24 . '"></form>
        ';
    }
} else {
    $payment->select('blank');
    $payment->find($FP);
    $SUB_PAY_EXECUTE = $payment->blank;
  // Заполняю переменными
  //'.md5($ID_AUTHOR).'
    $_SESSION['SE_PAYMENT'] = array('fp' => $FP, 'order_id' => $ORDER_ID, 'lang' => $lang, 'curr' => $THISCURR);
    $SUB_PAY_EXECUTE = se_macrocomands($SUB_PAY_EXECUTE, $FP, $ORDER_ID, $section->parametrs->param25, $lang);
}

?>