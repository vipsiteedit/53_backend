<?php
 if (empty($section->parametrs->param2)) $section->parametrs->param2 = "30";
 if (empty($section->parametrs->param1)) $section->parametrs->param1 = "{$__data->prj->vars->adminmail}";
 if (empty($section->parametrs->param3)) $section->parametrs->param3 = "";
 if (empty($section->parametrs->param15)) $section->parametrs->param15 = "Yes";
 if (empty($section->parametrs->param28)) $section->parametrs->param28 = "30";
 if (empty($section->parametrs->param33)) $section->parametrs->param33 = "[namepage]";
 if (empty($section->parametrs->param36)) $section->parametrs->param36 = "Гость";
 if (empty($section->parametrs->param37)) $section->parametrs->param37 = "Уважаемый, Админ! \\r\\n На сайте [SITENAME] в статье [NAMETITLE] был добавлен комментарий";
 if (empty($section->parametrs->param38)) $section->parametrs->param38 = "В вашей статье [NAMETITLE], написанной на сайте [SITENAME] был добавлен комментарий";
 if (empty($section->parametrs->param39)) $section->parametrs->param39 = "Yes";
 if (empty($section->parametrs->param40)) $section->parametrs->param40 = "No";
 if (empty($section->parametrs->param42)) $section->parametrs->param42 = "Yes";
 if (empty($section->parametrs->param45)) $section->parametrs->param45 = "No";
 if (empty($section->parametrs->param44)) $section->parametrs->param44 = "";
   foreach($section->parametrs as $__paramitem){
    foreach($__paramitem as $__name=>$__value){
      if (empty($__value)){
      }
      if (preg_match("/\[%([\w\d\-]+)%\]/u", $__value, $m)!=false){
        $section->parametrs->$__name = $__data->prj->vars->$m[1];
      }
     }
   }
?>