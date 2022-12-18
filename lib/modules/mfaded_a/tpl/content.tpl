<header:js>
    <link rel="stylesheet" type="text/css" href="[this_url_modul]slick.css"/>
</header:js>
<footer:js>
    [js:jquery/jquery.min.js]
    <script type="text/javascript" src="[this_url_modul]slick.min.js"></script>
    <script type="text/javascript">
         $(document).ready(function () {
     $(".slider_list.n<?php echo $section->id ?>").slick({
         infinite: <?php echo $section->parametrs->param2 ?>,
         slidesToShow: <?php echo $section->parametrs->param3 ?>,
         slidesToScroll: <?php echo $section->parametrs->param4 ?>,
         speed: <?php echo $section->parametrs->param5 ?>,
         centerMode: <?php echo $section->parametrs->param6 ?>,
         dots: <?php echo $section->parametrs->param7 ?>,
         arrows: <?php echo $section->parametrs->param8 ?>,
         variableWidth: <?php echo $section->parametrs->param9 ?>,
         adaptiveHeight: <?php echo $section->parametrs->param10 ?>,
         centerPadding: "<?php echo $section->parametrs->param11 ?>",
         autoplay: <?php echo $section->parametrs->param12 ?>,
         autoplaySpeed: <?php echo $section->parametrs->param13 ?>,
         fade: <?php echo $section->parametrs->param14 ?>,
         prevArrow: '<div class="slick-prev"></div>',
         nextArrow: '<div class="slick-next"></div>',
         responsive: [{
             breakpoint: <?php echo $section->parametrs->param17 ?>,
             settings: {
                 slidesToShow: <?php echo $section->parametrs->param18 ?>,
                 dots: <?php echo $section->parametrs->param19 ?>,
                 arrows: <?php echo $section->parametrs->param24 ?>
             }
         }]
     });
<?php if(strval($section->parametrs->param16)=='true'): ?>
<?php if(strval($section->parametrs->param20)=='true'): ?>
var slider_width = $(".slider_list.n<?php echo $section->id ?>").width(),
    slider_height,
    percent = <?php echo $section->parametrs->param15 ?>,
    object_Image = $(".slider_list.n<?php echo $section->id ?> .slick-list .objectImage");
if ($(window).width() <= <?php echo $section->parametrs->param17 ?>) {
    percent = <?php echo $section->parametrs->param21 ?>;
}
slider_height = slider_width / 100;
//console.log(slider_height);
slider_height = slider_height * percent;
object_Image.css("height", slider_height);
 <?php endif; ?>
 <?php endif; ?>
 });
$(window).resize(function(){
    var slider_width = $(".slider_list.n<?php echo $section->id ?>").width(),
    slider_height,
    percent = <?php echo $section->parametrs->param15 ?>,
    object_Image = $(".slider_list.n<?php echo $section->id ?> .slick-list .objectImage");
if ($(window).width() <= <?php echo $section->parametrs->param17 ?>) {
    percent = <?php echo $section->parametrs->param21 ?>;
}
slider_height = slider_width / 100;
//console.log(slider_height);
slider_height = slider_height * percent;
object_Image.css("height", slider_height);
})
</script>
</footer:js>
<?php if(strval($section->parametrs->param8)!='d'): ?><div class="slider-wrapper <?php if(strval($section->parametrs->param23)=='n'): ?>container<?php endif; ?>"><?php endif; ?>
<div class="content slider <?php if(strval($section->parametrs->param22)=='false'): ?>slider-pagination-dots<?php endif; ?>" data-seimglist="<?php echo $section->id ?>" >
    <?php if(!empty($section->title)): ?>
    <h3 class="contentTitle">
    <span class="contentTitleTxt"><?php echo $section->title ?></span>
    </h3>
    <?php endif; ?>
    <?php if(!empty($section->image)): ?>
    <img border="0" class="contentImage" src="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>">
    <?php endif; ?>
    <?php if(!empty($section->text)): ?>
    <div class="contentText"<?php echo $section->style_text ?>><?php echo $section->text ?></div>
    <?php endif; ?>
    <?php echo $__data->linkAddRecord($section->id) ?>
    <ul class="slider_list n<?php echo $section->id ?>">
        <?php foreach($__data->limitObjects($section, $section->objectcount) as $record): ?>

        <li class="slider-item"<?php echo $__data->editItemRecord($section->id, $record->id) ?>>
            <div class="slider-item_text ">
             <div class="slider-item-text-container container">
              <div class="slider-item-text-container-sizer">
            <?php if(!empty($record->title)): ?>
            <h4 class="objectTitle">
                <span class="objectTitleTxt"><?php echo $record->title ?></span>
            </h4>
            <?php endif; ?>
            <?php if(!empty($record->note)): ?>
            <div class="objectNote"><?php echo $record->note ?></div>
            <?php endif; ?>
            <?php if(!empty($record->field)): ?>
            <a class="linkNext" href="<?php echo $record->field ?>"><?php echo $section->language->lang001 ?></a>
            <?php endif; ?>
              </div>
             </div>
            </div>
            <?php if(!empty($record->image)): ?>
            <?php if(strval($section->parametrs->param16)=='true'): ?><div class="objectImage" style="background-image: url(<?php echo $record->image_prev ?>);"></div><?php else: ?><img class="objectImage" src="<?php echo $record->image_prev ?>" alt="<?php echo $record->image_alt ?>"><?php endif; ?>
            <?php endif; ?>
        </li>
        
<?php endforeach; ?>
    </ul>
</div>
<?php if(strval($section->parametrs->param23)!='d'): ?></div><?php endif; ?>
