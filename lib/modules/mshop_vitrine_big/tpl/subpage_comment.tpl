<a name="comment"></a>
<div class="comment">
    <h4 class="titleHead"><?php echo $section->language->lang044 ?></h4>
<?php if($comm=='0'): ?>
    <div class="no_comment"><?php echo $section->language->lang050 ?></div>
<?php else: ?>
    <table class="tableTable tableComment" cellSpacing="0" cellPadding="0" width="100%">
        <?php foreach($section->comments as $comm): ?>
            <tr class="tableRow <?php echo $comm->style ?>">
                <td> 
                    <div class="comm_date"><?php echo $comm->date ?></div> 
                    <div class="comm_titlename"><?php echo $comm->name ?></div> 
                    <div class="comm_txt"><?php echo $comm->comment ?> </div>
                    <?php if(!empty($comm->adminnote)): ?>
                        <div class="comm_admnote"><?php echo $section->language->lang049 ?> <?php echo $comm->adminnote ?></div>
                    <?php endif; ?>
                </td>
            </tr> 
        
<?php endforeach; ?>
    </table>
    
<?php endif; ?>
    <?php if($usergroup!=0): ?>
        <a name="addcomment"></a>
        <div class="addComment">
            <form style="margin:0px;" method="post" action="">
                <div class="error"><?php echo $error_comm_message ?></div>
                <div class="title"><?php echo $section->language->lang045 ?></div>
                <textarea class="areatext" title="<?php echo $section->language->lang045 ?>" name="comm_note" rows="7"></textarea>
                <input class="buttonSend" type="submit" value="<?php echo $section->language->lang046 ?>" name="GoToComment">
            </form> 
        </div>
    <?php else: ?>
        <div class="comm_info"><?php echo $section->language->lang047 ?></div>
    <?php endif; ?>
    
</div>
