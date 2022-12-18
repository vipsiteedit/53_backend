<?php if(file_exists($__MDL_ROOT."/php/subpage_goodlist.php")) include $__MDL_ROOT."/php/subpage_goodlist.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_goodlist.tpl")) include $__data->include_tpl($section, "subpage_goodlist"); ?>
<div class="content e_shopvit" <?php echo $section->style ?>>
    <?php if(!empty($section->title)): ?>
        <h3 class="contentTitle"<?php echo $section->style_title ?>>
            <span class="contentTitleTxt"><?php echo $section->title ?></span>
        </h3>
    <?php endif; ?>                         
    <?php if(!empty($section->image)): ?>
        <img class="contentImage" alt="<?php echo $section->image_alt ?>" src="<?php echo $section->image ?>" border="0" <?php echo $section->style_image ?>>
    <?php endif; ?>
    <?php if(!empty($section->text)): ?>
        <div class="contentText" <?php echo $section->style_text ?>><?php echo $section->text ?></div>
    <?php endif; ?>
    <div class="goodsContent">
        <?php if($goodscount!=0): ?>      
            <div class="blockPanel container-fluid">
                <?php if(!empty($sort_list)): ?>
                    <div class="vitrineSort pull-left">
                        <form method="post" action="">
                            <label class="vitrineSortLabel hidden-xs" for="sortOrderby"><?php echo $section->language->lang025 ?></label>
                            <span class="glyphicon glyphicon-filter hidden-lg hidden-md hidden-sm"></span>
                            <select class="vitrineSortSelect" id="sortOrderby" name="sortOrderby">
                                <?php foreach($section->sorts as $sort): ?>
                                    <option name="limit" value="<?php echo $sort->value ?>"<?php if(!empty($sort->selected)): ?> selected<?php endif; ?>><?php echo $sort->name ?></span></option>
                                
<?php endforeach; ?>
                            </select>
                        </form>
                </div>  
                <?php endif; ?>
            <?php if($section->parametrs->param183=='Y'): ?>
                <div class="changeView pull-right">
                    <form method="post" action="">
                        <label class="viewLabel hidden-xs"><?php echo $section->language->lang102 ?></label>
                        <div class="btn-group btn-group-sm">
                            <button class="buttonSend btn btn-default" name="typevitrine" title="<?php echo $section->language->lang034 ?>" <?php if($section->parametrs->param184=='v'): ?>disabled<?php endif; ?>><span class="glyphicon glyphicon-th-large"></span></button>
                            <button class="buttonSend btn btn-default" name="typetable" title="<?php echo $section->language->lang035 ?>" <?php if($section->parametrs->param184=='t'): ?>disabled<?php endif; ?>><span class="glyphicon glyphicon-th-list"></span></button>
                            <button class="buttonSend btn btn-default" name="typelist" title="<?php echo $section->language->lang103 ?>" <?php if($section->parametrs->param184=='l'): ?>disabled<?php endif; ?>><span class="glyphicon glyphicon-align-justify"></span></button>  
                        </div>                        
                    </form>
                </div>
            <?php endif; ?>
            <?php if(!empty($limit_list)): ?>
                <div class="productsLimit pull-right hidden-sm hidden-xs">
                    <form method="post" action="">
                        <label class="limitLabel"><?php echo $section->language->lang099 ?></label>
                        <div class="btn-group  btn-group-sm">
                            <?php foreach($section->limits as $limit): ?>
                                <button class="buttonSend btnChangeLimit btn btn-default" name="limit" value="<?php echo $limit->value ?>"<?php if(!empty($limit->selected)): ?> disabled<?php endif; ?>><span><?php echo $limit->value ?></span></button>
                            
<?php endforeach; ?>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
            </div>
            <?php if(!empty($SE_NAVIGATOR)): ?>
                <div class="goodsNavigator top"><?php echo $SE_NAVIGATOR ?></div>
            <?php endif; ?>
            <div class="goodsGoods <?php if($section->parametrs->param184=='v'): ?> vitrina<?php endif; ?><?php if($section->parametrs->param184=='t'): ?> tables<?php endif; ?><?php if($section->parametrs->param184=='l'): ?> list<?php endif; ?> <?php if($section->parametrs->param85=='Y'): ?>notAjaxCart<?php endif; ?>">
                <?php if($section->parametrs->param184=='v'): ?>
                    <?php if(file_exists($__MDL_ROOT."/php/subpage_vitrine.php")) include $__MDL_ROOT."/php/subpage_vitrine.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_vitrine.tpl")) include $__data->include_tpl($section, "subpage_vitrine"); ?>
                <?php else: ?>
                    <?php if($section->parametrs->param184=='t'): ?>
                        <?php if(file_exists($__MDL_ROOT."/php/subpage_table.php")) include $__MDL_ROOT."/php/subpage_table.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_table.tpl")) include $__data->include_tpl($section, "subpage_table"); ?>
                    <?php else: ?>
                        <?php if(file_exists($__MDL_ROOT."/php/subpage_list.php")) include $__MDL_ROOT."/php/subpage_list.php"; if(file_exists($__MDL_ROOT."/tpl/subpage_list.tpl")) include $__data->include_tpl($section, "subpage_list"); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if(!empty($SE_NAVIGATOR)): ?>
                <div class="goodsNavigator bottom"><?php echo $SE_NAVIGATOR ?></div>
            <?php endif; ?>    
        <?php else: ?>
            <div class="noGoodsIntable"><?php echo $section->language->lang023 ?></div>
        <?php endif; ?>
        
        <?php if($section->parametrs->param323=='Y' && $footer_text!=''): ?>
            <?php if(!empty($noindex)): ?><!--noindex--><?php endif; ?>
            <div class="sg_footer_text">
                <?php echo $footer_text ?>
            </div>
            <?php if(!empty($noindex)): ?><!--/noindex--><?php endif; ?>
        <?php endif; ?>
    </div>
</div>
