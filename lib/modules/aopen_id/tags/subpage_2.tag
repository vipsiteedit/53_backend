<div class="content openid sub2 row">
    <form action="" method='post'>
    <div class="error">{$er}[se."[param31]"]</div>
        <table class="tableTable table">
<serv>
        <repeat:dels name=del>
            <tr class="tableRow">
                <td class="links">
                    <a href="[thispage.link]?deletes_openid=[del.id]&{$time}">[param29]</a>
                </td> 
                <td class="image">
                <if:[del.photo]==''>
                    <img class="umg" src="[module_url]nofoto.gif">
                <else>
                    <img class="umg" src="[del.photo]">
                </if>   
                </td> 
                <td class="fio">
                    <span class="fio_text">[del.fio]</span>
                </td>
            </tr>
        </repeat:dels>
<serv>
<se>
        <tr class="tableRow">
            <td class="links">
                <a href="#">[param29]</a>
            </td>
            <td class="image">
                <img class="umg" src="[module_url]nofoto.gif">
            </td>
            <td class="fio">
                <span class="fio_text">Дон Кихот</span>
            </td>
        </tr>
        <tr class="tableRow">
            <td class="links">
                <a href="#">[param29]</a>
            </td>
            <td class="image">
                <img class="umg" src="[module_url]nofoto.gif">
            </td>
            <td class="fio">
                <span class="fio_text">Петя Сорокин</span>
            </td>
        </tr>
        <tr class="tableRow">
            <td class="links">
                <a href="#">[param29]</a>
            </td>
            <td class="image">
                <img class="umg" src="[module_url]nofoto.gif">
            </td>
            <td class="fio">
                <span class="fio_text">Саблезубый</span>
            </td>
        </tr>
</se>
    </table>
        <button type="button" class="btn btn-default delbut" onclick="document.location.href='[thispage.link]?{$time}';" >[param30]</button>
    </form>    
</div>
