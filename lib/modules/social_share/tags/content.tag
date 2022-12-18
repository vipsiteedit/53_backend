<if:([param7]=='Y')>
<style type='text/css'>
    .social_share #share42 {
        display: inline-block;
        padding: 6px 0 0 6px;
    <if:[param6]=='white'>
        background: #FFF;
        border: 1px solid #E9E9E9;
        border-radius: 4px;
    </if>          
    }
    .social_share #share42:hover {
    <if:[param6]=='white'>
        background: #F6F6F6;
        border: 1px solid #D4D4D4;
        box-shadow: 0 0 5px #DDD;
    </if>          
    }
    .social_share #share42 a {opacity: 0.7;}
    .social_share #share42:hover a {opacity: 0.7}
    .social_share #share42 a:hover {opacity: 1}    
    <if:[param1]=='2'>
    .social_share {
        margin-top:-10%; position:fixed; top:50%;
        <if:[param5]=='left'>
            left:0px; right: none;
        <else>
            right:0px; left: none;
        </if>
    }
    </if>
</style>
</if>
<footer:js>
    [js:jquery/jquery.min.js]
    <if:[param1]=='1'>
        [subpage name=1]
    <else>
        [subpage name=2]
    </if>
</footer:js>
<div class="social_share" [part.style][contedit]>
<noempty:part.title>
    <h3 class="contentTitle" [part.style_title]>
        <span class="contentTitleTxt">[part.title]</span>
    </h3>
</noempty>
<noempty:part.image>
    <img class="contentImage" [part.style_image] src="[part.image]" alt="[part.image_alt]">
</noempty>
<noempty:part.text>
    <div class="contentText"[part.style_text]>[part.text]</div>
</noempty>
    <div class="contentBody">
        <div class="share42init" data-url="{$url}" data-title="[part.title]"></div>
        <footer:js>
            <script type="text/javascript">share42('<SE>../content/</SE>[this_url_modul]'<if:[param1]==2>, 150, 20</if>)</script>
        </footer:js>
    </div>
</div>
