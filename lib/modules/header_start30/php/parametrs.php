<?php
 if (!isset($section->parametrs->param8)) $section->parametrs->param8 = "kabinet";
 if (!isset($section->parametrs->param2)) $section->parametrs->param2 = "n";
 if (!isset($section->parametrs->param5)) $section->parametrs->param5 = "Y";
 if (!isset($section->parametrs->param3)) $section->parametrs->param3 = "{$__data->prj->vars->sitephone}";
 if (!isset($section->parametrs->param4)) $section->parametrs->param4 = "{$__data->prj->vars->sitemail}";
 if (!isset($section->parametrs->param7)) $section->parametrs->param7 = "Y";
 if (!isset($section->parametrs->param9)) $section->parametrs->param9 = "Y";
 if (!isset($section->parametrs->param10)) $section->parametrs->param10 = "search";
 if (!isset($section->parametrs->param11)) $section->parametrs->param11 = "N";
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