<header:css>
    [include_css]
</header:css>
<footer:js> 
[js:jquery/jquery.min.js]
[js:jquery/jquery.printElement.js]
</footer:js>
<div class="<?php if(strval($section->parametrs->param1)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>">
<section class="content aPayee">
    <span class="blank">
        <?php echo $blank ?>      
    </span>
    <div class="buttonArea back">
        <a class="btn btn-default" href="<?php echo seMultiDir()."/".$_page."/" ?>"><?php echo $section->language->lang060 ?></a>
    <?php if($type=='p'): ?>
        <button class="btn btn-default" onclick="$('.aPayee .blank').printElement({pageTitle:'<?php echo $thispagetitle ?>'});"><?php echo $section->language->lang061 ?></button>
    <?php endif; ?>
    </div>
</section>
</div>
