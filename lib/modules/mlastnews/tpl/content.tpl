<div class="content contLastNews" <?php echo $section->style ?>>
    <?php if(!empty($section->title)): ?>
        <<?php echo $section->title_tag ?> class="contentTitle"<?php echo $section->style_title ?>>
            <span class="contentTitleTxt"><?php echo $section->title ?></span>
        </<?php echo $section->title_tag ?>>
    <?php endif; ?>
    <?php if(!empty($section->image)): ?>
        <img class="contentImage" <?php echo $section->style_image ?> src="<?php echo $section->image ?>" alt="<?php echo $section->image_alt ?>" title="<?php echo $section->image_title ?>">
    <?php endif; ?>
    <?php if(!empty($section->text)): ?>
        <div class="contentText" <?php echo $section->style_text ?>><?php echo $section->text ?></div>
    <?php endif; ?>
    <div class="contentBody"> 
    <?php foreach($section->objects as $record): ?>
        <div class="object">
            <h4 class="objectTitle">
                <span class="dataType_date"><?php echo $record->date ?></span>
                <a class="textTitle" href="<?php echo $record->link ?>"><?php echo $record->title ?></a>
            </h4>
            <?php if(strval($section->parametrs->param3)=='Y'): ?>
                <?php if(!empty($record->image_prev)): ?> 
                    <a href="<?php echo $record->link ?>">
                        <img src="<?php echo $record->image_prev ?>" alt="<?php echo $record->title ?>" alt="<?php echo $record->image_alt ?>" title="<?php echo $record->image_title ?>" class="objectImage">
                    </a>
                <?php endif; ?>
            <?php endif; ?>        
            <div class="objectNote"><?php echo $record->note ?></div> 
            <?php if(strval($section->parametrs->param4)=='Y'): ?>
                <a class="newslink" href="<?php echo $record->link ?>"><?php echo $section->language->lang001 ?></a>
            <?php endif; ?>
        </div>
    
<?php endforeach; ?>
    <a class="linkNews" href="<?php echo seMultiDir()."/".$section->parametrs->param2."/" ?>"><?php echo $section->language->lang002 ?></a>
    </div>
</div>
