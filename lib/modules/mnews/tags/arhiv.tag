
        <div class="content cont_news_arhiv <if:[param11]=='a'>container<else>container-fluid</if>" id="arh_news">
            <h3 class="contentTitle" [part.style_title]>
                <span class="contentTitleTxt">[part.title]</span>
            </h3> 
            [SE_PARTSELECTOR]
            <ul> 
                <repeat:records>
                    <li class="arhivTitle">
                        <a id="links" href="[record.link_detail]">[record.field] [record.title]</a>
                    </li>
                </repeat:records>
            </ul> 
            <input class="buttonSend" onclick="document.location = '[thispage.link]';" type="button" value="[param4]">
        </div>
        
