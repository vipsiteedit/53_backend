<?php
 if (!isset($section->parametrs->param2)) $section->parametrs->param2 = "true";
 if (!isset($section->parametrs->param3)) $section->parametrs->param3 = "3";
 if (!isset($section->parametrs->param4)) $section->parametrs->param4 = "1";
 if (!isset($section->parametrs->param5)) $section->parametrs->param5 = "300";
 if (!isset($section->parametrs->param12)) $section->parametrs->param12 = "false";
 if (!isset($section->parametrs->param13)) $section->parametrs->param13 = "3000";
 if (!isset($section->parametrs->param9)) $section->parametrs->param9 = "false";
 if (!isset($section->parametrs->param6)) $section->parametrs->param6 = "false";
 if (!isset($section->parametrs->param11)) $section->parametrs->param11 = "0px";
 if (!isset($section->parametrs->param10)) $section->parametrs->param10 = "true";
 if (!isset($section->parametrs->param7)) $section->parametrs->param7 = "true";
 if (!isset($section->parametrs->param8)) $section->parametrs->param8 = "true";
 if (!isset($section->parametrs->param14)) $section->parametrs->param14 = "false";
 if (!isset($section->parametrs->param16)) $section->parametrs->param16 = "true";
 if (!isset($section->parametrs->param15)) $section->parametrs->param15 = "50";
 if (!isset($section->parametrs->param21)) $section->parametrs->param21 = "50";
 if (!isset($section->parametrs->param20)) $section->parametrs->param20 = "true";
 if (!isset($section->parametrs->param17)) $section->parametrs->param17 = "768";
 if (!isset($section->parametrs->param18)) $section->parametrs->param18 = "1";
 if (!isset($section->parametrs->param19)) $section->parametrs->param19 = "false";
 if (!isset($section->parametrs->param24)) $section->parametrs->param24 = "false";
 if (!isset($section->parametrs->param22)) $section->parametrs->param22 = "false";
 if (!isset($section->parametrs->param23)) $section->parametrs->param23 = "n";
   foreach($section->parametrs as $__paramitem){
    foreach($__paramitem as $__name=>$__value){
      while (preg_match("/\[%([\w\d\-]+)%\]/u", $__value, $m)!=false){
        $__result = $__data->prj->vars->$m[1];
        $__value = str_replace($m[0], $__result, $__value);
      }
      $section->parametrs->$__name = $__value;
     }
   }
?>