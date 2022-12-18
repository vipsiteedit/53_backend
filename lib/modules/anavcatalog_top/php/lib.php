<?php

if (!function_exists('getTreesCatalog')){
function getTreesCatalog($d, $s, $items, $objname, $level = 1, $section){
    $col = intval($section->parametrs->param15);
    $k = 1;
    $count_line = count($items);
    $groupimages = new plugin_ShopImages('group');
    foreach($items as $item){
        $item['startrow'] = 0;
        
        if (!empty($item['image']))
            $item['image'] = $groupimages->getPictFromImage($item['image']);
            
        $startcol = ($k - $col);
        $item['midrow'] = (fmod($k, $col) == 0 && $level == 1 && $count_line != $k) ? 1 : 0;
        $k++;  
        $d->setItemList($s, strval($objname), $item);
        if (!empty($item['menu']) && $level < 3) {
            getTreesCatalog($d, $s, $item['menu'], strval('sub'.$objname.$item['id']), $level + 1, $section);
        }
    }
}}

?>