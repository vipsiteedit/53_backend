<?php
 if (empty($section->parametrs->param12)) $section->parametrs->param12 = "all";
 if (empty($section->parametrs->param6)) $section->parametrs->param6 = "R";
 if (empty($section->parametrs->param5)) $section->parametrs->param5 = "10";
 if (empty($section->parametrs->param8)) $section->parametrs->param8 = "Y";
 if (empty($section->parametrs->param4)) $section->parametrs->param4 = "shopcart";
 if (empty($section->parametrs->param9)) $section->parametrs->param9 = "N";
 if (empty($section->parametrs->param10)) $section->parametrs->param10 = "catalogue";
 if (empty($section->parametrs->param13)) $section->parametrs->param13 = "Y";
 if (empty($section->parametrs->param14)) $section->parametrs->param14 = "";
 if (empty($section->parametrs->param15)) $section->parametrs->param15 = "Y";
 if (empty($section->parametrs->param16)) $section->parametrs->param16 = "N";
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