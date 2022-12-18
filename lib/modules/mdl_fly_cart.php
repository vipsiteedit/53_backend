<?php
function module_fly_cart($razdel, $section = null)
{
 $__module_subpage = array();
 $__data = seData::getInstance();
 $thisreq = $__data->req;
 $_page = $thisreq->page;
 $_razdel = $thisreq->razdel;
 $_sub = $thisreq->sub;
 if (strpos(dirname(__FILE__),'/lib/modules'))
   $__MDL_URL = 'lib/modules/fly_cart';
 else $__MDL_URL = 'modules/fly_cart';
 $__MDL_ROOT = dirname(__FILE__).'/fly_cart';
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
 $pricemoney = se_getMoney();      
 $group_name = seUserGroupName();
 $type_price = ($group_name == $section->parametrs->param2) ? 1 : (($group_name == $section->parametrs->param1) ? 2 : 0); 
 $rounded = ($section->parametrs->param21 == 'Y');
 
 $plugin_cart = new plugin_shopCart40(array('round' => $rounded, 'type_price' => $type_price, 'presence' => '', 'curr' => $pricemoney));
 
 if (isRequest('ajax'.$razdel) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
     $result = array();
     if (isRequest('cart_clear')){
         $plugin_cart->clearCart();
     }
     elseif ($delcart = getRequest('delcartname', 3)){
         $plugin_cart->delCart(array('delcartname' => $delcart));        
     }
     elseif (isRequest('countitem')){
         $plugin_cart->updateCart();
     }
     elseif (getRequest('addcart', 1) > 0){
         $id_goods = getRequest('addcart', 1);
         
         if (!empty($_SESSION['SHOP_VITRINE']['selected'][$id_goods])) {
             $add_cart_param = join(',', $_SESSION['SHOP_VITRINE']['selected'][$id_goods]);
         }
         else {               
             $add_cart_param = join(',', getRequest('addcartparam', 3));   
         }    
     
         if (!empty($add_cart_param))
             $add_cart_param = 'param:' . $add_cart_param;
   
         $cart_name = md5($id_goods . '_' . $add_cart_param);
             
         if (!empty($plugin_cart->incart[$cart_name])){
             $count = $plugin_cart->incart[$cart_name]['count'] + max(1, getRequest('addcartcount', 1));
             $plugin_cart->updateCart(array($cart_name => $count));
         }
         else{          
             $plugin_cart->addCart(array('param' => $add_cart_param));
             $plugin_cart->getInCart();     
         }   
         
     }
     
     $total = $plugin_cart->getTotalCart();
     $result['total']  = array(
         'amount' => $total['show_total'], 
         'count' => $total['count'], 
         'discount' => $total['show_discount']
     );
     
     $goods_cart = $plugin_cart->getGoodsCart();
     $result['incart'] = array();
     foreach ($goods_cart as $val){
         $product = array();
         $product['id'] = $val['key'];
         $product['name'] = $val['name'];
         if (!empty($val['paramsname']))
             $product['name'] .= ' (' . $val['paramsname'] . ')';
         $product['link'] = seMultiDir() . '/' . $section->parametrs->param3 . '/show/' . $val['code'] . '/';
         $product['count'] = $val['count'];
         $product['sum'] = $val['newsum'];
         $result['incart'][] = $product;    
     }
   
     echo json_encode($result);
     exit;
 }
 
 $getGoodsCart = $plugin_cart->getGoodsCart();
 if(!empty($getGoodsCart)){
     foreach ($getGoodsCart as $key => $val) {
         $val['link'] = seMultiDir().'/'.$section->parametrs->param3.'/show/' . $val['code'] . '/';
         if (!empty($val['paramsname']))
             $val['name'] .= ' (' . $val['paramsname'] . ')';
         $__data->setItemList($section, 'objects', $val);
     } 
 }
 $total = $plugin_cart->getTotalCart();
  
 $order_summ = $total['show_total'];
 $discount_summ = $total['show_discount'];
 $count_goods = $total['count'];
 
 $no_goods = $isset_goods = '';
 if ($count_goods > 0){
     $no_goods = "style=\"display:none;\"";
 }
 else{
     $isset_goods = "style=\"display:none;\"";
 }

 // include content.tpl
 if((empty($__data->req->sub) || $__data->req->razdel!=$razdel) && file_exists($__MDL_ROOT . "/tpl/content.tpl")){
	if (file_exists($__MDL_ROOT . "/php/content.php"))
		include $__MDL_ROOT . "/php/content.php";
	ob_start();
	include $__MDL_ROOT . "/tpl/content.tpl";
	$__module_content['form'] =  ob_get_contents();
	ob_end_clean();
 } else $__module_content['form'] = "";
 //BeginSubPageexamples
 $__module_subpage['examples']['admin'] = "";
 $__module_subpage['examples']['group'] = 0;
 $__module_subpage['examples']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='examples' && file_exists($__MDL_ROOT . "/tpl/subpage_examples.tpl")){
	include $__MDL_ROOT . "/php/subpage_examples.php";
	ob_start();
	include $__MDL_ROOT . "/tpl/subpage_examples.tpl";
	$__module_subpage['examples']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPageexamples
 //BeginSubPagecart
 $__module_subpage['cart']['admin'] = "";
 $__module_subpage['cart']['group'] = 0;
 $__module_subpage['cart']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='cart' && file_exists($__MDL_ROOT . "/tpl/subpage_cart.tpl")){
	include $__MDL_ROOT . "/php/subpage_cart.php";
	ob_start();
	include $__MDL_ROOT . "/tpl/subpage_cart.tpl";
	$__module_subpage['cart']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagecart
 return  array('content'=>$__module_content,
              'subpage'=>$__module_subpage);
}