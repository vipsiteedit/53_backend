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
<h3 class='forumTitle' id='area_AreaName'>{$area}</h3>
<table class='tableForum' id='table_showAreas'>
<tbody class='tableBody'>
<tr>
<td colspan=2 class='title' id='title_ShowForumName'>
<div id='area_ShowForumName'>[lang068]</div>
</td>
<td class='title' id='title_ShowThemMount'>
<div id='area_ShowThemMount'>[lang140]</div>
</td>
<td class='title' id='title_ShowModerName'>
<div id='area_ShowModerName'>[lang148]</div>
</td>
</tr>
<repeat:forums name=forum>
<tr>
<td class='field' id='statustd'>
<div id="main_[forum.StatusID]">&nbsp;</div>
</td>
<td class='field' id='field_ShowForumName'>
<div id='area_ForumName'>
<a href="[link.subpage=2]<SERV>?id=[forum.id]</SERV>" id='area_LinkForum'>[forum.name]</a>
<div id='area_ShDescr'>[forum.description]</div>
</div>
</td>
<td class='field' id='field_ShowThemMount'>
<div id='area_ThemMount'>[forum.count]</div>
</td>
<td class='field' id='field_ShowModerName'>
<div id='area_ModerName'>
<a href="[link.subpage=7]<SERV>?id=[forum.uid]</SERV>" id='area_LinkModer'>[forum.nick]</a>
</div>
</td>
</tr>
</repeat:forums>
</tbody>
</table>
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
<!--01-->
