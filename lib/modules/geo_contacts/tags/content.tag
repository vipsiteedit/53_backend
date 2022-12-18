<footer:js>
[js:jquery/jquery.min.js]
<if:[param2]=='Y'>
    <script src="http://api-maps.yandex.ru/2.1/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
</if>
</footer:js>
<div class="content contShopContacts" data-type="[part.type]" data-id="[part.id]" [contedit]>
    <noempty:part.title>
        <h3 class="contentTitle">
            <span class="contentTitleTxt">[part.title]</span>
        </h3>
    </noempty>
    <noempty:part.image>
        <img border="0" class="contentImage" src="[part.image]" alt="[part.image_alt]" title="[part.image_alt]">
    </noempty>
    <noempty:part.text>
        <div class="contentText">[part.text]</div>
    </noempty>  
    <div class="contentBody">
        <repeat:contacts name=contact>
             <div class="contact-item" data-id="[contact.id]">
                <h4 class="contact-item-title">
                    <span class="">[contact.name]</span>
                </h4>
                <div class="contact-item-address">
                    [lang001] <span class="">[contact.address]</span>
                </div>
                <div class="contact-item-phone">
                    [lang002] <span class="">[contact.phone]</span>
                </div>
                <div class="contact-item-text">
                    [contact.description]
                </div>   
                <if:[param2]=='Y' && [contact.address] != ''>
                    [subpage name=ymap]
                </if>
            </div>
        </repeat:contacts> 
    </div>
</div>
