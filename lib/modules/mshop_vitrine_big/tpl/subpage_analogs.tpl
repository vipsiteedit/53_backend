<?php if($analogscount!=0): ?>
    <a name="goodsanalogs"></a> 
    <?php if(file_exists($__MDL_ROOT."/php/subpage_goodlist.php")) include $__MDL_ROOT."/php/subpage_goodlist.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_goodlist.tpl")) include $__data->include_tpl($section, "subpage_goodlist"); ?>
    <div class="goodsGoods analog">
        <h3 class="goodsAnalogsHat goodsHat"><?php echo $section->language->lang030 ?></h3>
        <?php if(file_exists($__MDL_ROOT."/php/subpage_table.php")) include $__MDL_ROOT."/php/subpage_table.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_table.tpl")) include $__data->include_tpl($section, "subpage_table"); ?>
    </div>  
<?php endif; ?>
