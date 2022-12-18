<?php

if ($page_brand) {
    $path_list = true;
    
    if ($brand) {
        $path[] = array(
            'link' => ''/*seMultiDir() . '/' . $shoppath . '/brand/' . urlencode($brand['code']) . URL_END*/,
            'name' => $brand['name'],  
            'separator' => ''
        );
    }
    
    $path[] = array(
        'link' => !empty($brand) ? seMultiDir() . '/' . $shoppath . '/brand' . URL_END : '',
        'name' => $section->language->lang006,  
        'separator' => !empty($brand) ? (string)$section->parametrs->param17 : ''
    );
    
    $path[] = array(
        'link' => seMultiDir() . '/' . $shoppath . URL_END,
        'name' => $section->language->lang001,  
        'separator' => (string)$section->parametrs->param17
    );
    
    $path_pos = 2;
    
    while (!empty($path)) {
        $item = array_pop($path);
        $item['pos'] = $path_pos++;
        $__data->setItemList($section, 'pathgroup', $item);        
    }
    
}
elseif ($section->parametrs->param33 == 'M' && $shopcatgr == $basegroup) {
    $path_list = false;
}
else {
    $separator = '';
    $path = array();
    
    $parents = $psg->getParents($shopcatgr, true);
    
    if (!empty($parents)) {
        foreach ($parents as $key => $val) {
            if ($basegroup == $val['id'])
                continue;
            $path[] = array(
                'link' => ($key == 0) ? '' : seMultiDir() . '/' . $shoppath . '/cat/' . urlencode($val['code']) . '/',
                'name' => $val['name'],  
                'separator' => $separator
            );
            $separator = (string)$section->parametrs->param17;
        }
    }

    $path[] = array(
        'link' => seMultiDir() . '/' . $shoppath . (!empty($basecode) ? '/cat/' . urlencode($basecode) : '') . '/',
        'name' => $section->language->lang001,  
        'separator' => $separator
    );
    $path_list = !empty($path);
    
    $path_pos = 2;
    
    while (!empty($path)) {
        $item = array_pop($path);
        $item['pos'] = $path_pos++;
        $__data->setItemList($section, 'pathgroup', $item);        
    }
}

?>