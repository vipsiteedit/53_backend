<header:css>
    [include_css]
    <if:[param4]=='s'>
        <link href="[module_url]jcarousel.responsive.css" rel="stylesheet" type="text/css">
        <serv>
        <style>
               .part[part.id] .jcarousel {
                   font-size: 14px;
                   margin: 0;
               }               
        </style>
        </serv>
    </if>
</header:css>
<se>
        <style>
               .part[part.id] .jcarousel {
                   font-size: 14px;
                   margin: 0;
               }
        </style>
</se>
<footer:js>
    <if:[param4]=='s'>
        <script type="text/javascript" src="[module_url]jquery.jcarousel.min.js"></script>
        <script type="text/javascript" src="[module_url]jcarousel.responsive.js"></script>
    </if> 
</footer:js>
<div class="<if:[param1]=='n'>container<else>container-fluid</if>">
<section class="content b_brendline part[part.id]" [contedit]>
    <noempty:part.title>
        <[part.title_tag] class="contentTitle"[part.style_title]>
            <span class="contentTitleTxt">[part.title]</span>
        </[part.title_tag]>
    </noempty>
    <noempty:part.image>
        <img border="0" class="contentImage"[part.style_image] src="[part.image]" alt="[part.image_alt]">
    </noempty>
    <noempty:part.text>
        <div class="contentText"[part.style_text]>[part.text]</div>
    </noempty>
    <div class="b_brendline_brend_group <if:[param4]=='s'>slider</if>">
    <if:[param4]=='b'>
      <repeat:items name=item>
        <div class="b_brendline-brend_item" [objedit]>
          <noempty:[item.picture]>
            <a class="objectImage" href="[item.url]">
                <img class="b_brendline-brend_img" border="0" src="[item.picture]" border="0" alt="[item.picture_alt]" style="width: 100%">
            </a>
          </noempty>
        </div>
      </repeat:items>
    </if>
    
    <if:[param4]=='s'> 
       <div class="jcarousel-wrapper">
   <div class="jcarousel">
    <ul>
                    <repeat:items name=item>
                        <noempty:[item.picture]>                         
         <li>
          <div class="jcarousel-inner">
           <a  href="[item.url]" class="jcarousel-image-container">
            <img src="[item.picture]" alt="[item.picture_alt]"> 
           </a>                           
          </div>
         </li>
                        </noempty>
                    </repeat:items>
    </ul>
   </div>
   <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
   <a href="#" class="jcarousel-control-next">&rsaquo;</a>
   <p class="jcarousel-pagination"></p>
  </div> 
    </if>
    
    
    </div>
</section></div>  
