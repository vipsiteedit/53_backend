<?php
function module_ashop_special_respons($razdel, $section = null)
{
 $__module_subpage = array();
 $__data = seData::getInstance();
 $thisreq = $__data->req;
 $_page = $thisreq->page;
 $_razdel = $thisreq->razdel;
 $_sub = $thisreq->sub;
 if (strpos(dirname(__FILE__),'/lib/modules'))
   $__MDL_URL = 'lib/modules/ashop_special_respons';
 else $__MDL_URL = 'modules/ashop_special_respons';
 $__MDL_ROOT = dirname(__FILE__).'/ashop_special_respons';
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
 if ((isRequest('ajax'.$razdel)) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
     $response = array();
     if (isRequest('param')) {
         $plugin_modifications = new plugin_shopmodifications(getRequest('id_price', 1), true);  
         $response = $plugin_modifications->getChangesModification();
         $response['type'] = (string)$section->parametrs->param49;
     }  
     header('Content-Type: application/json');
     echo json_encode($response);
     exit(); 
 }
 
 if (isRequest('addcart')) {
     $shopcart = new plugin_shopcart();
     $shopcart->addCart();
     
     if($section->parametrs->param8=='N') {
         header('Location: ' . seMultiDir() . "/{$_page}?" . time());
     } else {
         header('Location: ' . seMultiDir() . "/{$section->parametrs->param4}?" . time());
     }
     exit();
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
 //BeginSubPagemodifications
 $__module_subpage['modifications']['admin'] = "";
 $__module_subpage['modifications']['group'] = 0;
 $__module_subpage['modifications']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='modifications' && file_exists($__MDL_ROOT . "/tpl/subpage_modifications.tpl")){
	include $__MDL_ROOT . "/php/subpage_modifications.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_modifications");
	$__module_subpage['modifications']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagemodifications
 //BeginSubPagespecial
 $__module_subpage['special']['admin'] = "";
 $__module_subpage['special']['group'] = 0;
 $__module_subpage['special']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='special' && file_exists($__MDL_ROOT . "/tpl/subpage_special.tpl")){
	include $__MDL_ROOT . "/php/subpage_special.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_special");
	$__module_subpage['special']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagespecial
 //BeginSubPageblockproduct
 $__module_subpage['blockproduct']['admin'] = "";
 $__module_subpage['blockproduct']['group'] = 0;
 $__module_subpage['blockproduct']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='blockproduct' && file_exists($__MDL_ROOT . "/tpl/subpage_blockproduct.tpl")){
	include $__MDL_ROOT . "/php/subpage_blockproduct.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_blockproduct");
	$__module_subpage['blockproduct']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPageblockproduct
 return  array('content'=>$__module_content,
              'subpage'=>$__module_subpage);
}

