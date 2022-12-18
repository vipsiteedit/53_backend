<header:css>
[lnk:rouble/rouble.css]
[include_css]
</header:css>
<footer:js>
[js:jquery/jquery.min.js]
[module_js:tipso.min.js]
[include_js({'id':<?php echo $section->id ?>, 'link':'<?php echo seMultiDir()."/".$_page."/" ?>','p16':'<?php echo $section->parametrs->param16 ?>',curr: '<?php echo $baseCurr ?>'})]
</footer:js>
<?php if(strval($section->parametrs->param20)!='d'): ?><div class="<?php if(strval($section->parametrs->param20)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>"><?php endif; ?>
<div class="content b_shop_cart">
     
    <?php if(!empty($section->title)): ?>
        <h3 class="contentTitle"<?php echo $section->style_title ?>>
            <span class="contentTitleTxt"><?php echo $section->title ?></span>
        </h3>
    <?php endif; ?>
    <?php if(!empty($section->image)): ?>
        <img border="0" class="contentImage" <?php echo $section->style_image ?> src="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>" title="<?php echo $section->image_alt ?>">
    <?php endif; ?>
    <?php if(!empty($section->text)): ?>
        <div class="contentText" <?php echo $section->style_text ?>><?php echo $section->text ?></div>
    <?php endif; ?>
    <div class="contentBody">
        <div id="notEmptyCartGoods" <?php if($total['count']==0): ?>style="display:none;"<?php endif; ?>>
            <div <?php if($error_message==''): ?>style="display:none;"<?php endif; ?> id="blockMessageWarning">
                <span><?php echo $error_message ?></span>
            </div>
            <div class="b_shop_cart-shoping_step">
        <div class="b_shop_cart-shoping_step_item b_shop_cart-shoping_step_item__active">
            <span class="b_shop_cart-shoping_step_link"><?php echo $section->language->lang091 ?></span>
        </div>
        <div class="b_shop_cart-shoping_step_item">
            <span class="b_shop_cart-shoping_step_link"><?php echo $section->language->lang092 ?></span>
        </div>
        <div class="b_shop_cart-shoping_step_item">
            <span class="b_shop_cart-shoping_step_link"><?php echo $section->language->lang093 ?></span>
        </div>
        
        </div>
            <form id="cartGoodsForm" class="b_shop_cart-cart_items_form" name="cartgoodsform" action="" method="post">
                <div class="blockCartContent b_shop_cart-cart_list_block" id="blockCartGoods">
                      <div class="blockCartList b_shop_cart-cart_list">
                           <?php if(file_exists($__MDL_ROOT."/php/subpage_products.php")) include $__MDL_ROOT."/php/subpage_products.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_products.tpl")) include $__data->include_tpl($section, "subpage_products"); ?>
                      </div>
                </div>
                <?php if(strval($section->parametrs->param8)=='Y'): ?>
                <div class="b_shop_cart-coupon_block">
                <div class="b_shop_cart-coupon blockCartContent" id="blockCouponDiscount">
                    <div id="blockCouponApply">
                        <input id="inputCoupon" type="text" name="code_coupon" placeholder="<?php echo $section->language->lang040 ?>" value="<?php if($find_coupon): ?><?php echo $code_coupon ?><?php endif; ?>">
                        <input type="button" class="buttonSend" id="btnApplyCoupon" title="<?php echo $section->language->lang041 ?>" value="<?php echo $section->language->lang042 ?>">
                    </div>
                    <div id="noteCoupon">
                        <?php if($find_coupon): ?><?php echo $note_coupon ?><?php else: ?><?php echo $section->language->lang043 ?><?php endif; ?>
                    </div>
                </div>
                </div>
                <?php endif; ?> 
                
                <div class="blockCartContent b_shop_cart-registration_block" id="blockCartContact">
                    <div class="blockCartTitle">
                        <span><?php echo $section->language->lang045 ?></span>
                    </div>
                    <div class="blockCartList">
                        <?php if(file_exists($__MDL_ROOT."/php/subpage_contacts.php")) include $__MDL_ROOT."/php/subpage_contacts.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_contacts.tpl")) include $__data->include_tpl($section, "subpage_contacts"); ?>
                        
                        
                        <?php if(strval($section->parametrs->param17)=='Y' && $user_id==0): ?>
                            <?php if(file_exists($__MDL_ROOT."/php/subpage_requisite.php")) include $__MDL_ROOT."/php/subpage_requisite.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_requisite.tpl")) include $__data->include_tpl($section, "subpage_requisite"); ?>
                        <?php endif; ?>
                        
                    </div> 
                </div>
                                      
                <div class="blockCartContent b_shop_cart-delivery_block" id="blockCartDelivery">
                    <div class="blockCartTitle">
                        <span class="deliveryTitle"><?php echo $section->language->lang044 ?></span>
                        <span id="selectedUserRegion"><?php echo $section->language->lang068 ?><a class="userRegionName" href="#"><?php echo $region_city ?></a></span>
                        <?php if(file_exists($__MDL_ROOT."/php/subpage_selectregion.php")) include $__MDL_ROOT."/php/subpage_selectregion.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_selectregion.tpl")) include $__data->include_tpl($section, "subpage_selectregion"); ?>
                    </div> 
                    <div class="blockCartList">
                        <?php if(file_exists($__MDL_ROOT."/php/subpage_deliveries.php")) include $__MDL_ROOT."/php/subpage_deliveries.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_deliveries.tpl")) include $__data->include_tpl($section, "subpage_deliveries"); ?>    
                    </div>
                    <br>
                    <div class="blockContactAddress"<?php if(empty($addr)): ?> style="display:none;"<?php endif; ?>>
                        <div class="blockRegLabel">
                            <label for="reg_address"><?php echo $section->language->lang033 ?></label><span class="required">*</span>
                        </div>
                        <div class="blockRegInput">
                            <textarea class="inputCartContact <?php if(!empty($error_address)): ?>inputCartError<?php endif; ?>" id="reg_address" name="contact_address"><?php echo $contact_address ?></textarea>
                            <div class="regCartError "<?php if(empty($error_address)): ?> style="display:none;"<?php endif; ?>><?php echo $error_address ?></div>
                        </div> 
                    </div>
                </div>
                <?php if(strval($section->parametrs->param9)=='Y'): ?>
                    <?php if(file_exists($__MDL_ROOT."/php/subpage_payments.php")) include $__MDL_ROOT."/php/subpage_payments.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_payments.tpl")) include $__data->include_tpl($section, "subpage_payments"); ?>
                <?php endif; ?>
                <div class="goodcartFooternext b_shop_cart-cart_list_footer" id="blockCartTotalSum">
                          <div class="continueShoppingArea b_shop_cart-back_to_catalog_button_block">
                          <a class="continueShopping b_shop_cart-back_to_catalog_button" href="<?php echo seMultiDir()."/".$section->parametrs->param1."/" ?>"><?php echo $section->language->lang072 ?></a>
                          </div>
                          <div id="summGoods" class="b_shop_cart-total_price_block">
                          <span class="b_shop_cart-total_price_title"><?php echo $section->language->lang029 ?></span><span id="totalSumPrice" class="cartPriceSum b_shop_cart-total_price_value"><?php echo $sum_total_order ?></span>
                          </div>
                          <div class="blockCartContent blockButtonOrder b_shop_cart-step_to_info_button_block">
                          <button class="buttonSend b_shop_cart-step_to_info_button" id="test_order" name="place_order"><?php echo $section->language->lang048 ?></button>
                          </div>
                 </div>
            </form>
        </div>
        <div id="emptyCartGoods" <?php if($total['count']!=0): ?>style="display:none;"<?php endif; ?>>
            <div id="emptyCart"><?php echo $section->language->lang049 ?></div>
            <a class="linkGoShopping" href="<?php echo seMultiDir()."/".$section->parametrs->param1."/" ?>"><?php echo $section->language->lang050 ?></a>
        </div>
    </div>
</div>
<?php if(strval($section->parametrs->param20)!='d'): ?></div><?php endif; ?>
