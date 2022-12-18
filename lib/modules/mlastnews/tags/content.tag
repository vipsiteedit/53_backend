<div class="content contLastNews" [contentstyle][contedit]>
    <noempty:part.title>
        <[part.title_tag] class="contentTitle"[part.style_title]>
            <span class="contentTitleTxt">[part.title]</span>
        </[part.title_tag]>
    </noempty>
    <noempty:part.image>
        <img class="contentImage" [part.style_image] src="[part.image]" alt="[part.image_alt]" title="[part.image_title]">
    </noempty>
    <noempty:part.text>
        <div class="contentText" [part.style_text]>[part.text]</div>
    </noempty>
    <div class="contentBody"> 
    <repeat:objects>
        <div class="object">
            <h4 class="objectTitle">
                <span class="dataType_date">[record.date]</span>
                <a class="textTitle" href="<SERV>[record.link]</SERV><SE>[param2].html</SE>">[record.title]</a>
            </h4>
            <if:[param3]=='Y'>
                <noempty:record.image_prev> 
                    <a href="<SERV>[record.link]</SERV><SE>[param2].html</SE>">
                        <img src="[record.image_prev]" alt="[record.title]" alt="[record.image_alt]" title="[record.image_title]" class="objectImage">
                    </a>
                </noempty>
            </if>        
            <div class="objectNote">[record.note]</div> 
            <if:[param4]=='Y'>
                <a class="newslink" href="<SERV>[record.link]</SERV><SE>[param2].html</SE>">[lang001]</a>
            </if>
        </div>
    </repeat:objects>
    <a class="linkNews" href="[param2].html">[lang002]</a>
    </div>
</div>
