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
            <if:{$alllist}!=0>
                <div id='users_Count'>
                    [lang045]&nbsp;
                    <span id='countUSR'>{$regusers}</span>
                </div>
                <if:{$ipages}!=0>
                    <div id='steplist'>|
                        <repeat:ipages name=ipage>
                            <if:[ipage.status]==1>
                                <b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
                            <else>
                                <a href="[link.subpage=7]<SERV>?part=[ipage.ipage]</SERV>" id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
                            </if>
                        </repeat:ipages>
                    </div>
                </if>
                <h3 class='forumTitle' id='users_Title'>[lang046]</h3>
                <table class='tableForum' id='table_showUsers'>
                    <tbody class='tableBody'>
                        <tr>
                            <td class='title' id='users_titleNick'>
                                <div id='users_Nick'>[lang047]</div>
                            </td>
                            <td class='title' id='users_titleRegDate'>
                                <div id='users_RegDate'>[lang048]</div>
                            </td>
                        </tr>
                        <repeat:users name=user>
                            <tr>
                                <td class='field' id='users_fieldUserName'>
                                    <div id='users_UserName'>
                                        <a id='users_linkUserName' href='[link.subpage=17]<SERV>?id=[user.id]</SERV>'>[user.nick]</a>
                                    </div>
                                </td>
                                <td class='field' id='users_fieldNumber'>
                                    <div id='users_Number'>[user.date]</div>
                                </td>
                            </tr>
                        </repeat:users>
                    </tbody>
                </table>                
                <div id='butlayer'>
                    <input class='buttonSend' id='AllUsersbtBack' type='button' onclick="<serv>javascript:history.go(-1)</serv><se>document.location.href='[thispage.link]'</se>" value='[lang126]'>
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
                        </repeat:robots>)
                    </b>
                </if>
            </div>
        </if>
    </if>
    [subpage name=20]
</div>
<!--07-->
