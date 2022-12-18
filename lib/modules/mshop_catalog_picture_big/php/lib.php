<?php

if (!function_exists('getTreesCatalog')){
function getTreesCatalog($d, $s, $items, $objname, $level = 1){
   foreach($items as $item){
    $d->setItemList($s, strval($objname), $item);
    if (!empty($item['menu']) && $level < 3) {
         getTreesCatalog($d, $s, $item['menu'], strval('sub'.$objname.$item['id']), $level + 1);
    }
   }
}}

?>