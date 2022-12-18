<?php

$error = $success = '';

if (isRequest('save_personal')) {
    if (isset($_FILES['avatar'])) {
        $filename = $id_user . '_' . basename($_FILES['avatar']['name']);
        $tempname = $_FILES['avatar']['tmp_name'];
        $error_file = $_FILES['avatar']['error'];
        $type = $_FILES['avatar']['type'];
        
        if (!is_dir(getcwd().$image_dir))
   mkdir(getcwd().$image_dir);
        
        if (($type == 'image/gif' || $type == 'image/jpeg' || $type == 'image/png') && $_FILES['avatar']['size'] != 0 && $error_file == UPLOAD_ERR_OK) {
            if (move_uploaded_file($tempname, getcwd().$image_dir . $filename)) {
                $prev = se_getDImage($image_dir . $filename, '100x100', 'm', '', 0x0000FF, 'center', '', 50, 'create'); 
                if ($prev) {
                    if (se_rename(getcwd().$prev, getcwd().$image_dir . basename($prev)))
                        $filename = basename($prev);           
                }
                $persons->avatar = $filename;  
            }    
        }
    }
    
         
    $persons->last_name = getRequest('last_name',3);
    $persons->first_name = getRequest('first_name',3);
    $persons->sec_name =  getRequest('sec_name',3);
    $persons->birth_date = getRequest('birth_date',3);
    $persons->email= getRequest('email', 3);
    $persons->doc_ser = getRequest('doc_ser');
    $persons->doc_num = getRequest('doc_num');
    $persons->doc_registr = getRequest('doc_text',3);
    $persons->post_index = getRequest('post_index');
    //$persons->town_id = getRequest("city", 1);
    $persons->addr = getRequest('address', 3);
    $persons->phone = getRequest('phone',3);
    $persons->icq = getRequest('skype');
    $persons->icq = getRequest('icq');
    $persons->sex = getRequest('sex');

    if (empty($error)){
        if ($persons->save()) {
            $success = $section->language->lang001;
        } 
    }       
}

$last_name = htmlspecialchars_decode($persons->last_name);
$first_name = htmlspecialchars_decode($persons->first_name);
$sec_name = htmlspecialchars_decode($persons->sec_name);
$birth_date = $persons->birth_date;
$doc_ser = htmlspecialchars_decode($persons->doc_ser);
$doc_num = htmlspecialchars_decode($persons->doc_num);
$doc_text = htmlspecialchars_decode($persons->doc_registr);
$post_index = htmlspecialchars_decode($persons->post_index);
$city_id = htmlspecialchars_decode($persons->town_id);
$address = htmlspecialchars_decode($persons->addr);
$phone = htmlspecialchars_decode($persons->phone);
$email = htmlspecialchars_decode($persons->email);
$skype = htmlspecialchars_decode($persons->skype);
$icq = htmlspecialchars_decode($persons->icq);
$sex = htmlspecialchars_decode($persons->sex);

if ($persons->avatar)
 $avatar = $image_dir . $persons->avatar;
else
 $avatar = '/lib/plugins/plugin_shop/no_foto.gif';

?>