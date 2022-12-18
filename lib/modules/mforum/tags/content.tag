<div class="content forum" [contentstyle][contedit]>
    [subpage name=19]
    <if:{$enable}==1>
        <div id="message_warning">[lang131]</div>
    <else>
        <if:{$enable}==2>
            <div id="message_warning">[lang132]&nbsp;{$haltView}&nbsp;[lang133]</div>
        <else>
            [subpage name=21]
            <!--Начало тела страницы-->
            <h3 class='forumTitle' id='forumtitle'>{$nameForum}</h3>
            <table class='tableForum' id='table_main' border=0>
                <tbody class='tableBody'>
                    <tr>
                        <td <if:[param98]!=2>colspan=2</if> class='title' id='title_MainForum'>
                            <div id='main_MainForum'>[lang068]</div>
                        </td>
                        <td class='title' id='title_MainTopic'>
                            <div id='main_MainTopic'>[lang140]</div>
                        </td>
                        <td class='title' id='title_MainUpdate'>
                            <div id='main_MainUpdate'>[lang072]</div>
                        </td>
                    </tr>
                    <repeat:forums name=forum>
                        <if:[forum.aid]!=0>
                            <tr>
                                <td colspan='4' id='field_Topic' class='field'>
                                    <div id='forumrazdel'>[forum.area]</div>
                                </td>
                            </tr>
                        </if>
                        <tr>
                            <if:[param98]!=2>
                                <td class='field' id='statustd'>
                                    <div id="main_[forum.StatusID]">&nbsp;</div>
                                </td>
                            </if>
                            <td class='field' id='field_MainForum'>
                                <div id='main_ForumName'>
                                    <a id='main_linkForum' href="[@subpage2]<SERV>?id=[forum.id]</SERV>">[forum.name]</a>
                                    <div id='main_ShDescr'>[forum.description]</div>
                                </div>
                            </td>
                            <td class='field' id='field_MainTopic'>
                                <div id='main_MessMount'>[forum.count]</div>
                            </td>
                            <td class='field' id='field_MainUpdate'>
                                <if:[forum.count]!=0>
                                    <div id='main_Update'>
                                        <a href='[@subpage3]<SERV>?id=[forum.topic_id]&new&last</SERV>' id='main_LinkTopic'>
                                            [forum.topic_name]
                                        </a>
                                        <div id='main_date'>
                                            [forum.topicDateNew]
                                            <div id='main_autUpdate'>
                                                [lang141]: 
                                                <a href='[@subpage7]<SERV>?id=[forum.topic_id_user_new]</SERV>' id='main_cellAuthorNickCr'>
                                                    [forum.topic_nick]
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <else>
                                    [lang142]
                                </if>
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
                        <a href='[@subpage7]<SERV>?id=[reguser.id]</SERV>' class='reguser'>[reguser.name]</a>[reguser.notend]
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
