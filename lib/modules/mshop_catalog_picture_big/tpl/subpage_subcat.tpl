<?php foreach($section->subcatalog as $subitem): ?>
    <ul class="headerCatalogCol">
    <li>
        <a href="<?php echo $path ?><?php echo $subitem->link ?>" class="headerCatalogSubItem headerCatalogSubSection headerCatalogSubNormal">
        <?php if(!empty($subitem->image)): ?><img class="catalogPromoIcon" src="<?php echo $image_dir ?><?php echo $subitem->image ?>" alt=""><?php endif; ?> <?php echo $subitem->name ?></a>
        </li>
        <?php $__list = 'subsubcatalog'.$subitem->id; foreach($section->$__list as $subsubitem): ?>
        <li>
        <a href="<?php echo $path ?><?php echo $subsubitem->link ?>" class="headerCatalogSubItem headerCatalogSubNormal"><?php echo $subsubitem->name ?></a>
        </li> 
        
<?php endforeach; ?>
    </ul>
<?php endforeach; ?>
