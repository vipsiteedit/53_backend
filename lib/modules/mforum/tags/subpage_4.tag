<header:js>
    [js:jquery/jquery.min.js]
</header:js>
<script type='text/javascript'>
    var part1='';
    var selprt;             
    var part2='';
    var sel=false;
    var colormenu=true;
    function getTextData () {
        var obj=document.getElementById("erm_AreaForText"); 
        if($.browser.msie){ 
            var range=document.selection.createRange();
            var stored_range=range.duplicate();
            stored_range.moveToElementText(obj);
            stored_range.setEndPoint('EndToEnd',range);
            obj.selectionStart=stored_range.text.length-range.text.length;
            obj.selectionEnd=obj.selectionStart+range.text.length;
        }
        selprt=obj.value.substring(obj.selectionStart,obj.selectionEnd);  
        part1=obj.value.substring(0,obj.selectionStart);
        part2=obj.value.substring(obj.selectionEnd,obj.value.length);
    }
    function www(typik){
        if(typik=="mail"){
            var mail=prompt("[lang117]","");
            if (mail) {
                if(sel){
                    part1=part1+'[mailto='+mail+']'+selprt+'[/mailto]';
                    $("#erm_AreaForText").val(part1+part2);
                }else{
                    part1=$("#erm_AreaForText").val()+'[mailto='+mail+']'+mail+'[/mailto]';
                    $("#erm_AreaForText").val(part1);
                }
            }
        }else if(typik=="img"){
            var url=prompt("[lang118]", "http://");
            if (url) {
                if(sel){
                    part1=part1+'[a href='+url+']'+selprt+'[/a]';
                    $("#erm_AreaForText").val(part1+part2);
                }else{
                    part1=$("#erm_AreaForText").val()+'[img src='+url+']';
                    $("#erm_AreaForText").val(part1);
                }
            }
        }else{
            var url=prompt("[lang119]","http://");
            if (url) {
                if(sel){
                    part1=part1+'[a href='+url+']'+selprt+'[/a]';
                    $("#erm_AreaForText").val(part1+part2);
                }else{
                    part1=$("#erm_AreaForText").val()+'[a href='+url+']'+url+'[/a]';
                    $("#erm_AreaForText").val(part1);
                }
            }
        }
        sel=false;
    }
    function editText(tag){
        var text='';
        if(sel){
            part1=part1+'['+tag+']'+selprt+'[/'+tag+']';
            $("#erm_AreaForText").val(part1+part2);
        } else {
            alert (what);
        }
        sel=false;
    }
    function AddSmile(smile){
        part1=part1+smile;
        $("#erm_AreaForText").val(part1+part2);
        sel=false;
    }
    function clr_add(color){
        if(sel){
            part1=part1+'[COLOR='+color+']'+selprt+'[/COLOR]';
            $("#erm_AreaForText").val(part1+part2);
        }else{
            $("#erm_AreaForText").val($("#erm_AreaForText").val()+'[COLOR='+color+']'+'[/COLOR]');    
        }
        $("#color_div").css("visibility","hidden");
        sel=false;
        colormenu=true;
        return false;
    }
    function clr_f(color){
        $("#clr").val(color);
        $("#clr_div").css("background-color",color);
    }
    function addFile(name, img) {
        if (img) {
            part1=part1+'[attimg src='+name+']';
        } else {
            part1=part1+'[attfile src='+name+']';
        }
        $("#erm_AreaForText").val(part1+part2);
        sel=false;
    }
    function delThisFile (name, id) {
        if (confirm ("[lang130]" + ' ' + name + '?')) {
            document.location = "?delfile=" + id;
        }
    }
    $(function(){ 
        $("#erm_AreaForText").bind("keypress", 
            function(){
                $("#txtCount").val({$msgMaxLength}-$("#erm_AreaForText").val().length);
                getTextData();
                sel=false;
            }
        );
        $("#erm_AreaForText").bind("focus blur mouseout change",
            function(){
                $("#txtCount").val({$msgMaxLength}-$("#erm_AreaForText").val().length);
            }
        );
        $("#erm_AreaForText").bind("select",
            function(){
                getTextData();
                sel=true; 
            }
        );  
        $("#erm_AreaForText").click(
            function(){
                if (!colormenu) {
                    $("#color_div").css("visibility","hidden");
                    colormenu=true;
                }
                getTextData();
            }
        );              
        $("#erm_Add").click(
            function(){
                if(!$("#erm_AreaForText").val().length){
                    alert('[lang120]');
                }else if($("#erm_AreaForText").val().length>{$msgMaxLength}){
                    alert('[lang121]');
                }else{
                    $("#doGo").val(1);
                    $("#form").submit();
                }
            }
        );
        $("#erm_PopUp").click(
            function(){
                if (colormenu) {
                    $("#color_div").css("visibility","visible");
                } else {
                    $("#color_div").css("visibility","hidden");
                }
                colormenu=!colormenu;
            }
        );
<se>        $("#erm_Clear").click(function(){
            if({$newt}!=0){
                document.location = "[link.subpage=2]?id={$personal}";
            } else {
                document.location = "[link.subpage=17]?id={$personal}";
            }
        });
</se>
    });
