<header:css>
[include_css]
</header:css>
<div class="<?php if(strval($section->parametrs->param17)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>" data-semenu="<?php echo $section->parametrs->param16 ?>">
    <nav class="bs-menu-bottom">
    <div class="row">
    <? if(function_exists('getItemMenu')){ list($menuitems) = getItemMenu($section->parametrs->param16); $__data->setList($section,'menuitems', $menuitems);} ?>
<?php foreach($section->menuitems as $item): ?>
    <div class="mbot-col">
        <a href="<?php echo $item->url ?>" class="mbot-section">
        <?php if(!empty($item->image)): ?><img class="promo-icon img-responsive" src="<?php echo $item->image ?>" alt=""><?php endif; ?> <?php echo $item->title ?></a>
        <?php if(!empty($item->items)): ?>
        <ul class="subsubitems">
        <?php foreach($item->items as $ssitem): ?>
            <li>
            <a href="<?php echo $ssitem->url ?>" class="mbot-subitem"><?php echo $ssitem->title ?></a>
            <?php if(!empty($ssitem->items)): ?>
            <ul class="mbot-sub-items">
                <?php foreach($ssitem->items as $sssitem): ?>
                <li>
                    <a href="<?php echo $sssitem->url ?>" class="mbot-subitem"><?php echo $sssitem->title ?></a>
                </li>
                
<?php endforeach; ?>
            </ul>
            <?php endif; ?>
            </li> 
        
<?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

<?php endforeach; ?>
       
       
       </div>
    </nav>
</div>
