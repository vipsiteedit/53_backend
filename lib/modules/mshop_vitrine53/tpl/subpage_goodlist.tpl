<header:js>
[lnk:rouble/rouble.css]
[lnk:fancybox2/jquery.fancybox.css]  
</header:js>
<footer:js>
[js:jquery/jquery.min.js]
<?php if($section->parametrs->param327=='Y'): ?>
[js:jquery/jquery.mousewheel.js]
<?php if($section->parametrs->param319=='Y'): ?> 
[js:jquery/jcarousellite.js]
<?php endif; ?>
<?php if($section->parametrs->param311=='Y'): ?> 
[js:jquery/zoomsl.min.js]
<?php endif; ?>
[js:fancybox2/jquery.fancybox.pack.js] 

<script type="text/javascript" src="[module_url]mshop_vitrine53.js"></script>
<script type="text/javascript"> mshop_vitrine53_execute({
    id: <?php echo $section->id ?>,
    param321: '<?php echo $section->parametrs->param321 ?>',
    param307: '<?php echo $section->parametrs->param307 ?>',
    param308: '<?php echo $section->parametrs->param308 ?>',
    param309: '<?php echo $section->parametrs->param309 ?>',
    param233: '<?php echo $section->parametrs->param233 ?>'
});</script>
<?php endif; ?>
</footer:js>
