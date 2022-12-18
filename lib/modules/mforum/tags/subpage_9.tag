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
<form method='get' action='[link.subpage=10]'>
<h3 class='forumTitle' id='srch_Title'>[lang009]</h3>
<table class='tableForum' id='tableSrch'>
<tbody class='tableBody'>
<tr>
<td class='title' id='srch_titleWords'>
<div id='srch_Words'>[lang049]</div>
</td>
<td class='field' id='srch_fieldWords'>
<div id='srch_FPh'>
<input id='srch_inpWords' type='text' class='inputForum' name='text' value='{$what}'>
</div>
</td>
</tr>
<tr>
<td class='title' id='srch_titleInMess'>
<div id='srch_InMess'>[lang050]</div>
</td>
<td class='field' id='srch_fieldInMess'>
<div id='srch_Mess'>
<!--input id='srch_inpInMess' name='user' value=''-->
<select id='srch_inpInMess' name='user'>
<option value=0>--[lang051]--</option>
<repeat:users name=user>
<option value=[user.id]>[user.nick]</option>
</repeat:users>
</select>
</div>
</td>
</tr>
<tr>
<td class='title' id='srch_titleWhere'>
<div id='srch_Where'>[lang052]</div>
</td>
<td class='field' id='srch_fieldWhere'>
<div id='srch_FPlc'>
<select id='srch_slcWhere' name='forums[]' size='6' multiple='multiple'>
<option value='all' selected='selected'>&raquo; [lang053]</option>
<repeat:forum_sel name=fsel>
<option value=[fsel.id]>[fsel.name]</option>
</repeat:forum_sel>
</select>
</div>
</td>
</tr>
<tr>
<td class='title' id='srch_titleInterv'>
<div id='srch_Interv'>[lang054]</div>
</td>
<td class='field' id='srch_fieldInterv'>
<div id='srch_SrcTim'>
<select id=srch_slcInterv name='time'>
<option value='{$time1}'>[lang055]</option>
<option value='{$time7}'>[lang056]</option>
<option value='{$time30}'>[lang057]</option>
<option value='{$time60}'>[lang058]</option>
<option value='{$time90}'>[lang059]</option>
<option value='{$time180}'>[lang060]</option>
<option value='{$time365}'>[lang061]</option>
<option value='0' selected='selected'>[lang062]</option>
</select>
</div>
</td>
</tr>
<tr>
<td class='title' id='srch_titleResAs'>
<div id='srch_ResAs'>[lang063]</div>
</td>
<td class='field' id='srch_fieldResAs'>
<div id='srch_Reslt'>
<input id='srch_rdResAs' type='radio' name='result_type' value='topics' checked='checked'>
<label id='srch_lbRS' for='result_topics'>[lang064]</label>
<br>
<input id='srch_rdResAs' type='radio' name='result_type' value='messages'>
<label id='srch_lbRS' for='result_msg'>[lang065]</label>
</div>
</td>
</tr>
<tr>
<td colspan=2 align='center'>
<input class='buttonSend' id='srch_btnStart' type='submit' name='doGo' value='[lang124]'>
</td>
</tr>
</tbody>
</table>
</form>
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
<!--09-->
