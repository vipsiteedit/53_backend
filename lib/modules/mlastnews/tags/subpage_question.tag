<noempty:($question)>    
    <h3 class="question-title">{$question['name']}</h3>
    <div class="question-description">{$question['description']}</div> 
    <form class="" method="post">
        <input type="hidden" name="feature" value="{$question['id']}">
        <repeat:features name=feature>
            <label class="">
                <input type="radio" name="f[]" value="[feature.id]">
                <span>[feature.name]</span>
            </label>
        </repeat:features>
        <button class="">Следующий</button>
    </form> 
</noempty>
