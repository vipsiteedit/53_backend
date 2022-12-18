<?php

$bbs = new seTable('bbs');
//$bbs->select('text,short,img');
$bbs->select('`id`, `text`, `short`, `img`, `date`, `name`,`town`,`email`, `url` , `id_author`, `phone`');
$bbs->find($id);
$fulltext = nl2br($bbs->text); 
  
$titlepage = $bbs->short;
$imgfull = '';

$record_date = date('d.m.Y', strtotime($bbs->date));
$record_name = $bbs->name;
$record_town = $bbs->town;
$record_phone = $bbs->phone;
$record_email = $bbs->email;

if ($bbs->img != '') {
    $imgfull = '/images/bbs/' . $bbs->img;  
}

?>