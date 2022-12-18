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
            <if:{$ext_id_numeric}==0>
                <!-- -->
            </if>
            <h3 class='forumTitle' id='user_Title'>[lang095]</h3>
            <table class='tableForum' id='tablePvt'>
                <tbody class='tableBody'>
                    <form action='[link.subpage=5]' method='post'>
                        <tr>
                            <td class='title' id='pvt_titleNick'>
                                <div id='pvt_Nick'>[lang127]</div>
                            </td>
                            <td class='field' id='pvt_fieldNick'>
                                <div id='pvt_UserNick'>{$_nick}</div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleRealName'>
                                <div id='pvt_RealName'>[lang028]</div>
                            </td>
                            <td class='field' id='pvt_fieldRealName'>
                                <div id='pvt_UserName'>{$realname}&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleLocation'>
                                <div id='pvt_Location'>[lang029]</div>
                            </td>
                            <td class='field' id='pvt_fieldLocation'>
                                <div id='pvt_UserLocation'>{$location}&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                                <td class='title' id='pvt_titleStatus'>
                                    <div id='pvt_Status'>[lang030]</div>
                                </td>
                                <td class='field' id='pvt_fieldStatus'>
                                    <div id='pvt_UserStatus'>{$status}&nbsp;</div>
                                </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleMessages'>
                                <div id='pvt_Messages'>[lang031]</div>
                            </td>
                            <td class='field' id='pvt_fieldMessages'>
                                <div id='pvt_UserMess'>
                                    <a id='user_linkUserMess' href='[link.subpage=10]<SERV>?user={$ext_id}&forums[]=all&text=&result_type=messages&time=0</SERV>'>
                                        {$allmsg}
                                    </a>                                            
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleRegDate'>
                                <div id='pvt_RegDate'>[lang034]</div>
                            </td>
                            <td class='field' id='pvt_fieldRegDate'>
                                <div id='pvt_UserRgDt'>{$registered}&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleLastVisit'>
                                <div id='pvt_LastVisit'>[lang035]</div>
                            </td>
                            <td class='field' id='pvt_fieldLastVisit'>
                                <div id='pvt_UserLsVst'>{$last}&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleEmail'>
                                <div id='pvt_Email'>e-mail:</div>
                            </td>
                            <td class='field' id='pvt_fieldEmail'>
                                <div id='pvt_UserMail'>
                                    <a href='mailto:{$email}'>{$email}</a>&nbsp;
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleICQ'>
                                <div id='pvt_ICQ'>ICQ UIN:</div>
                            </td>
                            <td class='field' id='pvt_fieldICQ'>
                                <div id='pvt_UserICQ'>{$icq}&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleURL'>
                                <div id='pvt_URL'>URL:</div>
                            </td>
                            <td class='field' id='pvt_fieldURL'>
                                <div id='pvt_UserURL'>
                                    <a href="http://{$url}">{$url}</a>&nbsp;
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleJobTitle'>
                                <div id='pvt_JobTitle'>[lang036]</div>
                            </td>
                            <td class='field' id='pvt_fieldJobTitle'>
                                <div id='pvt_UserJobTitle'>{$jobtitle}&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleInterests'>
                                <div id='pvt_Interests'>[lang037]</div>
                            </td>
                            <td class='field' id='pvt_fieldInterests'>
                                <div id='pvt_UserInterests'>{$interests}&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleAvatar'>
                                <div id='pvt_Avatar'>[lang038]</div>
                            </td>
                            <td class='field' id='pvt_fieldAvatar'>
                                <div id='pvt_UserAvtr'> 
                                    <if:{$img_exists}!=0>
                                        <img id='user_AvtImg' src="<SE>../content/modules/mforum/avatar_forum.gif</SE><SERV>/modules/forum/images/{$img}</SERV>">&nbsp;
                                    <else>
                                        [lang128]
                                    </if>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class='title' id='pvt_titleDesript'>
                                <div id='pvt_Desript'>[lang040]</div>
                            </td>
                            <td class='field' id='pvt_fieldDesript'>
                                <div id='pvt_UserDscr'>{$origin}&nbsp;</div>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
            <div id='butlayer'>
                <if:{$uid}!=0>
                    <input type='button' class='buttonSend' id='createPersonal' onclick="document.location='[link.subpage=4]<serv>personal/{$ext_id}/</serv>';" value='[lang096]'>
                </if>
                <input class='buttonSend' id='btBack' type='button' onclick='javascript:history.go(-1)' value='[lang126]'>
            </div>
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
<!--17-->
