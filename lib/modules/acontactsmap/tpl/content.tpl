<header:css>
[include_css]
</header:css>
<?php if(strval($section->parametrs->param15)==Y): ?>
<footer:js>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=<?php echo $section->parametrs->param17 ?>" type="text/javascript"></script>
    [include_js({'id':'<?php echo $section->id ?>','city':'<?php echo $section->parametrs->param10 ?>','addr':'<?php echo $section->parametrs->param11 ?>', 'company':'<?php echo $section->parametrs->param6 ?>'})]
</footer:js>
<?php endif; ?>
<?php if(strval($section->parametrs->param16)!='d'): ?>
<div class="<?php if(strval($section->parametrs->param16)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>">
<?php endif; ?>
<div class="content contacts" <?php echo $section->style ?>><div class="vcard">
<?php if(!empty($section->title)): ?><h3 class="contentTitle" <?php echo $section->style_title ?>>
  <span class="contentTitleTxt"><?php echo $section->title ?></span></h3>
<?php endif; ?>
<?php if(!empty($section->image)): ?>
  <img border="0" class="contentImage" <?php echo $section->style_image ?> src="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>">
<?php endif; ?>
<?php if(!empty($section->text)): ?>
  <div class="contentText"<?php echo $section->style_text ?>><?php echo $section->text ?></div>
<?php endif; ?>
<?php if(strval($section->parametrs->param15)=="Y"): ?>
  <div id="YMapsID<?php echo $section->id ?>" style="width:100%; height:400px" class="maps"></div>
<?php endif; ?>
<div class="addr-block">
<?php if(strval($section->parametrs->param6)!=''): ?>
  <div class="name">
    <span class="orgtitle"><?php echo $section->language->lang007 ?></span><span class="fn org"><?php echo $section->parametrs->param6 ?></span>
  </div>
<?php endif; ?>
  <div class="phone">
    <span class="orgtitle"><?php echo $section->language->lang008 ?></span><span class="tel"><?php echo $section->parametrs->param7 ?></span>
  </div>
  <div class="adr">
    <span class="orgtitle"><?php echo $section->language->lang009 ?></span>
     <span class="postal-code"><?php echo $section->parametrs->param8 ?></span><?php echo $section->parametrs->param13 ?><span class="region"><?php echo $section->parametrs->param9 ?></span><?php echo $section->parametrs->param13 ?> 
     <span class="locality"><?php echo $section->parametrs->param10 ?></span><?php echo $section->parametrs->param13 ?><span class="street-address"><?php echo $section->parametrs->param11 ?></span>
  </div>
  </div>
</div></div>
<?php if(strval($section->parametrs->param16)!='d'): ?>
</div>
<?php endif; ?>
