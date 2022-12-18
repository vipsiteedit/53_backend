<?php
 if (!isset($section->parametrs->param98) || $section->parametrs->param98=='') $section->parametrs->param98 = "1";
 if (!isset($section->parametrs->param1) || $section->parametrs->param1=='') $section->parametrs->param1 = "10";
 if (!isset($section->parametrs->param99) || $section->parametrs->param99=='') $section->parametrs->param99 = "10";
 if (!isset($section->parametrs->param2) || $section->parametrs->param2=='') $section->parametrs->param2 = "1000";
 if (!isset($section->parametrs->param3) || $section->parametrs->param3=='') $section->parametrs->param3 = "100";
 if (!isset($section->parametrs->param4) || $section->parametrs->param4=='') $section->parametrs->param4 = "Форум";
 if (!isset($section->parametrs->param5) || $section->parametrs->param5=='') $section->parametrs->param5 = "600";
 if (!isset($section->parametrs->param91) || $section->parametrs->param91=='') $section->parametrs->param91 = "Администратор";
 if (!isset($section->parametrs->param7) || $section->parametrs->param7=='') $section->parametrs->param7 = "10";
 if (!isset($section->parametrs->param14) || $section->parametrs->param14=='') $section->parametrs->param14 = "=>";
 if (!isset($section->parametrs->param16) || $section->parametrs->param16=='') $section->parametrs->param16 = "5";
 if (!isset($section->parametrs->param17) || $section->parametrs->param17=='') $section->parametrs->param17 = "204800";
 if (!isset($section->parametrs->param18) || $section->parametrs->param18=='') $section->parametrs->param18 = "2048000";
 if (!isset($section->parametrs->param100) || $section->parametrs->param100=='') $section->parametrs->param100 = "gif,jpg,png,rar,zip,arj,gz";
 if (!isset($section->parametrs->param101) || $section->parametrs->param101=='') $section->parametrs->param101 = "N";
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
