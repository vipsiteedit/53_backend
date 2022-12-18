<footer:js>
[js:jquery/jquery.min.js]

<script type="text/javascript" src="[module_url]anavcatalog_top.js"></script>
<script type="text/javascript"> anavcatalog_top_execute();</script>
</footer:js>
<style>
.headerCatalogItem.horiz .headerCatalogSub {
    -webkit-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
    background-color: #fff;
    box-shadow: 0 0 10px 2px #c1c1c1;
    z-index:20;
}
.headerCatalogItem.horiz:hover .headerCatalogSub { display: inline-block !important;}
@media (min-width: 992px) {
   #se-collapse-menu.collapse {
       display:block;
   }
}
@media (max-width:991px) {
    li.headerCatalogItem.horiz {
        display:block !important;
    }    
    ul.groupList {
        -webkit-padding-start: 0px;
        -moz-padding-start: 0px;
        -o-padding-start: 0px;
        -ms-padding-start: 0px;                
    }
    .headerCatalogItem.horiz:hover .headerCatalogSub {
        display: none !important;
    }
}
</style>
<div class="hidden-lg hidden-md button_menu" data-toggle="collapse" data-target="#se-collapse-menu">
    <span class="title-button-menu"><ml><?php echo $section->language->lang015 ?></ml></span>
    <div class="nav-button">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </div>
</div>
<div class="collapse clearfix" data-type="<?php echo $section->type ?>" data-id="<?php echo $section->id ?>" id="se-collapse-menu">
    <nav class="headerCatalog col-lg-12 col-md-12 col-sm-12 col-xs-12">
       <ul class="groupList">
       <?php foreach($section->catalog as $item): ?>
           <li class="headerCatalogItem horiz" data-id="<?php echo $item->id ?>">
               <a href="<?php echo $path ?><?php echo $item->link ?>" class="headerCatalogSubItem headerCatalogSubSection headerCatalogSubNormal">
               <span class="text"><?php if(strval($section->parametrs->param18)=='Y'): ?><?php if(!empty($item->image)): ?><img class="catalogPromoIcon" src="<?php echo $item->image ?>" alt=""><?php endif; ?><?php endif; ?> <?php echo $item->name ?></span>
               <span class="headerCatalogNib"></span></a>
               <?php if(!empty($item->menu)): ?>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 headerCatalogSub" style="display:none">
                    <div class="catWindow">
                         
                    </div>
               </div>
               <div class="arrow-down" style=""></div>
               <?php endif; ?>
               
           </li>
       
<?php endforeach; ?>
       </ul>
    </nav>
</div>
