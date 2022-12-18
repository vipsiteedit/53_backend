<?php

$p = new plugin_newslast();  

$list = $p->getNewsList((string)$section->parametrs->param2, (int)$section->parametrs->param1);

foreach ($list as $val) {
    $__data->setItemList($section, 'objects', $val);    
}
?>
