<footer:js>
[js:jquery/jquery.min.js]
<script type="text/javascript">
    var prcInWork = 0, prsSub = [];
    $('.headerCatalog .headerCatalogItem.horiz').hover(function(){
        prcInWork = 1;
        var id = $(this).data('id'), $this = this;
        
        if ($.inArray(id,prsSub) == -1) {
        $.post('?loadsubcatalog', {id: id, level: 1}, function(data){
            if (data != '') {
                $($this).find('.headerCatalogSub .catWindow').html(data);
                prsSub.push(id);
            } else {
              //  return true;
            }
        }, 
        'html');
        }
        
        return false;
    }, function(){
    });
</script>
</footer:js>
<style>
.headerCatalogItem.horiz .headerCatalogSub {
    -webkit-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
}
.headerCatalogItem.horiz:hover .headerCatalogSub { display: inline-block!important; }
</style>
<nav class="headerCatalog">
       <ul class="groupList">
       <?php foreach($section->catalog as $item): ?>
           <li class="headerCatalogItem horiz" data-id="<?php echo $item->id ?>">
               <a href="<?php echo $path ?><?php echo $item->link ?>" class="headerCatalogSubItem headerCatalogSubSection headerCatalogSubNormal">
               <span class="text"><?php if(!empty($item->image)): ?><img class="catalogPromoIcon" src="<?php echo $image_dir ?><?php echo $item->image ?>" alt=""><?php endif; ?> <?php echo $item->name ?></span>
               <span class="headerCatalogNib"></span></a>
               <?php if(!empty($item->menu)): ?>
               <div class="headerCatalogSub" style="display:none"><div class="catWindow">
               
               </div></div><?php endif; ?>
           </li>
       
<?php endforeach; ?>
       </ul>
</nav>
