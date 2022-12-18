<?php
    error_reporting(0);
    date_default_timezone_set('Europe/Moscow');
    define('SE_INDEX_INCLUDED', true);
    session_start();
    require 'system/main/init.php';
    //chdir('../');

//print_r($_SERVER);
if (isset($_GET['type'])){
    $module = (!empty($_GET['type'])) ? $_GET['type'] : 'mtext';
    $section = new SimpleXMLElement('<section></section>');
    $section->id = '1';
    $section->type = $module;
    define('SE_MULTI_DIR', 'show.php?type='.$module.'&');
    $page = 'home';
}
if (isset($_GET['section'])){
    define('SE_MULTI_DIR', 'show.php?section='.$_GET['section'].'&');
    
}
    $se = seData::getInstance($page, SE_DIR);
    $se->modulesCss[] = '/lib/js/bootstrap/css/bootstrap.min.css';
    $se->modulesCss[] = $se->getFolderModule($section->type).'/'.$section->type.'/css/style.css';
    $body = $se->showSection($section, false);
    echo '<!DOCTYPE html>' . "\n";
    echo "<html><head>\n";
    echo "<meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    echo replace_link(str_replace('&#10;', "\n", join("\n", $se->header)));
    foreach($se->modulesCss as $css){
       echo '<link href="' .$css.'" id="defaultCSS" rel="stylesheet" type="text/css">' . "\n";
    }
    //include "system/main/sitehead.php";
    echo '</head><body><div class="container">';
    //print_r($_SERVER);
    echo $body;
    
    //$se->execute();

    //include "system/main/skin_construction.php";
//    include "system/main/sitestat.php";
echo '</div>';
echo replace_link(str_replace('&#10;', "\n", join("\n", $se->footer)));
echo '</body></html>';