<div id='info'>
    [lang134]&nbsp;
    <b id='curdate'>{$curday}&nbsp;{$curmonth},&nbsp;{$curyear}&nbsp;[lang135]</b>,
    &nbsp;[lang136]&nbsp;<b id='curtime'>{$curtime}</b>,
    &nbsp;[lang137]&nbsp;<b id='curuser'>{$nick}</b>
</div>
<div id='menu'>              
    <a class='menuitem' href='[thispage.link]' id='forumname'>{$nameForum}</a>
    <if:{$uid}!=0>
        <a class='menuitem' href="[link.subpage=10]<SERV>?forums[]=all&result_type=topics&user=&text=&time={$lastVisit}&new</SERV>" id='newmessage'>[lang138]</a>
        <a class='menuitem' href='[link.subpage=5]' id='my'>[lang026]</a>
        <a class='menuitem' href='[link.subpage=7]' id='users'>[lang139]</a>
    </if>
    <a class='menuitem' href='[link.subpage=9]' id='search'>[lang009]</a>
</div>
<SE>
    <div class=sysedit>
        <div id='message_warning'>[lang001]</div>
        <div id='butlayer'>
            <input class='buttonSend' id='btBack' type='button' value='[lang126]'>
        </div>
    </div>
</SE>
