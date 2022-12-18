<?php
function module_ashop_wishlist($razdel, $section = null)
{
 $__module_subpage = array();
 $__data = seData::getInstance();
 $thisreq = $__data->req;
 $_page = $thisreq->page;
 $_razdel = $thisreq->razdel;
 $_sub = $thisreq->sub;
 if (strpos(dirname(__FILE__),'/lib/modules'))
   $__MDL_URL = 'lib/modules/ashop_wishlist';
 else $__MDL_URL = 'modules/ashop_wishlist';
 $__MDL_ROOT = dirname(__FILE__).'/ashop_wishlist';
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
 $user_group = seUserGroup();
 $user_id = seUserId();
 //виртуальная страница
 //$__data->setVirtualPage($__data->getPageName(), 'shop_vitrine', ($section->parametrs->param324 == 'Y'));
 //$virtualpage = $__data->getVirtualPage('shop_vitrine');
 $virtualpage = (string)$section->parametrs->param339 ? (string)$section->parametrs->param339 : $__data->getVirtualPage('shop_vitrine');
 if ($__data->getPageName() != $virtualpage && isRequest('show')) {
    $__data->go301(seMultiDir() . '/' . $virtualpage . '/show/' . getRequest('show').'/');
 }  
 
 //устанавливает какая витрина стоит (для модуля Каталог групп интернет-магазина)
 $__data->setVirtualPage('Y', 'choose_vitrine_'.$_page);
 
 if ($section->parametrs->param225 == seUserGroupName()) { // optcorp
     $price_type = 1;
 } 
 elseif ($section->parametrs->param224 == seUserGroupName()) { // optovik  
     $price_type = 2;
 } 
 else {                          
     $price_type = 0;
 } 
 
 $rounded = ($section->parametrs->param243 == 'Y');
 
 $separator = ($section->parametrs->param276 == 'Y') ? ' ' : ''; 
 
 // Добавление в корзину (shopcart) без ajax
 if (isRequest('addcart') && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {       
     $shopcart = new plugin_shopcart();
     $shopcart->addCart();                                  
     
     // Для обновления информера корзины перезагружаем страницу
     if ($section->parametrs->param85 == 'Y')                                                                
         $__data->go301(seMultiDir() . '/' . $section->parametrs->param50 . '/?' . time());        
     else                                                                                 
         $__data->go301($_SERVER['REQUEST_URI']);
     exit();
 }           
 
 //инициализация плагина  
 $psg = new plugin_shopgoods($virtualpage, '', trim($section->parametrs->param273)); 
 $plugin_compare = new plugin_shopcompare();
 $count_compare = $plugin_compare->getCountAllCompare();
 $limit_compare = (int)$section->parametrs->param335;
 $shop_variables = plugin_shopvariables::getInstance();
 
 if ((isRequest('ajax'.$razdel)) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
     $response = array();
     if (isRequest('param')) {
         $param = getRequest('param', 1);
         $value = getRequest('value', 1);
         $id_price = getRequest('id_price', 1);
         $group = getRequest('group', 1);
         $response = array();
         
         $plugin_modifications = new plugin_shopmodifications($id_price, $section->parametrs->param318 == 'Y');
         $response['params'] = $plugin_modifications->changeModifications($group, $param, $value);
         $response['type'] = (string)$section->parametrs->param310;
         $selected = !empty($_SESSION['modifications'][$id_price]) ? $_SESSION['modifications'][$id_price] : '';    
     
         $plugin_amount = new plugin_shopamount($id_price, '', $price_type, 1, $selected);
     
         $response['count'] = (string)$plugin_amount->getPresenceCount();
         $response['presence'] = (string)$plugin_amount->showPresenceCount($section->language->lang021, $section->language->lang020);
         $response['price'] = array(
             'new' => $plugin_amount->showPrice(true, $rounded, $separator),
             'old' => $plugin_amount->showPrice(false, $rounded, $separator) 
         );
         //картинки выбранных модификаций
         if ((string)$section->parametrs->param313 == 'Y')
             $response['images'] = $plugin_modifications->getImages($selected);
     }
     elseif (isRequest('review')) {
         $id_price = $psg->getGoodsId();
         if ($id_price && $user_id) {
             if ($psg->saveReview(getRequest('review', 4), $id_price, $user_id)) {
                 $response['success'] = 'Отзыв успешно добавлен.';
                 $response['count'] = $psg->getCountReviews($id_price);
             }
         } 
     }
     elseif (isRequest('vote')) {
         $id_review = getRequest('id', 1);
         if (!empty($id_review) && !empty($user_id)) {
             $vote = getRequest('vote', 1);
             if ($likes = $psg->voteReview($id_review, $user_id, $vote)) {
                 $response = $likes;
                 $response['success'] = true;
             } 
         }                  
     }
     elseif (isRequest('get_reviews')) {
         $id_price = $psg->getGoodsId();
         $sort = isRequest('reviews_sort') ? getRequest('reviews_sort') : (string)$section->parametrs->param322;
         $offset = getRequest('offset', 1);
         $count = isRequest('all') ? -1 : (int)$section->parametrs->param321;
         $review_list = $psg->getGoodsReviews($id_price, $offset, $count, $sort, isRequest('asc'));
         if (!empty($review_list)) {
             ob_start();
             include $__MDL_ROOT . '/php/subpage_reviewslist.php';
             include $__data->include_tpl($section, 'subpage_reviewslist');
             $response['reviews'] = ob_get_contents();
             ob_end_clean();
             $response['count'] = (int)$psg->getCountReviews($id_price);
             //$response['sort'] = $sort;
             $response['offset'] = $offset + count($review_list);
             $response['direction'] = isRequest('asc') ? '<i class="asc">↑</i>' : '<i class="desc">↓</i>';
         }
     }
     elseif (isRequest('compare') && $section->parametrs->param269 == 'Y'){
         $plugin_compare = new plugin_shopcompare();
         $id_price = getRequest('compare');
         $response['compare'] = $plugin_compare->changeCompare($id_price, $limit_compare);
         $response['all_compare'] = $plugin_compare->getCountAllCompare();
         $response['limit'] = $limit_compare;
     }
     elseif (isRequest('quickview') && $section->parametrs->param327 == 'Y'){
         $viewgoods = getRequest('quickview');
         $quickview = true;
         ob_start();
         include $__MDL_ROOT . '/php/subpage_show.php';
         include $__data->include_tpl($section, 'subpage_show');
         $response['quickshow'] = ob_get_contents();
    
         $footer = $__data->footer;
    
         $response['quickshow'] = $__data->getHeader($response['quickshow']);
    
         $response['footer'] = join('', array_diff($__data->footer, $footer));
         ob_end_clean();
     }
     elseif (isRequest('preorder') && $section->parametrs->param336 == 'Y'){
         $fields = array(
             'id_product' => getRequest('product', 1),
             'count' => getRequest('count'),
             'name' => getRequest('cb_name'),
             'email' => getRequest('cb_email'),
             'phone' => getRequest('cb_phone')
         );
         $psp = new plugin_shoppreorder();
 
         if ($psp->addPreorder($fields))
             $response['success'] = 'Заявка принята';
         else
             $response['error'] = 'Ошибка';
     }
     elseif (isRequest('delprod')){
         $id_delprod = getRequest('delprod');
         $response['id'] = $id_delprod;      
         
         if(!empty($id_delprod)){
         
             $table_wishlist = new seTable('shop_wishlist', 'sw');
             $table_wishlist->select("*");
             $table_wishlist->where("sw.id_user = '?'", $user_id);
             $table_wishlist->andwhere("sw.id_price = '?'", $id_delprod);
             $id_price_del = $table_wishlist->fetchOne();
 
             $table_w = new seTable('shop_wishlist', 'sw');
             $table_w->select("*");
             $table_w->find($id_price_del['id']);
             $table_w->delete($id_price_del['id']);
         
         }
         
         $count_wish = $psg->getGoodsWishCount($user_id);
 
         $response['count'] = $count_wish;
           
     }
     echo json_encode($response);
     exit();        
 }
 
 if($user_id){
  if(isRequest('clear_wishlist')){
     se_db_query("DELETE FROM shop_wishlist WHERE id_user = {$user_id}");
     header('Location: ' . seMultiDir() . "/$_page/");
     exit();
  }
 }
  
 //текст подвала
 $footer_text = $psg->footertext;
                                 
 $analoggood = '';   //нужно для определения осн. картинки от аналог. и сопут. товаров
 
 // Получена команда показать выбранный товар
 if (isRequest('show')) {           
     $quickview = false;
     $show = getRequest('show', 3);
     $pr = new seShopPrice();
     $pr->select('id, enabled');
     $pr->where("code = '?'", $show);
     $pr->fetchOne(); 
     //проверка на существование и на статус активный товара
     if (($pr->enabled == 'N') || (!$pr->enabled)){
         $__data->go404();
     }
     else {
         $__data->goSubName($section, 'show');
         $viewgoods = $pr->id;
     }          
 }
 if (isRequest('typetable')) {
     $_SESSION['SHOP_VITRINE' . $_page . $razdel]['type'] = 't';
 }   
 elseif (isRequest('typevitrine')) {
     $_SESSION['SHOP_VITRINE' . $_page . $razdel]['type'] = 'v';
 }   
 elseif (isRequest('typelist')) {
     $_SESSION['SHOP_VITRINE' . $_page . $razdel]['type'] = 'l';
 } 
 
 if (!empty($_SESSION['SHOP_VITRINE' . $_page . $razdel]['type']) && $section->parametrs->param183 == 'Y') 
     $section->parametrs->param184 = strval($_SESSION['SHOP_VITRINE' . $_page . $razdel]['type']);
 else  
     $_SESSION['SHOP_VITRINE' . $_page . $razdel]['type'] = (string)$section->parametrs->param184;
 
 if (isRequest('shopcatgr')) {
     $shopcatgr = getRequest('shopcatgr', 1);
     if ($shopcatgr) {
         $tbl = new seTable('shop_group', 'sg');
         $tbl->select('code_gr');
         $tbl->find($shopcatgr);
         $catgr = $tbl->code_gr;
         $__data->go301(seMultiDir().'/'.$_page.'/cat/'.$catgr.'/');
     } 
     else {
         $__data->go301(seMultiDir().'/'.$_page.'/');
     }
     exit();
 } 
                                                    
 if (isRequest('GoToComment') && ($user_group || $section->parametrs->param217 == 'C')) {
     $comment_text = trim(getRequest('comm_text', 3));
     if (!$comment_text) {
         $error_comm_message = (string)$section->language->lang039; 
     }
     if (!$user_group) {
         $comment_user = trim(getRequest('comm_user', 3));
         if (!$comment_user)
             $error_comm_message = $section->language->lang100; 
         
         require_once getcwd() . '/lib/card.php';
         if (!checkcard(getRequest('comm_captcha', 1)))
             $error_comm_message = $section->language->lang101;   
     }
     if (empty($error_comm_message)) {
         if (empty($comment_user))
             $comment_user = (string)$section->language->lang040;
         $psg->saveGoodsComment($viewgoods, $comment_text, $comment_user); 
         header('Location: ' . seMultiDir() . "/$_page/show/{$show}/#comments");
         exit();
     } 
 }            

   $section->objectcount = intval($section->parametrs->param64);
 // include content.tpl
 if((empty($__data->req->sub) || $__data->req->razdel!=$razdel) && file_exists($__MDL_ROOT . "/tpl/content.tpl")){
	if (file_exists($__MDL_ROOT . "/php/content.php"))
		include $__MDL_ROOT . "/php/content.php";
	ob_start();
	include $__data->include_tpl($section, "content");
	$__module_content['form'] =  ob_get_contents();
	ob_end_clean();
 } else $__module_content['form'] = "";
 //BeginSubPageshow
 $__module_subpage['show']['admin'] = "";
 $__module_subpage['show']['group'] = 0;
 $__module_subpage['show']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='show' && file_exists($__MDL_ROOT . "/tpl/subpage_show.tpl")){
	include $__MDL_ROOT . "/php/subpage_show.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_show");
	$__module_subpage['show']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPageshow
 //BeginSubPagegoodlist
 $__module_subpage['goodlist']['admin'] = "";
 $__module_subpage['goodlist']['group'] = 0;
 $__module_subpage['goodlist']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='goodlist' && file_exists($__MDL_ROOT . "/tpl/subpage_goodlist.tpl")){
	include $__MDL_ROOT . "/php/subpage_goodlist.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_goodlist");
	$__module_subpage['goodlist']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagegoodlist
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
 //BeginSubPagesocialbuttons
 $__module_subpage['socialbuttons']['admin'] = "";
 $__module_subpage['socialbuttons']['group'] = 0;
 $__module_subpage['socialbuttons']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='socialbuttons' && file_exists($__MDL_ROOT . "/tpl/subpage_socialbuttons.tpl")){
	include $__MDL_ROOT . "/php/subpage_socialbuttons.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_socialbuttons");
	$__module_subpage['socialbuttons']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagesocialbuttons
 //BeginSubPagevitrine
 $__module_subpage['vitrine']['admin'] = "";
 $__module_subpage['vitrine']['group'] = 0;
 $__module_subpage['vitrine']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='vitrine' && file_exists($__MDL_ROOT . "/tpl/subpage_vitrine.tpl")){
	include $__MDL_ROOT . "/php/subpage_vitrine.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_vitrine");
	$__module_subpage['vitrine']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagevitrine
 //BeginSubPagetable
 $__module_subpage['table']['admin'] = "";
 $__module_subpage['table']['group'] = 0;
 $__module_subpage['table']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='table' && file_exists($__MDL_ROOT . "/tpl/subpage_table.tpl")){
	include $__MDL_ROOT . "/php/subpage_table.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_table");
	$__module_subpage['table']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagetable
 //BeginSubPagesocial
 $__module_subpage['social']['admin'] = "";
 $__module_subpage['social']['group'] = 0;
 $__module_subpage['social']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='social' && file_exists($__MDL_ROOT . "/tpl/subpage_social.tpl")){
	include $__MDL_ROOT . "/php/subpage_social.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_social");
	$__module_subpage['social']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagesocial
 //BeginSubPagelist
 $__module_subpage['list']['admin'] = "";
 $__module_subpage['list']['group'] = 0;
 $__module_subpage['list']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='list' && file_exists($__MDL_ROOT . "/tpl/subpage_list.tpl")){
	include $__MDL_ROOT . "/php/subpage_list.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_list");
	$__module_subpage['list']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagelist
 //BeginSubPagepreorder
 $__module_subpage['preorder']['admin'] = "";
 $__module_subpage['preorder']['group'] = 0;
 $__module_subpage['preorder']['form'] =  '';
 if($razdel == $__data->req->razdel && !empty($__data->req->sub)
 && $__data->req->sub=='preorder' && file_exists($__MDL_ROOT . "/tpl/subpage_preorder.tpl")){
	include $__MDL_ROOT . "/php/subpage_preorder.php";
	ob_start();
	include $__data->include_tpl($section, "subpage_preorder");
	$__module_subpage['preorder']['form'] =  ob_get_contents();
	ob_end_clean();
 } //EndSubPagepreorder
 return  array('content'=>$__module_content,
              'subpage'=>$__module_subpage);
}

