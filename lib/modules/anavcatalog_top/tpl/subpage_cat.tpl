<?php if(strval($section->parametrs->param16)=='Y'): ?>
<?php if(!empty($description)): ?>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 head-row">
<?php endif; ?>
<?php endif; ?>
<div class='row'>
<?php foreach($section->subcatalog as $subitem): ?>
    <ul class="headerCatalogCol" style="width:calc(<?php echo $count_width ?>% - 30px) !important; border-right: 1px solid #f0f0f0;">
    <li>
        <a href="<?php echo $path ?><?php echo $subitem->link ?>" class="headerCatalogSubItem headerCatalogSubSection headerCatalogSubNormal">
        <?php if(strval($section->parametrs->param17)=='Y'): ?><?php if(!empty($subitem->image)): ?><img class="catalogPromoIcon img-responsive" src="<?php echo $image_dir ?><?php echo $subitem->image ?>" alt=""><?php endif; ?><?php endif; ?> <?php echo $subitem->name ?></a>
        <ul class="subsubitems">
        <?php $__list = 'subsubcatalog'.$subitem->id; foreach($section->$__list as $subsubitem): ?>
        <li>
        <a href="<?php echo $path ?><?php echo $subsubitem->link ?>" class="headerCatalogSubItem headerCatalogSubNormal"><?php echo $subsubitem->name ?></a>
        </li> 
        
<?php endforeach; ?>
        </ul>
        </li>
    </ul>
    <?php if($subitem->midrow==1): ?> 
        </div><div class='row'>
    <?php endif; ?>
<?php endforeach; ?>
</div>
<?php if(strval($section->parametrs->param16)=='Y'): ?>
<?php if(!empty($description)): ?>
   </div><div class="col-lg-3 col-md-3 col-sm-3 hidden-xs sub-decsription"><?php echo $description ?></div>
<?php endif; ?>
<?php endif; ?>
