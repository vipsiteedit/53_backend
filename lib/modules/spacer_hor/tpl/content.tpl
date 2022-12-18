<?php if(strval($section->parametrs->param1)!='d'): ?><div class="<?php if(strval($section->parametrs->param1)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>"><?php endif; ?>
<div style="width: 100%; height: <?php echo $section->parametrs->param2 ?>px;"></div>
<?php if(strval($section->parametrs->param1)!='d'): ?></div><?php endif; ?>
