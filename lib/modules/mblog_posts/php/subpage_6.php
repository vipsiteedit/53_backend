<?php

$show = 0;
$sid = getRequest('sid');
$tim = getRequest('tim');
$usrName = seUserName();
$idlink = 0;
if (isRequest('showlink')) {
    $idlink = getRequest('idlink'); // получаем номер родительского сообщения
    $show = 1;
/* 
    $anti_spam = '<div>
                    <div  class="tablrow">
                    <img id="pin_img" src="/lib/cardimage.php?session=' . $sid . '&'.$tim.'">
                    <div class="titlepin">' . $section->parametrs->param11 . '</div>
                        <input class="inp inppin" name="pin' . $idlink . '" maxlength="5" value="" autocomplete="off">
                    </div> 
                  </div>';
//*/
    //конец генерации антиспама
/*
    $ech = 
'<div class="addcommmenttt comments_insvn">' .
    (($usrName == "") ? 
        '<div class="obj name">' .
            '<label class="title" for="name">' . $section->parametrs->param33 . '</label>' .
            '<div class="field">' .
                '<input class="inputs" id="name" name="name' . $idlink . '"  maxlength="255">' .
            '</div>' 
        '</div>'
    : '') .
    '<div class="comments_ins_title">' . $section->parametrs->param8 . '</div>' .  
    '<textarea class="comments_ins_text" rows="3" cols="commentsinstext" name="commentsinstext' . $idlink . '"></textarea>' .               
    '<div>' .
        '<div class="tablrow">' .
            '<img id="pin_img" src="/lib/cardimage.php?session=' . $sid . '&' . $tim . '">' .
            '<div class="titlepin">' . $section->parametrs->param11 . '</div>' .
            '<input class="inp inppin" name="pin' . $idlink . '" maxlength="5" value="" autocomplete="off">' .
        '</div>' . 
    '</div>' .
//    $ech .= $anti_spam . '                
    '<input class="buttonSend goButton" name="GoTonewbbs" type="submit" value="' . $section->parametrs->param8 . '">' .
    '<input class="buttonSend delform" name="delform" onclick="$(\'.addcommmenttt\').remove();" type="button" value="' . $section->parametrs->param61 . '">' .
    '<input type=hidden name="iddopcomvv" value="' . $idlink . '">' . 
'</div>';
//*/
//    echo $ech;
//    exit();
}

?>