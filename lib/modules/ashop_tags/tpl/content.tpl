<header:css>
[include_css]
</header:css>
<div class="<?php if(strval($section->parametrs->param2)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>" >
<section class="content b_tag_list part<?php echo $section->id ?>">
<div class="b_tag_list-content_block">
<?php if(!empty($section->title)): ?>
    <<?php echo $section->title_tag ?> class="b_tag_list-content_title contentTitle">
        <span class="contentTitleTxt"><?php echo $section->title ?></span></<?php echo $section->title_tag ?>>
<?php endif; ?>
<?php if(!empty($section->image)): ?>
    <img border="0" class="contentImage" src="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>" title="<?php echo $section->image_alt ?>">
<?php endif; ?>
<?php if(!empty($section->text)): ?>
    <div class="b_tag_list-content_text"><?php echo $section->text ?></div>
<?php endif; ?>
</div>
<?php echo $__data->linkAddRecord($section->id) ?>
  <div class="b_tag_list-tags_block">
    <h4 class="b_tag_list-tags_block_title">Тэги</h4>
    <div class="b_tag_list-tag_area">
    <?php foreach($__data->limitObjects($section, $section->objectcount) as $record): ?>

         <a rel="nofollow" href="<?php echo seMultiDir()."/".$section->parametrs->param1."/" ?>?q=<?php echo $record->title ?>" class="b_tag_list-tag_item">
                <span class="b_tag_list-tag_item_text"<?php echo $__data->editItemRecord($section->id, $record->id) ?>><?php echo $record->title ?></span>
         </a>
    
<?php endforeach; ?>
    </div>
  </div>
</section>
</div>
