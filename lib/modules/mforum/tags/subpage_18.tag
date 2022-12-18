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
                    <input class='buttonSend' id='btBack' type='button' onclick='javascript:history.go(-1)' value="[lang126]">
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
                <table class='tableForum' id=tableUserMessage>
                    <tbody>
                        <repeat:somethings name=something>
                            <tr>
                                <td colspan=2 id='mess_MessTheme' class='title'>
                                    <div id='mess_ThemeName'>[something.topic]</div>
                                </td>
                            </tr>
                            <tr>
                                <td class='title' id='title_ShowUserMess'>
                                    <div id='mess_ShowUserMess'>
                                        <a name='t[something.i]'></a>
                                        <a id='mess_showTopicAuthorNick' href='[link.subpage=7]<SERV>?id=[something.id_users]</SERV>'>[something.user]</a>
                                        <if:[something.img]!=0>
                                            <a href='[link.subpage=7]<SERV>?id=[something.id_users]</SERV>'>
                                                <img border=0 id='mess_showTopicAuthorImg' src="<SERV>/modules/forum/images/</SERV>[something.img]">
                                            </a>
                                        </if>
                                        <div id='mess_showTopicAuthorStatus'>[something.status]</div>
                                        <div id='mess_showTopicAuthorLocation'>[something.location]</div>
                                    </div>
                                </td>
                                <td class='field' id='field_ShowUserMess'>
                                    <div id='mess_MessageText'>
                                        <div id='mess_showTopicMsgDate'>[something.date]</div>
                                        <div id='mess_GoToTheme'>[something.goTo]</div>
                                        <div id='mess_showTopicMsgText'>
                                            <span id='searchmsg'>[something.text]</span>
                                            <if:[something.time_edit]!=0>
                                                <br>
                                                <div id='edit'>
                                                    [lang097]&nbsp;[something.date_time_edit]
                                                </div> 
                                            </if>
                                            <if:[something.moderator_edit]!=0>
                                                <br>
                                                <div id='moder'>
                                                    [lang098]&nbsp;[something.date_time_moderator_edit]
                                                </div>
                                            </if>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </repeat:somethings>
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
                        </repeat:robots>)
                    </b>
                </if>
            </div>
        </if>
    </if>
    [subpage name=20]
</div>
<!--18-->
