<?php
function module_ad_form($razdel, $section = null)
{
 $__module_subpage = array();
 $__data = seData::getInstance();
 $thisreq = $__data->req;
 $_page = $thisreq->page;
 $_razdel = $thisreq->razdel;
 $_sub = $thisreq->sub;
 if (strpos(dirname(__FILE__),'/lib/modules'))
   $__MDL_URL = 'lib/modules/ad_form';
 else $__MDL_URL = 'modules/ad_form';
 $__MDL_ROOT = dirname(__FILE__).'/ad_form';
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
 $antispamon = $section->parametrs->param27 == "Y";
 $error = false;
 
 if ($antispamon) {
     $capcha = new plugin_capcha();
 }
 
 if (isRequest('part') && getRequest('part', 1) == $razdel) {
     if ($antispamon) { 
         $check = $capcha->check();
         if ($check === -10 || !$check){
             $error_text = $section->language->lang014;
             $error = true;
         }
     }
     
     if (!$error) {
         if ($section->parametrs->param2 == 'Y' && $section->parametrs->param3 == 'Y' && empty($_POST['nameFF'])) {
             $error = 'name required';
         }
         elseif ($section->parametrs->param4 == 'Y' && $section->parametrs->param5 == 'Y' && empty($_POST['contactFF'])) {
             $error = 'email required';
         }
         elseif ($section->parametrs->param6 == 'Y' && $section->parametrs->param7 == 'Y' && empty($_POST['phoneFF'])) {
             $error = 'phone required';
         }
         elseif ($section->parametrs->param8 == 'Y' && $section->parametrs->param9 == 'Y' && empty($_POST['messageFF'])) {
             $error = 'message required';
         }
     }
     
     if (!$error) {
         $headers .= "From: <noreplay@{$_SERVER['HTTP_HOST']}>\r\n";
         
         $to = (string)$section->parametrs->param1;
         $subject = $section->parametrs->param14 . ' ' . $_SERVER['HTTP_REFERER'];
         $message = "??????: ".$_POST['nameFF']."\nEmail: ".$_POST['contactFF']."\n??????????????: ".$_POST['phoneFF']."\nIP: ".$_SERVER['REMOTE_ADDR']."\n??????????????????: ".$_POST['messageFF'];
         $mailsend = new plugin_mail($subject, $to, $headers, $message, 'text/html');
         $mailsend->sendfile();
         echo $_POST['nameFF'];
     }
     else {
         header('HTTP/1.0 404 File not found');
     }
     exit();
 }
 
 if ($antispamon) {
     $anti_spam = $capcha->getCapcha($section->language->lang013, $section->language->lang014);
 }

 // include content.tpl
 if((empty($__data->req->sub) || $__data->req->razdel!=$razdel) && file_exists($__MDL_ROOT . "/tpl/content.tpl")){
	if (file_exists($__MDL_ROOT . "/php/content.php"))
		include $__MDL_ROOT . "/php/content.php";
	ob_start();
	include $__data->include_tpl($section, "content");
	$__module_content['form'] =  ob_get_contents();
	ob_end_clean();
 } else $__module_content['form'] = "";
 //BeginSubPagelicense
 $__module_subpage['license']['admin'] = "";
 $__module_subpage['license']['group'] = 0;
 $__module_subpage['license']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='license' && file_exists($__MDL_ROOT . "/tpl/subpage_license.tpl")){
	include $__MDL_ROOT . "/php/subpage_license.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_license");
	$__module_subpage['license']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagelicense
 return  array('content'=>$__module_content,
              'subpage'=>$__module_subpage);
}