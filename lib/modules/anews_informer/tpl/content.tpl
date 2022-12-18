<header:css>
[include_css]
</header:css>
<div class="<?php if(strval($section->parametrs->param10)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>">
<section class="content b_news_informer">
    <?php if(!empty($section->title)): ?>
        <<?php echo $section->title_tag ?> class="contentTitle">
            <span class="contentTitleTxt"><?php echo $section->title ?></span>
        </<?php echo $section->title_tag ?>>
    <?php endif; ?>
    <?php if(!empty($section->image)): ?>
        <img border="0" class="contentImage lasy" data-original="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>" title="<?php echo $section->image_alt ?>">
    <?php endif; ?>
    <?php if(!empty($section->text)): ?>
        <div class="contentText" ><?php echo $section->text ?></div>
    <?php endif; ?>
    <div class="b_news_informer-content_area row">
    <div class="b_news_informer-news_group_area col-xs-12 col-md-9">
    <div class="b_news_informer-news_group row">
    <?php foreach($section->objects as $record): ?> 
        <div class="b_news_informer-news_item col-lg-6 col-xs-12">
                <?php if(!empty($record->image_prev)): ?>
                    <a class="b_news_informer-news_img_area objectImageLink" href="<?php echo $record->shownews ?>">
                        <img border="0" class="b_news_informer-news_img" src="<?php echo $record->image_prev ?>" alt="<?php echo $record->image_alt ?>">
                    </a>
                <?php endif; ?>
                <div class="b_news_informer-news_text_area objectNote">
                     <h4 class="b_news_informer-news_title objectTitle">
                         <a class="b_news_informer-news_title_text textTitle" href="<?php echo $record->shownews ?>"><?php echo $record->title ?></a>
                     </h4>
                     <div class="b_news_informer-news_date dataType_date"><?php echo $record->news_date ?></div>
                     <div class="b_news_informer-news_text"><?php echo $record->note ?></div>
                </div>
        </div>
    
<?php endforeach; ?>
    </div>
    </div>
    <div class="b_news_informer-more_news_link_area col-md-3 col-xs-12">
              <a class="linkNews btn btn-default b_news_informer-more_news_link" href="<?php echo seMultiDir()."/".$section->parametrs->param2."/" ?>"><?php echo $section->parametrs->param8 ?></a>
    </div>
    </div>
    
</section></div>
