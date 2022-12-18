<?php

$last_name    = htmlspecialchars_decode($persons->last_name);
$first_name   = htmlspecialchars_decode($persons->first_name);
$sec_name     = htmlspecialchars_decode($persons->sec_name);

$personallink = seMultiDir() . '/' .$__data->getPageName() . '/personal/edit/';
$passwlink = seMultiDir() . '/' .$__data->getPageName() . '/password/edit/';

if ($persons->avatar)
 $avatar = $image_dir . $persons->avatar;
else
 $avatar = '/lib/plugins/plugin_shop/no_foto.gif';
?>