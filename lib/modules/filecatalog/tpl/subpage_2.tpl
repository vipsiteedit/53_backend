<?php if($ACCESS_ON): ?>
    
        <header:js>
            [js:jquery/jquery.min.js]
        </header:js>
        <script type="text/javascript" src="[module_url]jquery.rating.js"></script>
        <script type="text/javascript" src="[module_url]jquery.MetaData.js"></script>
        <script type="text/javascript" src="[module_url]documentation.js"></script>
    
<!-- 1)скрипт для загрузки jquery- оставил на всяки случай уже не испльзуется
2) скрипт добавление полей ввода ссылок
3) скрипт добавления полей ввода скриншотов 
-->
    <script type="text/javascript">
        function loadBox(id, name, kol) {
            $('#' + id).load("/<?php echo $_page ?>/<?php echo $razdel ?>/sub4/?" + name + "&kol=" + kol, {});
        }
        var items=<?php echo $kollinks ?>;
        function AddItem() {
            div = document.getElementById("items");
            button = document.getElementById("add");
            textik = (document.getElementsByName('adrlink' + items)[0].value);
            if (textik != "") { 
                items++;
                newitem = "<div class=\"inslink\">";
                newitem += "<?php echo $section->parametrs->param49 ?> " + (items + 1) + "</div>";
                newitem += "<div>";
                newitem += "<div class=\"namelinktitle\"> <?php echo $section->parametrs->param46 ?></div>";
                newitem += " <input class=\"namelink\" name=\"namelink"+ items;
                newitem += "\" value=\"\"> </div> <div> <div class=\"adrlinktitle\"> <?php echo $section->parametrs->param45 ?></div><input class=\"adrlink\"  name=\"adrlink"+ items;  
                newitem += "\" value=\"\"> </div>";
                newnode = document.createElement("span");
                newnode.innerHTML = newitem;
                div.insertBefore(newnode, button);
            } 
        }     
        var itemsimg = <?php echo $kolskrins ?>;
        function AddSkrin() {
            div = document.getElementById("itemsimg");
            button = document.getElementById("addd");
            itemsimg++;
            newimg = "<div id=\"imginsert\">";
            newimg += "<div class=\"obj userimg\">";
            newimg += "<label class=\"titleimg title \" for=\"userfile\"><?php echo $section->parametrs->param39 ?> "+itemsimg+"</label>";
            newimg += " <div class=\"fieldimg\"><input  class=\"inputs\"  id=\"userfile\" type=\"file\" name=\"userfile[]\"></div>"; 
            newimg += " </div>  </div>"; 
            newnode = document.createElement("span");
            newnode.innerHTML = newimg;
            div.insertBefore(newnode, button);
        } 
    </script>
    <div class="content contRedFCtlg edit">
        <h3 class="contentTitle"><?php echo $section->parametrs->param17 ?></h3>
        <div class="errortext"><?php echo $errortext ?></div>
        <form style="margin:0px;" action="" method="post" enctype="multipart/form-data"> 
            <div class="form">
                <div class="obj userfile">
                    <div class="imgred"><?php echo $picture ?></div>
                    <label class="title" for="userfile"><?php echo $section->parametrs->param24 ?></label> 
                    <div class="field">
                        <input class="inputs" id="userfile" type="file" name="userfile[]">
                    </div>
                    <div class="imgdel">
                        <input  class="inputs" type="checkbox" name="delimg" value="true" id="delimg">
                        <label class="titleimg" for="del"><?php echo $section->parametrs->param44 ?></label>
                    </div>
                </div> 
                <div class="obj name">
                    <label class="title" for="name"><?php echo $section->parametrs->param18 ?></label>
                    <div class="field">
                        <input class="inputs"  id="name" name="name" value="<?php echo $name ?>">
                    </div> 
                </div>
                <div class="obj short">
                    <label class="title" for="short"><?php echo $section->parametrs->param22 ?></label>
                    <div class="field">
                        <input class="inputs"  id="short" name="short" value="<?php echo $short ?>" maxlength="<?php echo $section->parametrs->param2 ?>">
                    </div>
                </div>
                <?php if($section->parametrs->param73=="on"): ?>
                    <div class="obj pole1">
                        <label class="title" for="name"><?php echo $section->parametrs->param72 ?></label>
                        <div class="field">
                            <input class="inputs" id="pole1" name="pole1" value="<?php echo $pole1txt ?>" maxlength="<?php echo $section->parametrs->param92 ?>">
                        </div> 
                    </div>
                <?php endif; ?>
                <?php if($section->parametrs->param75=="on"): ?>
                    <div class="obj pole2">
                        <label class="title" for="name"><?php echo $section->parametrs->param74 ?></label>
                        <div class="field">
                            <input class="inputs" id="pole2" name="pole2" value="<?php echo $pole2txt ?>" maxlength="<?php echo $section->parametrs->param93 ?>">
                        </div> 
                    </div>
                <?php endif; ?>  
                <?php if($section->parametrs->param77=="on"): ?>
                <div class="obj pole3">
                    <label class="title" for="name"><?php echo $section->parametrs->param76 ?></label>
                    <div class="field">
                        <input class="inputs" id="pole3" name="pole3" value="<?php echo $pole3txt ?>" maxlength="<?php echo $section->parametrs->param94 ?>">
                    </div> 
                </div>
                <?php endif; ?>
                <?php if($section->parametrs->param79=="on"): ?>
                    <div class="obj pole4">
                        <label class="title" for="name"><?php echo $section->parametrs->param78 ?></label>
                        <div class="field">
                            <input class="inputs" id="pole4" name="pole4" value="<?php echo $pole4txt ?>" maxlength="<?php echo $section->parametrs->param95 ?>">
                        </div> 
                    </div>
                <?php endif; ?>
                <?php if($section->parametrs->param81=="on"): ?>
                        <div class="obj pole5">
                            <label class="title" for="name"><?php echo $section->parametrs->param80 ?></label>
                            <div class="field">
                                <input class="inputs" id="pole5" name="pole5" value="<?php echo $pole5txt ?>" maxlength="<?php echo $section->parametrs->param96 ?>">
                            </div> 
                        </div>
                <?php endif; ?>  
                <?php if($section->parametrs->param83=="on"): ?>
                    <div class="obj pole6">
                        <label class="title" for="name"><?php echo $section->parametrs->param82 ?></label>
                        <div class="field">
                            <input class="inputs" id="pole6" name="pole6" value="<?php echo $pole6txt ?>" maxlength="<?php echo $section->parametrs->param97 ?>">
                        </div> 
                    </div>
                <?php endif; ?>
                <?php if($section->parametrs->param85=="on"): ?>
                    <div class="obj pole7">
                        <label class="title" for="name"><?php echo $section->parametrs->param84 ?></label>
                        <div class="field">
                            <input class="inputs" id="pole7" name="pole7" value="<?php echo $pole7txt ?>" maxlength="<?php echo $section->parametrs->param98 ?>">
                        </div> 
                    </div>
                <?php endif; ?>
                <?php if($section->parametrs->param87=="on"): ?>
                    <div class="obj pole8">
                        <label class="title" for="name"><?php echo $section->parametrs->param86 ?></label>
                        <div class="field">
                            <input class="inputs" id="pole8" name="pole8" value="<?php echo $pole8txt ?>" maxlength="<?php echo $section->parametrs->param99 ?>">
                        </div> 
                    </div>
                <?php endif; ?>  
                <?php if($section->parametrs->param89=="on"): ?>
                    <div class="obj pole9">
                        <label class="title" for="name"><?php echo $section->parametrs->param88 ?></label>
                        <div class="field">
                            <input class="inputs" id="pole9" name="pole9" value="<?php echo $pole9txt ?>" maxlength="<?php echo $section->parametrs->param100 ?>">
                        </div> 
                    </div>
                <?php endif; ?>
                <?php if($section->parametrs->param91=="on"): ?>
                    <div class="obj pole10">
                        <label class="title" for="name"><?php echo $section->parametrs->param90 ?></label>
                        <div class="field">
                            <input class="inputs" id="pole10" name="pole10" value="<?php echo $pole10txt ?>" maxlength="<?php echo $section->parametrs->param101 ?>">
                        </div> 
                    </div>
                <?php endif; ?>
                <div class="obj text"> 
                    <label class="title" for="text"><?php echo $section->parametrs->param23 ?></label>
                    <div class="field">
                        <textarea class="inputs"  id="text" name="text" rows="10" cols="40"><?php echo $text ?></textarea>
                    </div>
                </div>
                <div id="groupLinks">
                    <div id="nameinsert">
                        <div class="obj linksins" ID="items">
                            
                            <?php echo $links ?> 
                            <input class="inslinksbtn" type="button" value="<?php echo $section->parametrs->param51 ?>" onClick="AddItem();" ID="add">
                        </div>
                    </div>
                </div>
                <div class="obj skrinvivod"> 
                     
                    <?php echo $skrinvivod ?>   
                </div>        
                <div class="skrinshoti">
                    <div id="itemsimg"> 
                        
                        <input class="insskrinbtn" type="button" value="<?php echo $section->parametrs->param50 ?>" onClick="AddSkrin();" ID="addd">
                    </div> 
                </div> 
                <div class="obj del">
                    <div class="field">
                        <input class="inputs" type="checkbox" name="del" value="true" id="del">
                    </div>
                    <label class="title" for="del"><?php echo $section->parametrs->param25 ?></label>
                </div>
            </div>
            <div class="groupButton">
                <input class="buttonSend goButton" name="GoToFilecatalog" type="submit" value="<?php echo $section->parametrs->param27 ?>">
                <input class="buttonSend backButton" onclick="document.location = '<?php echo seMultiDir()."/".$_page."/" ?>'" type="button" value="<?php echo $section->parametrs->param10 ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="img" value="<?php echo $_img ?>">
        </form>
    </div>
<?php else: ?>
    <?php echo $section->language->lang007 ?>
<?php endif; ?>
