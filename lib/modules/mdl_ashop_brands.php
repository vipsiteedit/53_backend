<?php
function module_ashop_brands($razdel, $section = null)
{
 $__module_subpage = array();
 $__data = seData::getInstance();
 $thisreq = $__data->req;
 $_page = $thisreq->page;
 $_razdel = $thisreq->razdel;
 $_sub = $thisreq->sub;
 if (strpos(dirname(__FILE__),'/lib/modules'))
   $__MDL_URL = 'lib/modules/ashop_brands';
 else $__MDL_URL = 'modules/ashop_brands';
 $__MDL_ROOT = dirname(__FILE__).'/ashop_brands';
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
 $brands = plugin_shopbrands::getInstance();
 $listbrands = $brands->getlistBrands();
 list($width, $height) = explode('x', $section->parametrs->param2);
 //print_r($listbrands);
 $simgs = new plugin_shopimages('brand');
 foreach($listbrands as $brand) {
     $brand['picture'] = $simgs->getPictFromImage($brand['image'], $section->parametrs->param2);
     $brand['url'] = seMultiDir() . '/' . $section->parametrs->param3 .SE_END . '?brand=' . $brand['code'];
     $brand['picture_alt'] = htmlspecialchars($brand['name']);
     $__data->setItemList($section, 'items', $brand);
 }

   $section->objectcount = intval(3);
 // include content.tpl
 if((empty($__data->req->sub) || $__data->req->razdel!=$razdel) && file_exists($__MDL_ROOT . "/tpl/content.tpl")){
	if (file_exists($__MDL_ROOT . "/php/content.php"))
		include $__MDL_ROOT . "/php/content.php";
	ob_start();
	include $__data->include_tpl($section, "content");
	$__module_content['form'] =  ob_get_contents();
	ob_end_clean();
 } else $__module_content['form'] = "";
 return  array('content'=>$__module_content,
              'subpage'=>$__module_subpage);
}

