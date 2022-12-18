<header:css>
[include_css]
</header:css>
<div class="<if:[param10]=='n'>container<else>container-fluid</if>">
<section class="content b_news_informer"[contedit]>
    <noempty:part.title>
        <[part.title_tag] class="contentTitle">
            <span class="contentTitleTxt">[part.title]</span>
        </[part.title_tag]>
    </noempty>
    <noempty:part.image>
        <img border="0" class="contentImage lasy" data-original="[part.image]" alt="[part.image_alt]" title="[part.image_alt]">
    </noempty>
    <noempty:part.text>
        <div class="contentText" >[part.text]</div>
    </noempty>
    <div class="b_news_informer-content_area row">
    <div class="b_news_informer-news_group_area col-xs-12 col-md-9">
    <div class="b_news_informer-news_group row">
    <repeat:objects> 
        <div class="b_news_informer-news_item col-lg-6 col-xs-12">
                <noempty:record.image_prev>
                    <a class="b_news_informer-news_img_area objectImageLink" href="[record.shownews]">
                        <img border="0" class="b_news_informer-news_img" src="[record.image_prev]" alt="[record.image_alt]">
                    </a>
                </noempty>
                <div class="b_news_informer-news_text_area objectNote">
                     <h4 class="b_news_informer-news_title objectTitle">
                         <a class="b_news_informer-news_title_text textTitle" href="[record.shownews]">[record.title]</a>
                     </h4>
                     <div class="b_news_informer-news_date dataType_date">[record.news_date]</div>
                     <div class="b_news_informer-news_text">[record.note]</div>
                </div>
        </div>
    </repeat:objects>
    </div>
    </div>
    <div class="b_news_informer-more_news_link_area col-md-3 col-xs-12">
              <a class="linkNews btn btn-default b_news_informer-more_news_link" href="[param2].html">[param8]</a>
    </div>
    </div>
    <SE>
        <p style="clear:both; border-width:3px; padding: 5pt; font-size:12px; border-color: #FF0000; border-style:dashed; width=100%; height=auto; background-color:white; color:black; " class="sysedit">Не забудьте указать в "Дополнительных настройках" ссылку на страницу новостей. Указанная ссылка: <a href="[param2].html">[param2].html</a> </p>
    </SE>
</section></div>
