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
            <if:{$user_p}==0>
                <if:{$puser_p}==0>
                    <div id="forumPath">
                        <a class='menuitem' href='[link.subpage=1]<SERV>?id={$aid}</SERV>' id='forums'>{$Area}</a>
                        <span class="divider">[param14]</span>
                        <a class='menuitem' href='[link.subpage=2]<SERV>?id={$fid}</SERV>' id='themes'>{$Forum}</a>
                    </div>
                </if>
            </if>
            <if:{$theme_exists}==0>
                <div id='message_warning'>[lang154]</div>
                <div id='butlayer'>
                    <input class='buttonSend' id='btBack' type='button' onclick='javascript:history.go(-1)' value='[lang126]'>
                </div>
            <else>
                <if:{$ipages}!=0>
                    <div id='steplist'>|
                        <repeat:ipages name=ipage>
                            <if:[ipage.status]==1>
                                <b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
                            <else>
                                <a href="[link.subpage=3]<SERV>?id={$ext_id}&part=[ipage.ipage]</SERV>" id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
                            </if>
                        </repeat:ipages>
                    </div>                  
                </if>
                <h3 class='forumTitle' id='titleTopic'>
                    <if:{$user_p}!=0>
                        [lang015]
                    <else>
                        <if:{$puser_p}!=0>
                            [lang016]
                        <else>
                            {$titleTopic}
                        </if>
                    </if>
                </h3>
                <if:{$all_msg}!=0>
                    <table id='tableTopic' class='tableForum' border=1>
                        <tbody class='tableBody'>
                            <repeat:messages name=message>
                                <tr>
                                    <td class='title' id='title_ShowTopicAuthor'>
                                        <div id='topic_ShowTopicAuthor'>
                                            <a name='t[message.cur]'></a>
                                            <a href='[link.subpage=7]<SERV>?id=[message.id_users]</SERV>' id='topic_showTopicAuthorNick'>[message.nick]</a>
                                            <if:[message.img_exists]!=0>
                                                <a href='[link.subpage=7]<SERV>?id=[message.id_users]</SERV>' title='[lang007]'>
                                                    <img id='topic_showTopicAuthorImg' src="<SERV>/modules/forum/images/</SERV>[message.img]" border=0>
                                                </a>
                                            </if>
                                            <div id='topic_showTopicAuthorStatus'>[message.status]</div>
                                            <div id='topic_showTopicLoc'>[message.location]</div>
                                            <a id='topic_lnkShowTopicMsg' href='[link.subpage=10]<SERV>?user=[message.id_users]&forums[]=all&text=&result_type=messages&time=0</SERV>'>
                                                [lang069]:&nbsp;[message.count_msg]
                                            </a>
                                            <if:[message.id_whom]!=0>
                                                <div class='whom'>
                                                    <span class='whom_txt'>[lang017]</span>&nbsp;
                                                    <a class='author_whom' href='[link.subpage=7]<SERV>?id=[message.id_whom]</SERV>'>[message.nick_whom]</a>
                                                </div>
                                            </if>
                                        </div>                                            
                                    </td>
                                    <td class='field' id='field_ShowTopicMsg'>
                                        <div id='topic_MessageText'>
                                            <div id='topic_showTopicMsgDate'>
                                                [message.date]
                                            </div>
                                            <div id='topic_showTopicMsgMenu'> 
                                                <if:{$new_msg}==0>
                                                    <a class='shTmenitem' href='[link.subpage=4]<SERV>?id={$ext_id}</SERV>' id='showTopicMsgMenuNew'>[lang186]</a>
                                                    <a class='shTmenitem' href='[link.subpage=4]<SERV>?quote=[message.id]&id={$ext_id}#edit</SERV>' id='showTopicMsgMenuReply'>[lang187]</a>
                                                </if> 
                                                <if:[message.edit]!=0>
                                                    &nbsp;
                                                    <a class='shTmenitem' href='[link.subpage=4]<SERV>[message.edit_p]?mid=[message.id]</SERV>' id='showTopicMsgMenuEdit'>[lang188]</a>
                                                </if>
                                                <if:[message.moderator]!=0>
                                                    &nbsp;
                                                    <a class='shTmenitem' href='[link.subpage=4]<SERV>?id={$ext_id}&mod=[message.id]</SERV>' id='showTopicMsgMenuModer'>[lang150]</a>
                                                </if>
                                                <if:[message.todel]!=0>
                                                    &nbsp;
                                                    <a class='shTmenitem' href='[link.subpage=8]<SERV>?id=[message.id]</SERV>' id='showTopicMsgMenuDel'>[lang039]</a>
                                                </if>
                                            </div>
                                            <div id='topic_showTopicMsgText'>
                                                [message.text]
                                            </div>
                                            <if:[message.msg_id]!=0>
                                                <div id="question">
                                                    <span class='AnswerString'>[lang018]</span>
                                                    <div id='qstninfo'>
                                                        <a id='puser' href='[link.subpage=7]<SERV>?id=[message.pid_users]</SERV>'>[message.pnick]</a>,
                                                        <span id='msgdate'>[message.pdate]</span> 
                                                    </div>
                                                    <span id='qstntext'>[message.ptext]</span>
                                                </div>
                                            </if>
                                            <if:[message.origin]!=''>
                                                <div class='origin'>
                                                    [message.origin]
                                                </div>
                                            </if>
                                            <div id='editblock'>
                                                <if:[message.date_time_edit_show]!=0>
                                                    <br>
                                                    <div id='edit'>
                                                        [lang097]&nbsp;[message.date_time_edit_date]
                                                    </div>
                                                </if>
                                                <if:[message.moderator_edit]=='Y'>
                                                    <br>
                                                    <div id='moder'>
                                                        [lang098]&nbsp;[message.moderator_edit_date]
                                                    </div>
                                                </if>
                                            </div>
                                            <div id='user_menu'>
                                                <if:[message.email_exists]!=0>
                                                    <a id='topic_Email' href="[link.subpage=15]<SERV>?id=[message.id_users]&topic={$ext_id}</SERV>">[lang155]</a>
                                                    &nbsp;
                                                </if>
                                                <if:[message.icq_exists]!=0>
                                                    <a id='topic_ICQ' href='http://wwp.icq.com/[message.icq]#pager' target=_blank>[lang156] 
                                                        <img border=0 src='{$iconssmiles}/icq_icon.gif' width=13 height=13>
                                                    </a>
                                                </if>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </repeat:messages>
                        </tbody>
                    </table>
                <else>
                    <div class=sysedit>
                        <div id='message_warning'>[lang019]</div>
                        <div id='butlayer'>
                            <input class='buttonSend' id='btBack' type='button' value='[lang126]' onclick='javascript:history.go(-1)'>
                        </div>
                    </div>
                </if>
                <if:{$ipages}!=0>
                    <div id='steplist'>|
                        <repeat:ipages name=ipage>
                            <if:[ipage.status]==1>
                                <b id='currentpart'>&nbsp;[ipage.ipage]&nbsp;</b>|
                            <else>
                                <a href="[link.subpage=3]<SERV>?id={$ext_id}&part=[ipage.ipage]</SERV>" id='otherpart'>&nbsp;[ipage.ipage]&nbsp;</a>|
                            </if>
                        </repeat:ipages>
                    </div>
                </if>
            </if>
<!--Конец тела страницы-->
            <div id=footinfo>[lang143]&nbsp;
                <span id="allusers">
                    <b>[lang144]:</b>&nbsp;{$all_users}
                </span>
                <span id="regusers">
                    <b>[lang145]:</b>&nbsp;{$reg_users}
                </span>
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
<!--03-->
