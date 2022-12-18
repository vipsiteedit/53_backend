<?php

list($newslist, $MANYPAGE) = $clnews->getList(trim($section->parametrs->param20), $limit);
$items = array();
unset($section->newss);

foreach($newslist as $item){
   $item['note'] = str_replace('&nbsp;', '', ($item['note']) ? $item['note'] :  se_LimitString(strip_tags($item['text']), $nchar, ' ..'));
   $item['link'] = (trim($section->parametrs->param38)) ? seMultiDir() . '/' . trim($section->parametrs->param38) . '/' . $item['url'] . SE_END : $__data->getLinkPageName() . $item['url'] . SE_END;
   $item['news_date'] = date('d.m.Y', strtotime($item['news_date']));
   $__data->setItemList($section, 'newss', $item);
}

//удаление новости через панель редактрования
if ($delete_id = getRequest('delete', 1)){
    $result = $clnews->delete($delete_id);
    if ($result['status'] == 'success') {
        Header("Location: ".seMultiDir()."/" . $_page . '/?' . time());
        exit();
    }
}
?>
