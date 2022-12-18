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
<if:{$find}==0>
<div id=message_warning>
[lang066]
</div>
<div id='butlayer'>
<input class='buttonSend' id='btBack' type='button' onclick='javascript:history.go(-1)' 
    value="[lang126]">
</div>
<else>
<if:{$ipages}!=0>
<div id='steplist'>|
<repeat:ipages name=ipage>
<if:[ipage.status]==1>
<b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
<else>
<a href="{$query}&part=[ipage.ipage]" id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
</if>
</repeat:ipages>
</div>
</if>
<table class='tableForum' id='found_tableFound'>
<tbody class='tableBody'>
<tr>
<td class='title' id='found_titleTheme'>
<div id='found_Theme'>[lang067]</div>
</td>
<td class='title' id='found_titleForum'>
<div id='found_Forum'>[lang068]</div>
</td>
<td class='title' id='found_titleMessages'>
<div id='found_Messages'>[lang069]</div>
</td>
<td class='title' id='found_titleShowed'>
<div id='found_Showed'>[lang070]</div>
</td>
<td class='title' id='found_titleCreated'>
<div id='found_Created'>[lang071]</div>
</td>
<td class='title' id='found_titleRefreshed'>
<div id='found_Refreshed'>[lang072]</div>
</td>
</tr>
<repeat:frms name=frm>
<tr>
<td class='field' id='found_fieldTheme'>
<div id='found_nameTheme'>
<a id='found_linkTheme' href='[link.subpage=3]<SERV>?id=[frm.id_topic]</SERV>'>[frm.name]</a>
</div>
</td>
<td class='field' id='found_fieldForum'>
<div id='found_nameForum'>
<a id='found_linkForum' href='[link.subpage=2]<SERV>?id=[frm.id_forums]</SERV>'>[frm.forumname]</a>
</div>
</td>
<td class='field' id='found_fieldMessages'>
<div id='found_MessagesMount'>[frm.count]</div>
</td>
<td class='field' id='found_fieldShowed'>
<div id='found_ShowedMount'>[frm.views]</div>
</td>
<td class='field' id='found_fieldCreated'>
<div id='main_date'>
<span class=DataUpdate>[frm.date]</span>,
<div id=main_autUpdate>
[lang125]
<a class='main_cellAuthorNickCr' href='[link.subpage=7]<SERV>?id=[frm.id_users]</SERV>'>[frm.author]</a>
</div>
</div>
</td>
<td class='field' id='found_fieldRefreshed'>
<div id='main_date'>
<span class=DataUpdate>[frm.dateNew]</span>,
<div id='main_autUpdate'>
[lang125] 
<a class='main_cellAuthorNickCr' href='[link.subpage=7]<SERV>?id=[frm.id_usersNew]</SERV>'>[frm.nick]</a>
</div>
</div>
</td>
</tr>
</repeat:frms>
</tbody>
</table>
<if:{$ipages}!=0>
<div id='steplist'>|
<repeat:ipages name=ipage>
<if:[ipage.status]==1>
<b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
<else>
<a href="{$query}&part=[ipage.ipage]" id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
</if>
</repeat:ipages>
</div>
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
<!--10-->
