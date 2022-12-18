<?php

if (!empty($pricelist)) {
    $plugin_image = new plugin_ShopImages();
    $img_style = $plugin_image->getSizeStyle($section->parametrs->param48);  
    foreach($pricelist as $line) {    
        if ($section->parametrs->param21 == 'Y'){
            $line['ratio'] = round(100 / 5 * $line['rating']);
            $line['rating'] = round($line['rating'], 2);
        }
        
        if ($section->parametrs->param22 == 'Y') {
            $line['image_prev'] = $plugin_image->getPictFromImage($line['img'], $section->parametrs->param48, 's');
        }
        
        if ($line['modifications']) {
            if ($section->parametrs->param49 == 'radio' || $section->parametrs->param49 == 'list') {
                $line['param_block'] = showModifications($__data, $__MDL_ROOT, $section->parametrs->param49, $line['id'], 's' . $razdel);    
            }
            else {
                $plugin_modifications = new plugin_shopmodifications($line['id'], true);
                $plugin_modifications->getModifications(true);
            }   
        }
    
        $selected = !empty($_SESSION['modifications'][$line['id']]) ? $_SESSION['modifications'][$line['id']] : '';
        
        $plugin_amount = new plugin_shopamount53(0, $line, 0, 1, $selected);
        
        $count_goods = (int)$plugin_amount->getPresenceCount();
        
        if (empty($count_goods)) {
            
            $line['disabled'] = 'disabled';
            $line['empty_class'] = ' emptyGoods';
            $line['btn_title'] = $section->language->lang008;
        }
        else{
            $line['btn_title'] = $section->language->lang007;
        }
        if ($section->parametrs->param26 == 'Y') {
            $round = ($section->parametrs->param29 == 'Y');  
            $line['new_price'] = $plugin_amount->showPrice(true, $round, ' ');
            
            $discount = $plugin_amount->getDiscount();
            
            if ($discount > 0) {
                $line['old_price'] = $plugin_amount->showPrice(false, $round, ' '); 
                $line['percent'] = 0 - $plugin_amount->getDiscountProc();      
            }                                    
        }
      
        $line['name'] = htmlspecialchars($line['name']);
        if ($section->parametrs->param23 == 'Y')
            $line['view_group'] = seMultiDir() . '/' . $vitrine_page . '/cat/' . urlencode($line['code_gr']) . '/';
        
        $line['view_goods'] = seMultiDir() . '/' . $vitrine_page . '/show/' . urlencode($line['code']) . '/';
        $__data->setItemList($section, 'objects', $line);
    }
}
?>