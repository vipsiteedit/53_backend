<header:css>
    [include_css]
</header:css>
<footer:js>
    [js:jquery/jquery.min.js]
    [include_js()]
</footer:js>
<div class="<?php if(strval($section->parametrs->param1)=='n'): ?>container<?php else: ?>container-fluid<?php endif; ?>">
    <div class="content contChangePersonal">
        <h3>Изменить персональные данные</h3>
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
        <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
            <h4>Персональные данные</h4>
            <div class="form-group">
                <label for="" class="control-label"></label>
                <div class="personaltr">
                    <?php if(!empty($avatar)): ?>
                    <img class="image-avatar" src="<?php echo $avatar ?>" data-img="<?php echo $avatar ?>">
                    <?php endif; ?>
                    <a class="change-avatar" href="#">изменить</a>
                    <input class="form-control" type="file" name="avatar" style="display:none;">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Фамилия</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="last_name" value="<?php echo $last_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Имя</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="first_name" value="<?php echo $first_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Отчество</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="sec_name" value="<?php echo $sec_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Дата рождения</label>
                <div class="personaltr">
                    <input class="form-control" type="date" name="birth_date" value="<?php echo $birth_date ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Пол</label>
                <div class="personaltr">
                    <select class="form-control" name="sex">
                        <option value="">Не выбран</option>
                        <option value="M" <?php if($sex=='M'): ?>selected<?php endif; ?>>Мужской</option>
                        <option value="F" <?php if($sex=='F'): ?>selected<?php endif; ?>>Женский</option>
                    </select>
                </div>
            </div>
            <?php if(strval($section->parametrs->param1)=='Y'): ?>
            <h4>Паспортные данные</h4>
            <div class="form-group">
                <label for="" class="control-label">Серия</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="doc_ser" value="<?php echo $doc_ser ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Номер</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="doc_num" value="<?php echo $doc_num ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Выдан</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="doc_text" value="<?php echo $doc_text ?>">
                </div>
            </div>
            <?php endif; ?>
            <h4>Контактные данные</h4>
            <div class="form-group">
                <label for="" class="control-label">Телефон</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="phone" value="<?php echo $phone ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">E-mail</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="email" value="<?php echo $email ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Skype</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="skype" value="<?php echo $skype ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">ICQ</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="icq" value="<?php echo $icq ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Индекс</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="post_index" value="<?php echo $post_index ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Адрес</label>
                <div class="personaltr">
                    <input class="form-control" type="text" name="address" value="<?php echo $address ?>">
                </div>
            </div>
            <div class="form-group btn-box">
                <a class="btn btn-default" href="<?php echo seMultiDir()."/".$_page."/" ?>">Назад</a>
                <button type="submit" class=" btn btn-default" name="save_personal">Сохранить</button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
