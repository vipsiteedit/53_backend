<header:css>
[lnk:font-awesome/css/font-awesome.min.css]
</header:css>
<section class="content shop_informer <?php if(strval($section->parametrs->param4)=='fixed'): ?>fixed <?php if(strval($section->parametrs->param5)=='left'): ?>fixed-left<?php else: ?>fixed-right<?php endif; ?><?php endif; ?> part<?php echo $section->id ?>">
<?php if(!empty($section->title)): ?><<?php echo $section->title_tag ?> class="contentTitle">
  <span class="contentTitleTxt"><?php echo $section->title ?></span></<?php echo $section->title_tag ?>>
<?php endif; ?>
<?php if(!empty($section->image)): ?>
  <img border="0" class="contentImage" src="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>">
<?php endif; ?>
<?php if(!empty($section->text)): ?>
  <div class="contentText"><?php echo $section->text ?></div>
<?php endif; ?>
  <div class="shop_informer__content fixed">
    <div class="shop_informer__wish shop_informer__item">
        <a class="shop_informer__item_link" href="<?php echo seMultiDir()."/".$section->parametrs->param1."/" ?>" title="<?php echo $section->language->lang001 ?>">
            <span class="shop_informer__item_icon">
                <i class="fa fa-heart" aria-hidden="true"></i>    
            </span>
            <span class="shop_informer__item_count"><?php echo $count_wish ?></span>
            <input type="hidden" id="informer_wish_count" value="<?php echo $count_wish ?>">
        </a>        
    </div>
    <div class="shop_informer__compare shop_informer__item">
        <a class="shop_informer__item_link" href="<?php echo seMultiDir()."/".$section->parametrs->param2."/" ?>" title="<?php echo $section->language->lang002 ?>">
            <span class="shop_informer__item_icon">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>    
            </span>
            <span class="shop_informer__item_count"><?php echo $count_compare ?></span>
            <input type="hidden" id="informer_compare_count" value="<?php echo $count_compare ?>">
        </a>    
    </div>
    <div class="shop_informer__cart shop_informer__item">
        <a class="shop_informer__item_link" href="<?php echo seMultiDir()."/".$section->parametrs->param3."/" ?>" title="<?php echo $section->language->lang003 ?>">
            <span class="shop_informer__item_icon">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>    
            </span>
            <span class="shop_informer__item_count"><?php echo $count_cart ?></span>
            <input type="hidden" id="informer_cart_count" value="<?php echo $count_cart ?>">
        </a>
    </div>
  </div>
</section>
