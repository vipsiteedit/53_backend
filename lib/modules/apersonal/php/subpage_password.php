<?php

$error = $success = '';

if (isRequest('save_pass')){
    $old_pass = md5(getRequest('old_pass'));   
    $new_pass = trim(getRequest('new_pass'));   
        
    $se_user = new seTable('se_user');
    $se_user->select('id, password');
    $se_user->find($id_user);
    $password = $se_user->password;
    
    if ($old_pass != $password)
        $error = 'Старый пароль введен неверно';
    elseif (empty($new_pass))
        $error = 'Необходимо указать новый пароль';
        
    if (empty($error)) {
        $se_user->password = md5($new_pass);    
        if ($se_user->save())
            $success = 'Новый пароль успешно сохранен';
    }
    
}

?>