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
<div id="forumPath">
<a class='menuitem' href='[link.subpage=1]<SERV>?id={$aid}</SERV>' id='forums'>{$fArea}</a>
</div>
<if:{$thispage}!=0>
<if:{$message_exists}!=0>
<div id='message_warning'>{$_message}</div>
<else>
<div id='mdr_ThNum'>
[lang081]:&nbsp;
<span id='countTh'>{$allTopic}</span>
</div>
<if:{$ipages}!=0>
<div id='steplist'>|
<repeat:ipages name=ipage>
<if:[ipage.status]==1>
<b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
<else>
<a href='[link.subpage=16]<SERV>?id={$ext_id}&part=[ipage.ipage]</SERV>' id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
</if>
</repeat:ipages>
</div>
</if>
<form method='POST'>
<h3 class='forumTitle' id='mdr_Title'>[lang012] &quot;{$forumName}&quot;</h3>
<table class='tableForum' id='mdr_Table'>
<tbody class='tableBody'>
<tr>
<td class='title' id='mdr_titleCl'>&nbsp;</td>
<td class='title' id='mdr_titleTh'>
<div id='mdr_tTh'>
[lang067]
</div>
</td>
<td class='title' id='mdr_titleSt'>
<div id='mdr_tSt'>
[lang082]
</div>
</td>
<td class='title' id='mdr_titleVis'>
<div id='mdr_tVis'>
[lang083]
</div>
</td>
<td class='title' id='mdr_titleCrt'>
<div id='mdr_tCrt'>
[lang071]
</div>
</td>
<td class='title' id='mdr_titleUpd'>
<div id='mdr_tUpd'>
[lang072]
</div>
</td>
</tr>
<repeat:themes name=theme>
<tr>
<td class='field' id='mdr_fieldCl'>
<div id='mdr_fCl'>
<input type='checkbox' name='checked[]' value='[theme.id]' id='mdr_chbSel'>
</div>
</td>
<td class='field' id='mdr_fieldTh'>
<div id='mdr_fTh'>[theme.name]</div>
</td>
<td class='field' id='mdr_fieldSt'>
<if:[theme.enable]!=0>
<div id='mdr_fStOn'>[lang084]</div>
<SE>
<div id='mdr_fStOff'>[lang085]</div>
</SE>
<else>
<div id='mdr_fStOff'>[lang085]</div>
</if>
</td>
<td class='field' id='mdr_fieldVis'>
<if:[theme.visible]!=0>
<div id='mdr_fVisOn'>[lang086]</div>
<SE>
<div id='mdr_fVisOff'>[lang087]</div>
</SE>
<else>
<div id='mdr_fVisOff'>[lang087]</div>
</if>
</td>
<td class='field' id='mdr_fieldCrt'>
<div id='main_date'>[theme.date]</div>
</td>
<td class='field' id='mdr_fieldUpd'>
<div id='main_date'>[theme.dateNew]</div>
</td>
</tr>
</repeat:themes>
<tr>
<td colspan=6>
<div id='mdr_SrvBtns'>
<input type='submit' class='buttonSend' id='mdr_bOp' name='doOpen' value='[lang088]'>
<input type='submit' class='buttonSend' id='mdr_bCls' name='doClose' value='[lang089]'>
<input type='submit' class='buttonSend' id='mdr_bOn' name='doOn' value='[lang090]'>
<input type='submit' class='buttonSend' id='mdr_bOff' name='doOff' value='[lang091]'>
<input type='submit' class='buttonSend' id='mdr_bUp' name='doUp' value='[lang092]'>
<input type='submit' class='buttonSend' id='mdr_bDown' name='doDown' value='[lang093]'>
<input type='submit' class='buttonSend' id='mdr_bDel' name='doDel' value='[lang039]' 
    onclick='return confirmDel();'>
</div>
<script>
    function confirmDel() {
        var is_confirmed = confirm('[lang094]');
        return is_confirmed;
    }
</script>
</td>
</tr>
</tbody>
</table>
</form>
<if:{$ipages}!=0>
<div id='steplist'>|
<repeat:ipages name=ipage>
<if:[ipage.status]==1>
<b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
<else>
<a href='[link.subpage=16]<SERV>?id={$ext_id}&part=[ipage.ipage]</SERV>' id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
</if>
</repeat:ipages>
</div>
</if>
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
<!--16-->
