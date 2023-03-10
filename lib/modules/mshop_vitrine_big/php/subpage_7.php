<?php

foreach($pricelist as $goods){
    list($goods['params']) = getTreeParam($section, 0, $goods['id'], $goods['presence_count'], 0, true, 0, $__MDL_URL);                        

    // --- Округление и сепараторы ---        
    $rounded = ($section->parametrs->param243 == 'Y'); // округление

    if ($section->parametrs->param276 == 'Y') // сепаратор между 1 000 000
        $separator = ' ';
    else
        $separator = '';
                                   
    if ($section->parametrs->param225 == seUserGroupName()) { // optcorp
        $ptype = 1;
        $goods['priceheader'] = $section->parametrs->param227;
    } else if ($section->parametrs->param224 == seUserGroupName()) { // optovik  
        $ptype = 2;
        $goods['priceheader'] = $section->parametrs->param122;
    } else {                                    // розничный покупатель
        $ptype = 0;
        $goods['priceheader'] = $section->parametrs->param121;
    }                        
                   
    $price_id = $goods['id'];
    $goods['listcartparam'] = join(',', $_SESSION['SHOP_VITRINE']['selected'][$price_id]);
    $plugin_amount = new plugin_shopAmount($goods['id'], '', $ptype, 1, 
                                           'param:' . join(',', $_SESSION['SHOP_VITRINE']['selected'][$price_id]), $pricemoney);
    
    $maxcount = $plugin_amount->getPresenceCount();    
    $realprice =  $plugin_amount->getPrice(true);    
    $price_disc = $plugin_amount->showPrice(true, // discounted
                                           $rounded, // округлять ли цену
                                           $separator); // разделять ли пробелами 000 000 
    $pr_without_disc = $plugin_amount->showPrice(false, // discounted
                                          $rounded, // округлять ли цену
                                          $separator); // разделять ли пробелами 000 000
    $discount = $plugin_amount->getDiscount();
                  
    $goods['newprice'] = '';       

    if(floatval($realprice)>0){       //заказ товара с нулевым значение
        if (($discount > 0) && ($section->parametrs->param113 == 'Y')) // отображать поле "Старая цена"
            $goods['newprice'] .= '
              <span style="text-decoration:line-through;" class="old_price" id="old_price_'.$section->id.'_'.$goods['id'].'">'.
                $pr_without_disc.'</span>';
        $goods['newprice'] .= '<span class="new_price" id="price_'.$section->id.'_'.$goods['id'].'">'.$price_disc.'</span>';                         
    }
    unset($plugin_amount);
        
    $goods['compare'] = '';  
    foreach($_SESSION['SHOPVITRINE']['COMPARE'] as $id=>$line){
        if ($line == $goods['id']){
            $goods['compare'] = 'checked';   break;
        }
    }

    $goods['style'] = ($style = !$style) ? "tableRowOdd" : "tableRowEven"; // четные

     // основная картинка
    if(($_SESSION['SHOP_VITRINE']['type']=='t')||($analoggood))
        list($goods['image_prev'], ) = $psg->getGoodsImage($goods['img'], intval($section->parametrs->param206));
    else                  
        list($goods['image_prev'], ) = $psg->getGoodsImage($goods['img'], intval($section->parametrs->param289));
        
    $goods['img_alt'] = htmlspecialchars($goods['img_alt']);    
    if (empty($goods['img_alt']))
            $goods['img_alt'] = htmlspecialchars($goods['name']);   
                 
    if (utf8_strlen($goods['name']) > $nchar) {
        $goods['name'] = se_LimitString($goods['name'], $nchar, ' ...');
    }
    if (($section->parametrs->param207 != '-1') && (utf8_strlen($goods['note']) > intval($section->parametrs->param207))) {
      $goods['note'] = se_limitstring($goods['note'], intval($section->parametrs->param207));
    }

    if ($old_format)
        $goods['linkshow'] = seMultiDir() . "/{$_page}/viewgoods/{$goods['id']}/";
    else
        $goods['linkshow'] = seMultiDir() . "/{$_page}/show/{$goods['code']}/";

    // === Строим прорисовку параметров товара ===
    $psg->getPreviousParamsState($goods['id']); // Для восстановления прежних состояний доп параметра

    list($goods['count'], $goodStyle) = getShopTextCount($section, $goods, $maxcount);

    //есть ли аналогичные товары у данного товара
    if($section->parametrs->param66=='Y'){
        $goods['analogs'] = $psg->isSetGoodsAnalog($option, $goods['id']);        
        if ($goods['analogs']){
            $goods['analogs'] = $section->parametrs->param236;
        } else {
            $goods['analogs'] = '';
        }
    }        

    if(floatval($realprice)>0){       //заказ товара с нулевым значение
        $goods['nullprice'] = '0';       
    } else {
        $goods['nullprice'] = '1';
        $goodStyle = false;        
    }

    // Блокировка кнопки "Заказать"
    if ($section->parametrs->param233 == 'Y') {
        $goods['show_addcart'] = ($goodStyle) ? 'display: inline' : 'display: none';
    } else {
        $goods['show_addcart'] = 'display: inline';
    }
    $__data->setItemList($section, 'objects', $goods);
}
  
 

?>