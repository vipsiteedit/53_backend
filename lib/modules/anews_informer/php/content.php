<?php

$clnews = plugin_news::getInstance($opt);
$newslist = $clnews->getItems(trim($section->parametrs->param7), 0, $limit);
$items = array();
$nchar = intval($section->parametrs->param4);
unset($section->objects);

foreach($newslist as $item){
   if($section->parametrs->param11!='Y'){
      $item['note'] = str_replace('&nbsp;', '', ($item['note']) ? $item['note'] :  se_LimitString(strip_tags($item['text']), $nchar, ' ..'));
      $item['news_date'] = date('d.m.Y', strtotime($item['news_date']));
   }
   $item['shownews'] = seMultiDir(). '/show'.$section->parametrs->param7.'/'. $item['id'].'/';
   $__data->setItemList($section, 'objects', $item);
}

?>