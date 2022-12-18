<header:css>
    [include_css]
</header:css>
<footer:js>
    [js:jquery/jquery.min.js]
    [include_js()]
</footer:js>
<style>
.show-password {
position: absolute;
top: 10px;
right: 30px;
opacity:0.5;
cursor: pointer;
}
</style>
<div class="<?php if(strval($section->parametrs->param1)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>">
    <div class="content contChangePersonal">
        <h3>Изменить пароль</h3>
        <?php if(!empty($error)): ?>
        <div class="error-text">
            <?php echo $error ?>
        </div>
        <?php endif; ?>
        <?php if(!empty($success)): ?>
        <div class="success-text">
            <?php echo $success ?>
        </div>
        <?php endif; ?>
        <form class="form-horizontal" method="POST" action="">
            <div class="form-group<?php if(!empty($error_name)): ?> has-error<?php endif; ?>">
                <label for="" class="control-label">Старый пароль<span class="required">*</span></label>
                <div class="personaltr">
                    <input class="form-control" type="password" name="old_pass" required>
                    <span class="help-block"<?php if(empty($error_name)): ?> style="display:none;"<?php endif; ?>>Необходимо указать старый пароль</span>
                    <i class="show-password glyphicon glyphicon-eye-open" title="Показать/скрыть пароль"></i>
                </div>
            </div>
            <div class="form-group<?php if(!empty($error_name)): ?> has-error<?php endif; ?>">
                <label for="" class="control-label">Новый пароль<span class="required">*</span></label>
                <div class="personaltr">
                    <input class="form-control" type="password" name="new_pass" required>
                    <span class="help-block"<?php if(empty($error_name)): ?> style="display:none;"<?php endif; ?>>Необходимо указать новый пароль</span>
                    <i class="show-password glyphicon glyphicon-eye-open" title="Показать/скрыть пароль"></i>
                </div>
            </div>
            <div class="form-group btn-box">
                <div class="text-right">
                    <a class="btn btn-default" href="<?php echo seMultiDir()."/".$_page."/" ?>">Назад</a>
                    <button class="btn btn-default" name="save_pass">Сохранить</button>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
