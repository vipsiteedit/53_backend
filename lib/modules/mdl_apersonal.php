<?php
function module_apersonal($razdel, $section = null)
{
 $__module_subpage = array();
 $__data = seData::getInstance();
 $thisreq = $__data->req;
 $_page = $thisreq->page;
 $_razdel = $thisreq->razdel;
 $_sub = $thisreq->sub;
 if (strpos(dirname(__FILE__),'/lib/modules'))
   $__MDL_URL = 'lib/modules/apersonal';
 else $__MDL_URL = 'modules/apersonal';
 $__MDL_ROOT = dirname(__FILE__).'/apersonal';
 $this_url_module = $__MDL_ROOT;
 $url_module = $__MDL_URL;
 if (file_exists($__MDL_ROOT.'/php/lib.php')){
	require_once $__MDL_ROOT.'/php/lib.php';
 }
 if (count($section->objects))
	foreach($section->objects as $record){ $__record_first = $record->id; break; }
 if (file_exists($__MDL_ROOT.'/i18n/'.se_getlang().'.xml')){
	$__langlist = simplexml_load_file($__MDL_ROOT.'/i18n/'.se_getlang().'.xml');
	append_simplexml($section->language, $__langlist);
	foreach($section->language as $__langitem){
	  foreach($__langitem as $__name=>$__value){
	   $__name = strval($__name);
	   $__value = strval($section->traslates->$__name);
	   if (!empty($__value))
	     $section->language->$__name = $__value;
	  }
	}
 }
 if (file_exists($__MDL_ROOT.'/php/parametrs.php')){
   include $__MDL_ROOT.'/php/parametrs.php';
 }
 // START PHP
 $id_user = seuserid();
  
 $id_group = seUserGroup();
  
 if (!$id_group) {
     return;
 }   
 
 $image_dir = '/images/' . se_getLang() . '/contacts/';
 
 $persons = new sePerson();
 $test = $persons->find($id_user); 
 
 if (isRequest('personal')) {
     $__data->goSubName($section, 'personal');        
 }
 if (isRequest('password')) {
     $__data->goSubName($section, 'password');         
 }
 
 $last_name    = htmlspecialchars_decode($persons->last_name);
 $first_name   = htmlspecialchars_decode($persons->first_name);
 $sec_name     = htmlspecialchars_decode($persons->sec_name);
 $birth_date = $persons->birth_date;
 $doc_ser      = htmlspecialchars_decode($persons->doc_ser);
 $doc_num      = htmlspecialchars_decode($persons->doc_num);
 $doc_text  = htmlspecialchars_decode($persons->doc_registr);
 $post_index   = htmlspecialchars_decode($persons->post_index);
 $city_id      = htmlspecialchars_decode($persons->town_id);
 $address         = htmlspecialchars_decode($persons->addr);
 $phone        = htmlspecialchars_decode($persons->phone);
 $email        = htmlspecialchars_decode($persons->email);
 $skype        = htmlspecialchars_decode($persons->skype);
 $icq          = htmlspecialchars_decode($persons->icq);
 $sex = htmlspecialchars_decode($persons->sex);

 // include content.tpl
 if((empty($__data->req->sub) || $__data->req->razdel!=$razdel) && file_exists($__MDL_ROOT . "/tpl/content.tpl")){
	if (file_exists($__MDL_ROOT . "/php/content.php"))
		include $__MDL_ROOT . "/php/content.php";
	ob_start();
	include $__data->include_tpl($section, "content");
	$__module_content['form'] =  ob_get_contents();
	ob_end_clean();
 } else $__module_content['form'] = "";
 //BeginSubPagepersonal
 $__module_subpage['personal']['admin'] = "";
 $__module_subpage['personal']['group'] = 0;
 $__module_subpage['personal']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='personal' && file_exists($__MDL_ROOT . "/tpl/subpage_personal.tpl")){
	include $__MDL_ROOT . "/php/subpage_personal.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_personal");
	$__module_subpage['personal']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagepersonal
 //BeginSubPagepassword
 $__module_subpage['password']['admin'] = "";
 $__module_subpage['password']['group'] = 0;
 $__module_subpage['password']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='password' && file_exists($__MDL_ROOT . "/tpl/subpage_password.tpl")){
	include $__MDL_ROOT . "/php/subpage_password.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_password");
	$__module_subpage['password']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagepassword
 return  array('content'=>$__module_content,
              'subpage'=>$__module_subpage);
}