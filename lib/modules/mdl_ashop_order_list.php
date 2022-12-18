<?php
function module_ashop_order_list($razdel, $section = null)
{
 $__module_subpage = array();
 $__data = seData::getInstance();
 $thisreq = $__data->req;
 $_page = $thisreq->page;
 $_razdel = $thisreq->razdel;
 $_sub = $thisreq->sub;
 if (strpos(dirname(__FILE__),'/lib/modules'))
   $__MDL_URL = 'lib/modules/ashop_order_list';
 else $__MDL_URL = 'modules/ashop_order_list';
 $__MDL_ROOT = dirname(__FILE__).'/ashop_order_list';
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
 // START PHP upd 2
 if (isRequest('invnum') && isRequest(md5(getRequest('invnum').'3dfgvj'))) {
     list($payment_id, $order_id) = explode('_', getRequest('invnum'));
     
     if ($payment_id == 0 && !seUserGroup()) {
         header('Location: '.seMultiDir().'/'.$_page.'/?'.time());
         exit;
     }
     
     if (!empty($order_id) && isPostPayment($order_id)) {
         header('Location: '.seMultiDir().'/'.$_page.'/?'.time());
         exit;
     }
         
     //$_SESSION['SHOPPAYMENT']['ORDER_ID'] = $ORDER_ID = trim($order_id);
     $__data->goSubName($section, 'payment');
     
 }
 /*
 if (!seUserGroup()) {
    return;
 }     
 */
 $id_user = seUserId();
 $showcurr = se_getMoney();
 
 $plugin_order = new plugin_shoporder($id_user); 
 
 if (isRequest('orderpage')) {
     $order_id = getRequest('orderpage', 1);
	 
	 if (!seUserGroup()) {
		 if (empty($_SESSION['orders']) || !in_array($order_id, $_SESSION['orders'])) {
			 header('Location: '.seMultiDir().'/'.$_page.'/?'.time());
			exit;
		 }
	 }
     
     $order = new seShopOrder();
     $order->where('id_author=?', $id_user);
     $order->andWhere('id=?', $order_id);
     $order->andWhere("is_delete='?'", 'N');
     if ($order->fetchOne()){
         $__data->goSubName($section, 'orderpage');
     }
     else{
         header('Location: '.seMultiDir().'/'.$_page.'/?'.time());
         exit;
     }   
 }
 elseif(isRequest('delete_order') && isRequest('order')) {
     $order_id = getRequest('order', 1);
     if ($order_id)
         $plugin_order->deleteOrder($order_id); 
     header('Location: '.seMultiDir().'/'.$_page.'/?'.time());
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
 //BeginSubPagepayitem
 $__module_subpage['payitem']['admin'] = "";
 $__module_subpage['payitem']['group'] = 0;
 $__module_subpage['payitem']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='payitem' && file_exists($__MDL_ROOT . "/tpl/subpage_payitem.tpl")){
	include $__MDL_ROOT . "/php/subpage_payitem.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_payitem");
	$__module_subpage['payitem']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagepayitem
 //BeginSubPageorderitem
 $__module_subpage['orderitem']['admin'] = "";
 $__module_subpage['orderitem']['group'] = 0;
 $__module_subpage['orderitem']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='orderitem' && file_exists($__MDL_ROOT . "/tpl/subpage_orderitem.tpl")){
	include $__MDL_ROOT . "/php/subpage_orderitem.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_orderitem");
	$__module_subpage['orderitem']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPageorderitem
 //BeginSubPageorderpage
 $__module_subpage['orderpage']['admin'] = "";
 $__module_subpage['orderpage']['group'] = 0;
 $__module_subpage['orderpage']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='orderpage' && file_exists($__MDL_ROOT . "/tpl/subpage_orderpage.tpl")){
	include $__MDL_ROOT . "/php/subpage_orderpage.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_orderpage");
	$__module_subpage['orderpage']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPageorderpage
 //BeginSubPagepayment
 $__module_subpage['payment']['admin'] = "";
 $__module_subpage['payment']['group'] = 0;
 $__module_subpage['payment']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='payment' && file_exists($__MDL_ROOT . "/tpl/subpage_payment.tpl")){
	include $__MDL_ROOT . "/php/subpage_payment.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_payment");
	$__module_subpage['payment']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagepayment
 //BeginSubPageorderpageitem
 $__module_subpage['orderpageitem']['admin'] = "";
 $__module_subpage['orderpageitem']['group'] = 0;
 $__module_subpage['orderpageitem']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='orderpageitem' && file_exists($__MDL_ROOT . "/tpl/subpage_orderpageitem.tpl")){
	include $__MDL_ROOT . "/php/subpage_orderpageitem.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_orderpageitem");
	$__module_subpage['orderpageitem']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPageorderpageitem
 return  array('content'=>$__module_content,
              'subpage'=>$__module_subpage);
}