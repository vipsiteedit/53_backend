<div class="content forum">
[subpage name=19]
<if:{$enable}==1>
<div id="message_warning">[lang131]</div>
<else>
<if:{$enable}==2>
<div id="message_warning">[lang132]&nbsp;{$haltView}&nbsp;[lang133]</div>
<else>
[subpage name=21]
<!--Начало тела страницы-->
<if:{$uid}==0>
<div id=message_warning>[lang025]</div>
<else>
<if:{$error_exists}!=0>
<div id='message_warning'>
{$error}
</div>
<div id='butlayer'>
<input class='buttonSend' id='btBack' type='button' onclick='javascript:history.go(-1)' 
    value='[lang126]'>
</div>
<else>
<!-- ------------------------- -->
<h3 class=forumTitle id='Mypvt_Title'>[lang026]</h3>
<table class='tableForum' id='tablePvt'>
<tbody class='tableBody'>
<form method='post' action="?sid={$sid}" enctype='multipart/form-data'>
<tr>
<td class='title' id='pvt_titleNick'>
<div id='pvt_Nick'>[lang027]</div>
</td>
<td class='field' id='pvt_fieldNick'>
<div id='pvt_UserNick'>
<input type='text' class='inputForum' id='pvt_inpNick' name='nick' value='{$nick}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleRealName'>
<div id='pvt_RealName'>[lang028]</div>
</td>
<td class='field' id='pvt_fieldRealName'>
<div id='pvt_UserName'>
<input type='text' class='inputForum' id='pvt_inpName' name='realname' value='{$realname}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleLocation'>
<div id='pvt_Location'>[lang029]</div>
</td>
<td class='field' id='pvt_fieldLocation'>
<div id='pvt_UserLocation'>
<input type='text' class='inputForum' id='pvt_inpLocation' name='location' value='{$location}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleStatus'>
<div id='pvt_Status'>[lang030]</div>
</td>
<td class='field' id='pvt_fieldStatus'>
<div id='pvt_UserStatus'>{$status}</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleMessages'>
<div id='pvt_Messages'>[lang031]</div>
</td>
<td class='field' id='pvt_fieldMessages'>
<div id='pvt_UserMess'>
<a id='pvt_linkUserMess' 
    href="[link.subpage=10]<SERV>?user={$uid}&forums[]=all&text=&result_type=messages&time=0</SERV>">
{$msg_count}
</a>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titlePersonalMessages'>
<div id='pvt_PersonalMessages'>[lang032]</div>
</td>
<td class='field' id='pvt_fieldPersonalMessages'>
<div id='pvt_UserPersonalMess'>
<a id='pvt_linkUserPersonalMess' 
    href="[link.subpage=3]<SERV>?user={$uid}</SERV>">
{$msg_personalcount}
</a>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titlePutPersMessages'>
<div id='pvt_PutPersMessages'>[lang033]</div>
</td>
<td class='field' id='pvt_fieldPutPersMessages'>
<div id='pvt_UserPutPersMess'>
<a id='pvt_linkUserPutPersMess' 
    href="[link.subpage=3]<SERV>?puser={$uid}</SERV>">
{$msg_putpcount}
</a>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleRegDate'>
<div id='pvt_RegDate'>[lang034]</div>
</td>
<td class='field' id='pvt_fieldRegDate'>
<div id='pvt_UserRgDt'>{$registered}</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleLastVisit'>
<div id='pvt_LastVisit'>[lang035]</div>
</td>
<td class='field' id='pvt_fieldLastVisit'>
<div id='pvt_UserLsVst'>{$last}</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleEmail'>
<div id='pvt_Email'>e-mail:</div>
</td>
<td class='field' id='pvt_fieldEmail'>
<div id='pvt_UserMail'>
<input type='text' class='inputForum' id='pvt_inpMail' name='email' value='{$email}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleICQ'>
<div id=pvt_ICQ>ICQ UIN:</div>
</td>
<td class='field' id='pvt_fieldICQ'>
<div id='pvt_UserICQ'>
<input type='text' class='inputForum' id='pvt_inpICQ' name='icq' value='{$icq}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleURL'>
<div id='pvt_URL'>URL:</div>
</td>
<td class='field' id='pvt_fieldURL'>
<div id='pvt_UserURL'>
<input type='text' class='inputForum' id='pvt_inpURL' name='url' value='{$url}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleJobTitle'>
<div id='pvt_JobTitle'>[lang036]</div>
</td>
<td class='field' id='pvt_fieldJobTitle'>
<div id='pvt_UserJobTitle'>
<input type='text' class='inputForum' id='pvt_inpJobTitle' name='jobtitle' value='{$jobtitle}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleInterests'>
<div id='pvt_Interests'>[lang037]</div>
</td>
<td class='field' id='pvt_fieldInterests'>
<div id='pvt_UserInterests'>
<input type='text' class='inputForum' id='pvt_inpInterests' name='interests' value='{$interests}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleAvatar'>
<div id='pvt_Avatar'>[lang038]</div>
</td>
<td class='field' id='pvt_fieldAvatar'>
<if:{$img_exists}!=0>
<div id='pvt_UserAvtr'>
<img id='pvt_AvtImg' src="<SE>../content/modules/mforum/avatar_forum.gif</SE><SERV>/modules/forum/images/{$img}</SERV>">
<div id='pvt_AvtDown'>
[lang123]&nbsp;{$imgsz0}x{$imgsz1}px<br>
<a href='[link.subpage=6]<SERV>?delete&sid={$sid}</SERV>' id='pvt_linkDel'>[lang039]</a>
</div>
</div>
<else>
-
</if>
</td>
</tr>
<tr>
<td class='title' id='pvt_titleDesript'>
<div id='pvt_Desript'>[lang040]</div>
</td>
<td class='field' id='pvt_fieldDesript'> 
<div id='pvt_UserDscr'>
<textarea class='areaForum' id='pvt_AreaDscr' name='origin'>{$origin}</textarea>
</div>
</td>
</tr>
<tr>
<td colspan=2>
<div id='pvt_LoadAvatar'>
<span id='loadimginfo'>[lang041]</span>
<input id='pvt_inpLoad' type='file' name='userfile'>
<input class='buttonSend' id='pvt_btnload' type='submit' name='upload' value='[lang042]'>
</div>
</td>
</tr>
<tr>
<td colspan=2>
<div id='pvt_ServicesButtons'>
<input class='buttonSend' id='pvt_btnSave' type='submit' name='doGo' value='[lang043]'>
<input class='buttonSend' id='pvt_btnUndo' type='reset' value='[lang044]'>
<input class='buttonSend' id='btBack' type='button' onclick='javascript:history.go(-1)' 
    value='[lang126]'>
</div>
</td>
</tr>
</form>
</tbody>
</table>
<!-- ------------------------- -->
</if>
</if>
<!--Конец тела страницы-->
<div id=footinfo>[lang143]&nbsp;
<span id="allusers"><b>[lang144]:</b>&nbsp;{$all_users}</span>
<span id="regusers"><b>[lang145]:</b>&nbsp;{$reg_users}</span>
<if:{$reg_users}!=0>
(<repeat:regusers name=reguser>
<a href='[link.subpage=7]<SERV>?id=[reguser.id]</SERV>' class='reguser'>[reguser.name]</a>[reguser.notend]
</repeat:regusers>)
</if>
<span id="guestusers"><b>[lang146]:</b>&nbsp;{$guest}</span>
<if:{$allrobots}!=0>
<b id='main_Robots'>[lang147]:&nbsp;{$allrobots}&nbsp;
(<repeat:robots name=robot>
[robot.name][robot.notend]
</repeat:robots>)</b>
</if>
</div>
</if>
</if>
[subpage name=20]
</div>
<!--05-->
