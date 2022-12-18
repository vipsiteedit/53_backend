<?php


function Article_CheckMail_new($name)
{
    if (preg_match("/[0-9a-z_\-]+@([0-9a-z_\-^\.]+\.[a-z]{2,4})$/i", $name, $matches))
    {
        return true;
    }
   return false;
}

if (!function_exists('Article_CheckAuth')){
function Article_CheckAuth($users)
{
     $table = new seTable();
     if (seUserGroup() == 3)
         return true;
     else
     {
         $table->from("se_user");
         $table->select("username");
         $table->addWhere("`id` = ?", seUserId());
         $table->fetchOne();
         $name = $table->username;

         $logins = explode(',', $users);
         foreach($logins as $val)
         {
             $val = trim($val);
             if ($val == $name)
                 return true;
         }
     }
     unset($table);
     return false;
}}
?>