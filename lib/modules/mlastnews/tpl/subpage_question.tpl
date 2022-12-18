<?php if(!empty($question)): ?>    
    <h3 class="question-title"><?php echo $question['name'] ?></h3>
    <div class="question-description"><?php echo $question['description'] ?></div> 
    <form class="" method="post">
        <input type="hidden" name="feature" value="<?php echo $question['id'] ?>">
        <?php foreach($section->features as $feature): ?>
            <label class="">
                <input type="radio" name="f[]" value="<?php echo $feature->id ?>">
                <span><?php echo $feature->name ?></span>
            </label>
        
<?php endforeach; ?>
        <button class="">Следующий</button>
    </form> 
<?php endif; ?>
