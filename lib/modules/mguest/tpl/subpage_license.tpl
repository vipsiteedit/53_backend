<div class="blockLicense">
    <?php if(strval($section->parametrs->param44)=='Y'): ?>
        <div class="license-item">
            <label>
                <input type="checkbox" name="personal_accepted" <?php echo $personal_checked ?> required>
                <?php echo $section->parametrs->param45 ?>
            </label>
        </div>
    <?php endif; ?>
    <?php if(strval($section->parametrs->param46)=='Y'): ?>
        <div class="license-item">
            <label>
                <input type="checkbox" name="additional_accepted" <?php echo $additional_checked ?> required>
                <?php echo $section->parametrs->param47 ?>
            </label>
        </div>
    <?php endif; ?>
</div>
