<div class="content shopmini_info" <?php echo $section->style ?>>
<?php if($section->title!=''): ?>
    <h3 class="contentTitle" <?php echo $section->style_title ?>>
        <span class="contentTitleTxt"><?php echo $section->title ?></span>
    </h3>
<?php endif; ?>
<?php if($section->image!=''): ?>
    <img border="0" class="contentImage" <?php echo $section->style_image ?> src="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>">
<?php endif; ?>
<?php if($section->text!=''): ?>
    <div class="contentText"<?php echo $section->style_text ?>><?php echo $section->text ?></div>
<?php endif; ?>
    <div class="content_info" onclick="document.location.href='<?php echo seMultiDir()."/".$section->parametrs->param2."/" ?>'">
        <span class="common_goods"><?php echo $section->language->lang001 ?> 
            <span class="ord_num"><?php echo $count_order ?></span>
        </span>
        <span class="common_summ"><?php echo $section->language->lang002 ?> 
            <span class="ord_sum"><?php echo $summa_order ?></span>
            <span class="ord_kurs"><?php echo $section->parametrs->param1 ?></span>
        </span>
    </div>
</div>      