</script>
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
            <if:{$uid}==0>
                <div id='message_warning'>
                    <if:{$newt}==0>
                        [lang157]
                    <else>
                        [lang189]
                    </if>
                </div>
                <div id='butlayer'>
                    <input class='buttonSend' id='btBack' type='button' onclick="<serv>javascript:history.go(-1)</serv><se>document.location.href='[thispage.link]'</se>" value='[lang126]'>
                </div>
            <else>
                <if:{$error_exists}!=0>
                    <div id='message_warning'>
                        {$error}
                    </div>                                         
                    <div id='butlayer'>
                        <input class='buttonSend' id='btBack' type='button' onclick='javascript:history.go(-1)' value="[lang126]">
                    </div>
                <else>
                    <if:{$personal}==0>
                        <div id="forumPath">
                            <a class='menuitem' href='[link.subpage=1]<SERV>?id={$areaId}</SERV>' id='forums'>{$fArea}</a>
                            <span class="divider">[param14]</span>
                            <a class='menuitem' href='[link.subpage=2]<SERV>?id={$forumId}</SERV>' id='themes'>{$forumName}</a>
                            <if:{$newt}==0>
                                <span class="divider">[param14]</span>
                                <a class='menuitem' href='[link.subpage=3]<SERV>?id={$topicID}</SERV>' id='notheme'>{$topic}</a>
                            </if>
                        </div>
                    <else>
                        <div id='PersonalBlock'>
                            <span id='PersonalTitle'>
                                [lang020]&nbsp;[lang021]&nbsp;[lang022]&nbsp;
                                <a href='[link.subpage=17]<SERV>id/{$personal}/</SERV>' id='PersonNick'>{$to_whom}</a>
                            </span>
                        </div>
                    </if>
                    <if:{$ipart}==1>
                        <table class='tableForum' id='tableTopic'>
                            <tbody class='tableBody'>
                                <tr>
                                    <td colspan=2 id='mess_MessTheme' class='title'>
                                        <div id='mess_ThemeName'>{$qtopic}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='title' id='title_ShowUserMess'>
                                        <div id='mess_ShowUserMess'>
                                            <a id='mess_showTopicAuthorNick' href='[link.subpage=7]<SERV>?id={$q_id_users}</SERV>'>{$qnick}</a>
                                            <if:{$img_exists}!=0>
                                                <img id='mess_showTopicAuthorImg' src="<SE>[module_url]avatar_forum.gif</SE><SERV>/modules/forum/images/{$img}</SERV>" >
                                            </if>
                                            <div id='mess_showTopicAuthorStatus'>{$qstatus}</div>
                                            <div id='topic_showTopicLoc'>{$qlocation}</div>
                                        </div>
                                    </td>
                                    <td class='field' id='field_ShowUserMess'>
                                        <div id='mess_MessageText'>     
                                            <div id='mess_showTopicMsgDate'>{$qdate}</div> 
                                            <div id=mess_showTopicMsgText>{$qtext}</div>
                                            <if:{$date_time_edit_exists}!=0>
                                                <br>
                                                <div id='edit'>[lang097]&nbsp;{$date_time_edit}</div>
                                            </if>
                                            <if:{$moderator_edit_exists}!=0>
                                                <br>
                                                <div id='moder'>[lang098]&nbsp;{$moderator_edit}</div>
                                            </if>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <else>
                        <div id='mess_showTopicMsgText'></div>
                    </if>
                    <!--a name='edit'></a-->
                    <form method='post' id='form' name='form' enctype='multipart/form-data' action="<se>[thispage.link]</se>">
                        <if:{$createt}!=0>
                            <div id='erm_ThemeName'>
                                <span id='NewTheme'>[lang023]</span> 
                                <input class='inputForum' id='erm_ThemeText' type='text' maxlength='{$msgMaxLengthTopic}' name='topic_nm' value='{$topic}'>
                            </div>
                        </if>
                        <table class='tableForum' id="tableERM" border=0>
                            <tbody class='tableBody'>
                                <tr>
                                    <td id='erm_Buttons' colspan=2>
                                        <div id='erm_ClrManag'>
                                            <input class='inputForum' type='text' id='clr' readonly maxlength=7>
                                            <input class='buttonSend' id='erm_PopUp' type='button' value='[lang158]'>
                                            <div id="color_div" <SERV>style="visibility:hidden;"</SERV>>
                                                <table cellspacing=0 cellpadding=0 class=clr_tab onmouseout="clr_f('');">
                                                    <tbody>
                                                        <repeat:colors name=color>
                                                            <tr>
                                                                <repeat:color[color.i] name=colori>
                                                                    <td>
                                                                        <input type="button" onclick="clr_add('[colori.color]'); return false;" onmousemove="clr_f('[colori.color]');" style="background-color:[colori.color]; width:10px; height:10px; сursor: pointer; border: 0px;" value=''>
                                                                    </td>
                                                                </repeat:color[color.i]>
                                                            </tr>
                                                        </repeat:colors>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id='clr_div' style='background-color: ffffff;'></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id='erm_allButtons'>
                                            <button class='buttonsBlock' onclick="editText('b');" type='button'>
                                                <img src='{$iconssmiles}/b.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="editText('em');" type='button'>
                                                <img src='{$iconssmiles}/i.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="editText('u');" type='button'>
                                                <img src='{$iconssmiles}/u.gif'>
                                            </button>                   
                                            <button class='buttonsBlock' onclick="www('url');" type='button'>
                                                <img src='{$iconssmiles}/url.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="www('mail');" type='button'>
                                                <img src='{$iconssmiles}/mail.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="www('img');" type='button'>
                                                <img src='{$iconssmiles}/img.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="editText('ul');" type='button'>
                                                <img src='{$iconssmiles}/ul.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="editText('ol');" type='button'>
                                                <img src='{$iconssmiles}/ol.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="editText('center');" type='button'>
                                                <img src='{$iconssmiles}/center.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="editText('sup');" type='button'>
                                                <img src='{$iconssmiles}/sup.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="editText('sub');" type='button'>
                                                <img src='{$iconssmiles}/sub.gif'>
                                            </button>
                                            <button class='buttonsBlock' onclick="editText('code');" type='button'>
                                                <img src='{$iconssmiles}/code.gif'>
                                            </button>
                                        </div>
                                    </td>
                                    <td rowspan=2 id='erm_Smiles'>
                                        <div id='erm_allSmiles'>
                                            <repeat:smilelist name=smile>
                                                <div id='erm_SmilesBlock'>
                                                    <a href="javascript:AddSmile('[smile[smile.smile]]');">
                                                        <img border="0" src="{$iconssmiles}/smile[smile.smile].gif" alt='[smile[smile.smile]]' class='smileXXX'>
                                                    </a>
                                                </div>
                                            </repeat:smilelist>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td id='erm_TextArea'>
                                        <textarea class='inputForum' name='text' maxlength={$msgMaxLength} id='erm_AreaForText'>{$text}</textarea>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=2>
                                        <div id='ERM_maxlen'>
                                            [lang159]:&nbsp;{$msgMaxLength}&nbsp;[lang160].&nbsp;[lang161]: 
                                            <input type='text' id='txtCount' value='{$msgMaxLength}' readonly>
                                        </div>
                                    </td>
                                </tr>
                                <if:{$ext_topic}!=0>
                                    <input type='hidden' name='topic' value='{$ext_topic}'>
                                </if>
                                <if:{$mmid}!=0>
                                    <input type='hidden' name='mmid' value={$mmid}>
                                </if>
                                <if:{$newt}!=0>
                                    <input type='hidden' name='newt' value=1>
                                </if>
                                <if:{$forumId}!=0>
                                    <input type='hidden' name='forum' value={$forumId}>
                                </if>
                                <if:{$mod}!=0>
                                    <input type='hidden' name='mod' value=1>
                                </if>
                                <if:{$quote_id}!=0>
                                    <input type='hidden' name='qoute' value=1>
                                </if>
                                <input type='hidden' name='doGo' id='doGo' value=0>
                                <tr>
                                    <td colspan=2>
                                        <div id='erm_mkattach'>
                                            <span id="infoAttacheFiles">[lang162]</span>
                                            <input id='erm_flattach' type='file' name='userfile'>
                                            <input class='buttonSend' id='erm_btnAttach' name='upload' type='<serv>submit</serv><se>#</se>' value='[lang042]'>
                                            <div id='erm_attach'>
                                                <if:{$forum_attached_count}!=0>
                                                    [lang163]: (
                                                    <repeat:fatt name=ffatt>
                                                        <a class="fileLink" href="javascript:addFile('[ffatt.name2]', [ffatt.img]);">
                                                            [ffatt.name]
                                                        </a>&nbsp;
                                                        <a class="delFile" href="javascript:delThisFile('[ffatt.name]', '[ffatt.id]');">
                                                            [lang129]
                                                        </a>
                                                        &nbsp;([ffatt.size]&nbsp;[lang122])[ffatt.next]
                                                    </repeat:fatt>
                                                    ).&nbsp;    
                                                    [lang164]: {$forum_attached_count}, [lang165]: {$forum_attached_size} [lang122]
                                                    &nbsp;[lang166]: {$maxFilesAttached}, [lang165]:&nbsp;
                                                    {$forum_attached_max}&nbsp;[lang122]
                                                <else>
                                                    [lang167]
                                                </if>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <if:{$newt}!=0>
                                    <tr>
                                        <td colspan=2>
                                            <div id='erm_NewMess'>
                                                [lang024]&nbsp;
                                                <input class='inputForum' id='erm_inpNewMess' type='text' maxlength='50' name='email'>
                                            </div>
                                        </td>
                                    </tr>
                                </if>
                                <tr>
                                    <td colspan=2>
                                        <div id='erm_ServicesButtons'>
                                            <if:{$save_button}!=0>
                                                <input class='buttonSend' id='erm_Add' type='button' value='[lang043]'>
                                            <else>
                                                <input class='buttonSend' id='erm_Add' type='button' value='[lang168]'> 
                                            </if>
                                            <input class='buttonSend' id='erm_Clear' type='button' value='[lang080]' onclick="<serv>javascript:history.go(-1)</serv><se>document.location.href='[thispage.link]'</se>">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
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
<!--04-->
