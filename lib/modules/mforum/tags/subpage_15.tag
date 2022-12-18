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
<if:{$thispage}!=0>
<if:{$_message_exists}!=0>
<div id='message_warning'>
{$_message}
</div>
<div id='butlayer'>
<input class='buttonSend' id='btBack' type='button' 
    onclick='document.location="[link.subpage=3]?id={$topic}";' value="[lang126]">
</div>
<else>
<form name='mailform' id='mailform' method='POST'>
<h3 class='forumTitle' id='mess_Title'>
[lang076]
</h3>
<table class='tableForum' id='table_PvtMesg'>
<tbody class='tableBody'>
<tr>
<td class='title' id='msg_titleFrom'>
<div id='msg_tForm'>
[lang077]
</div>
</td>
<td class='field' id='msg_fieldFrom'>
<div id='msg_fFrom'>
{$nick}
<input class='inputForum' id='msg_inpFrom' type='text' value='{$mailfrom}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='msg_titleTo'>
<div id='msg_tTo'>
[lang017]
</div>
</td>
<td class='field' id='msg_fieldTo'>
<div id='msg_fTo'>
{$userto}
</div>
</td>
</tr>       
<tr>
<td class='title' id='msg_titleTheme'>
<div id='msg_tTheme'>
[lang067]
</div>
</td>
<td class='field' id='msg_fieldTheme'>
<div id='msg_fTheme'>
<input class='inputForum' id='msg_inpTheme' type='text' value='{$subject}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='msg_titleMessage'>
<div id='msg_tMessage'>
[lang078]
</div>
</td>
<td class='field' id='msg_fieldMessage'>
<div id='msg_fMessage'>
<textarea class='areaForum' id='msg_arMessage' name='message'></textarea>
</div>
</td>
</tr>
<tr>
<td>
<div id='msg_ServiceButns'>
<input class='buttonSend' id='msg_btSend' name='doGo' type='submit' value=[lang079]>
<input class='buttonSend' id='msg_btClear' type='reset' value=[lang080]>
</div>
<input type='hidden' name='topicid' value='{$ext_topic}'>
<input type='hidden' name='userfrom' value='{$nick}'>
<input type='hidden' name='mailfrom' value='{$mailfrom}'>
<input type='hidden' name='idto' value='{$ext_id}'>
<input type='hidden' name='subject' value='{$subject}'>
</td>
</tr>
</tbody>
</table>
</form>
<script>
    document.all.mailform.msg_arMessage.focus();
</script>
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
<!--15-->
