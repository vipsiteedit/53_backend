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
<a class='menuitem' href='[link.subpage=1]<SERV>?id={$aid}</SERV>' id='forums'>{$forumArea}</a>
</div>
<div id='showForumModerator'>[lang148]:
<if:{$moderator_exists}!=0>
<a href='[link.subpage=7]<SERV>?id={$moduid}</SERV>' id='showForumModeratorNick'>{$moderator}</a>
<else>
[lang149]
</if>
<if:{$ismoderator}!=0>
<a id='showMdrLink' href='[link.subpage=16]<SERV>?id={$forumId}</SERV>'>[lang150]</a>
</if>
</div>
<div id='showForumTopics'>[lang140]:&nbsp;{$themes}</div>
<a href="[link.subpage=4]<SERV>?id={$forumId}&newt</SERV>" id='showForumNewTopic'>[lang151]</a>
<if:{$ipages}!=0>
<div id='steplist'>|
<repeat:ipages name=ipage>
<if:[ipage.status]==1>
<b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
<else>
<a href="[link.subpage=2]<SERV>?id={$ext_id}&part=[ipage.ipage]</SERV>" id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
</if>
</repeat:ipages>
</div>
</if>
<h3 class='forumTitle' id='titleForumName'>{$forumName}</h3>
<table class='tableForum' id='table_showForums'>
<tbody class='tableBody'>
<tr>
<td colspan=2 class='title' id='title_ShowForumTopic'>
<div id='show_ShowForumTopic'>[lang067]</div>
</td>
<td class='title' id='title_ShowForumMsgs'>
<div id='show_ShowForumMsgs'>[lang069]</div>
</td>
<td class='title' id='title_ShowForumViews'>
<div id='show_ShowForumViews'>[lang070]</div>
</td>
<td class='title' id='title_ShowForumCreate'>
<div id='show_ShowForumCreate'>[lang071]</div>
</td>
<td class='title' id='title_ShowForumRefresh'>
<div id='show_ShowForumRefresh'>[lang072]</div>
</td>
</tr>
<if:{$themes}==0>
<tr>
<td colspan=6 id='field_Error' class='field'>
<div id='show_Error'>[lang152]</div>
</td>
</tr>
<else>
<repeat:themes name=theme>
<tr>
<td class='field' id='statustd'>
<div id="main_[theme.StatusID]"></div>
</td>
<td class='field' id='field_ShowForumTopic'>
<div id='show_Theme'>
<a href="[link.subpage=3]<SERV>?id=[theme.id]</SERV>" id='show_LinkTopic'>
[theme.name]
</a>
<if:[theme.parts]!=0>
<div id=show_MsgNum>[lang153]:
<if:[theme.parts]==2>
<a id='show_NextNum' href="[link.subpage=3]<SERV>?id=[theme.id]&part=1</SERV>">1</a>, ... 
</if>
<repeat:parts[theme.id] name=ipart>
<a id='show_NextNum' href="[link.subpage=3]<SERV>?id=[theme.id]&part=[ipart.part]</SERV>">[ipart.part]</a>[ipart.next]
</repeat:parts[theme.id]>
</div>
</if>
</div>
</td>
<td class='field' id='field_ShowForumMsgs'>
<div id='show_ThemMount'>
[theme.count]
</div>
</td>
<td class='field' id='field_ShowForumViews'>
<div id='show_ThemShow'>
[theme.views]
</div>
</td>
<td class='field' id='field_ShowForumCreate'>
<div id='main_date'>
[theme.date],
<div id='main_autUpdate'>
[lang141]: 
<a href="[link.subpage=7]<SERV>?id=[theme.id_users]</SERV>" id='main_cellAuthorNickCr'>[theme.author]</a>
</div>
</div>
</td>
<td class='field' id='field_ShowForumRefresh'>
<div id='main_date'>
[theme.dateNew],
<div id='main_autUpdate'>
[lang141]: 
<a href="[link.subpage=7]<SERV>?id=[theme.id_usersNew]</SERV>" id='main_cellAuthorNickCr'>[theme.nick]</a>
</div>
</div>
</td>
</tr>
</repeat:themes>
</if>
</tbody>
</table>
<if:{$ipages}!=0>
<div id='steplist'>|
<repeat:ipages name=ipage>
<if:[ipage.status]==1>
<b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
<else>
<a href="[link.subpage=2]<SERV>?id={$ext_id}&part=[ipage.ipage]</SERV>" id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
</if>
</repeat:ipages>
</div>
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
<!--02-->
