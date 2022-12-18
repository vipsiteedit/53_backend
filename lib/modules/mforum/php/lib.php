<?php

function forum_getrobots($str) {
    if (preg_match ("/Aport/i", "$str") && 
        preg_match ("/Catalog/i", "$str")) {
        return "Aport-каталог";
    } else if (preg_match ("/Aport/i", "$str")) {
        return "Aport";
    } else if (preg_match ("/Dumbot/i", "$str")) {
        return "DumbFind";
    } else if (preg_match ("/Gokubot/i", "$str") || 
                preg_match ("/goku\.ru/i", "$str")) {
        return "goku.ru";
    } else if (preg_match ("/Google/i", "$str")) {
        return "Google";
    } else if (preg_match ("/Yahoo/i", "$str")) {
        return "Yahoo!";
    } else if (preg_match ("/\bmsnbot/i", "$str") || 
                preg_match ("/\.msn\./i", "$str")) {
        return "MSN";
    } else if (preg_match ("/Rambler/i", "$str")) {
        return "Rambler";
    } else if (preg_match ("/Yandex/i", "$str")) {
        return "Yandex";
    } else if (preg_match ("/NetStat\.ru/i", "$str")) {
        return "NetStat.ru";
    } else {
        return "other";
    }
}

function textedit($text, $user, $msg, $iconssmiles, $_page, $razdel, $path = false, $section) {
    $trans = array(
                    "[b]" => "<b>", "[/b]" => "</b>",
                    "[em]" => "<em>", "[/em]" => "</em>",
                    "[u]" => "<u>", "[/u]" => "</u>",
//                    "[ul]" => "<ul>", "[/ul]" => "</ul>",
//                    "[ol]" => "<ol>", "[/ol]" => "</ol>",
                    "[center]" => "<center>", "[/center]" => "</center>",
                    "[sup]" => "<sup>", "[/sup]" => "</sup>",
                    "[sub]" => "<sub>", "[/sub]" => "</sub>",
                    "[code]" => "<pre id=code>", "[/code]" => "</pre>",
                    "[quote]" => "<div id=quote>", "[/quote]" => "</div>",
            );
    $text = nl2br($text);
    $res = $text;
    while (preg_match("/([\w\W]*?)(\[(ol|ul)([^\]]*)\])([\w\W]*)/i", $res, $mtch)) {
        $res = $mtch[1];
        $oldTg = $mtch[2];
        $tg = $mtch[3];
        $tgInfo = $mtch[4];
        $txt = $mtch[5];
        do {
            preg_match("/([\w\W]*?)(\[$tg([^\]]*)\])([\w\W]*)/i", $txt, $mtch2);
            preg_match("/([\w\W]*?)\[\/$tg([^\]]*)\]([\w\W]*)/i", $txt, $mtch3);
            if (!count($mtch2) || (strlen($mtch2[1]) > strlen($mtch3[1]))) {
                $res .= "<$tg$tgInfo>";
                $txt = preg_replace("/<br[^>]*>/i", "<br>", $mtch3[1]);
                foreach (explode("<br>", $txt) as $v) {
                    $res .= "<li>$v</li>";  
                }        
                $res .= "</$tg>" . $mtch3[3];
                break;
            } else {
                $res .= $oldTg . $mtch2[1];
                $oldTg = $mtch2[2];
                $tgInfo = $mtch2[3];
                $txt = $mtch2[4];
            } 
        } while (1);
    }
    $text = $res;
//    $text = str_replace (' ', '&nbsp;', $text);
    $text = strtr($text, $trans);                  
    $addr = ($path) ? $_SERVER['CHARSET_HTTP_METHOD'].$_SERVER['HTTP_HOST'] : '';
//Заменяем url

    if ($section->parametrs->param101=='Y') {
        $text = preg_replace('~(?<!href=|\])(https?://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(?:[^\s<>]+))~i', '[a href=$1]$1[/a]', $text);
    }

    preg_match_all("/\[a +href=([^]]+)\]([^]]+)\[\/a\]/i", $text, $match, PREG_PATTERN_ORDER);
    for($j=0; $j<count($match[1]); $j++) {
        $text = str_replace($match[0][$j], "<a id=outlink href='$addr/$_page/$razdel/sub12/?link=".urlencode(str_replace("&amp;", "&", $match[1][$j]))."' target=_blank>".$match[2][$j].'</a>', $text);
    }
//Заменяем mailto
    $text = preg_replace("/\[mailto=([^]]+)\]([^]]+)\[\/mailto\]/", "<a href=\"mailto:$1\">$2</a>", $text);
//Заменяем img
    $text = preg_replace("/\[img +src=([^]]+)\]/", "<img src=\"$1\">", $text);
//Заменяем смайлики
    $text = preg_replace("/\[smile([[:digit:]]+)\]/", "<img src='".$addr."$iconssmiles/smile\\1.gif'>", $text);
//Заменяем цвет
    $text = preg_replace("/\[color *= *(#[\d|A-F|a-f]+)\]([^\]]+)\[\/color\]/i", "<font color='$1'>$2</font>", $text);
//Заменяем прикрепленные картинки
    $tbl = new seTable("forum_attached","fa");
    $tbl->where("id_user = '?'", $user);
    $tbl->andWhere("id_msg = '?'", $msg);
    $raf = $tbl->getList();
    unset($tbl);
    foreach ($raf as $afile) {
        if (file_exists ('modules/forum/upload/'.$afile['file'])) {
            if (preg_match ("/^[^\.]+\.(gif|png|jpg|jpeg)$/", $afile ['file'])) {
                $src = $addr."/modules/forum/upload/".$afile['file'];
                $replace = '<a rel="group" class="forum-img-link" href="' . $src . '"><img id="forumimg" src="' . $src . '"></a>';
            } else {
                $replace = "<div id=topic_attach><a id=topic_linkat href='".$addr."/$_page/$razdel/sub14/?file=".md5($afile['file'])."' target=_blank>".$afile['realname']." (".round($afile['size']/1024, 2)." кБ)</a> Количество скачиваний: <b id=topic_dnlnumb>".$afile['counter']."</b></div>";
            }
            $afile['realname'] = preg_quote($afile['realname']);
            $text = preg_replace("/\[attimg +src=(".$afile['realname'].")\]/", $replace, $text);
            $text = preg_replace("/\[attfile +src=(".$afile['realname'].")\]/", $replace, $text);
        }
    }
    return $text;
}

function originResult($origin) {
    $origin = str_replace("\n", "<br>", $origin);
    //Заменяем тэги
    $trans = array("[b]" => "<b>", "[/b]" => "</b>",
                    "[em]" => "<em>", "[/em]" => "</em>",
                    "[u]" => "<u>", "[/u]" => "</u>",
                    "[ul]" => "<ul>", "[/ul]" => "</ul>",
                    "[ol]" => "<ol>", "[/ol]" => "</ol>",
                    "[quote]" => "<div id=quote>", "[/quote]" => "</div>");
    $origin = strtr($origin, $trans);
  //Заменяем url
    $origin = preg_replace("/\[a +href=([^\]]+)\]([^\[]+)\[\/a\]/i", "<a id='user_linkSite' href='$1'>$2</a>", $origin);
  //Заменяем mailto
    $origin = preg_replace("/\[mailto=([^\]]+)\]([^\[]+)\[\/mailto\]/i", "<a id='user_linkEmail' href=\"mailto:$1\">$2</a>", $origin);
  //Заменяем img
    $origin = preg_replace("/\[img +src=([^\]]+)\]/i", '<img src="\\1">', $origin);
  //Заменяем смайлики
    $origin = preg_replace("/\[smile([[:digit:]]+)\]/i", "<img src='$iconssmiles/smile\\1.gif'>", $origin);
  //Заменяем цвет
    return preg_replace("/\[color *= *(#[\d|A-F|a-f]+)\]([^\[]+)\[\/color\]/i", "<font color='$1'>$2</font>", $origin);
}

function updateDB($section) {
    $err = '';
    $file_path = getcwd().'/system/logs/mforum.upd';
    if(!file_exists($file_path)){
    // Создаем базы
    se_db_query("CREATE TABLE IF NOT EXISTS `forum_area` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `order_id` int(10) unsigned NOT NULL,
        `name` varchar(50) NOT NULL,
        `enabled` enum('Y','N') NOT NULL DEFAULT 'Y',
        `visible` enum('Y','N') NOT NULL DEFAULT 'Y',
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
         PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    
    se_db_query("CREATE TABLE IF NOT EXISTS `forum_attached` (
        `file` varchar(255) NOT NULL,
        `realname` varchar(255) NOT NULL,
        `id_user` int(10) unsigned NOT NULL,
        `id_msg` int(10) unsigned NOT NULL,
        `size` int(10) unsigned NOT NULL,
        `counter` int(10) unsigned NOT NULL,
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;    
    ");
    
    se_db_query("CREATE TABLE IF NOT EXISTS `forum_forums` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `order_id` int(10) unsigned NOT NULL,
        `id_area` int(11) NOT NULL,
        `name` varchar(50) NOT NULL,
        `description` text NOT NULL,
        `img` varchar(25) NOT NULL,
        `moderator` int(11) NOT NULL,
        `visible` enum('Y','N') NOT NULL DEFAULT 'Y',
        `enable` enum('Y','N') NOT NULL DEFAULT 'Y',
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    
    se_db_query("CREATE TABLE IF NOT EXISTS `forum_msg` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_topic` int(11) NOT NULL,
        `id_users` int(11) NOT NULL,
        `text` text NOT NULL,
        `date_time` int(11) NOT NULL,
        `priority` int(11) NOT NULL,
        `ip` varchar(15) NOT NULL,
        `date_time_edit` int(11) NOT NULL,
        `moderator_edit` enum('N','Y') NOT NULL DEFAULT 'N',
        `date_time_moderator_edit` int(11) NOT NULL,
        `msg_id` int(11) DEFAULT NULL,
        `to_whom` int(11) DEFAULT NULL,
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    
    se_db_query("DROP TABLE IF EXISTS `forum_session`");
    se_db_query("CREATE TABLE IF NOT EXISTS `forum_session` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `sid` varchar(32) NOT NULL,
        `id_users` int(11) NOT NULL,
        `namerobot` varchar(255) NOT NULL,
        `date_time` int(11) NOT NULL,
        `date_time_last` int(10) unsigned NOT NULL,
        `showmsg` text NOT NULL,
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    
    se_db_query("CREATE TABLE IF NOT EXISTS `forum_status` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(20) NOT NULL,
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    
    se_db_query("CREATE TABLE IF NOT EXISTS `forum_topic` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_forums` int(11) NOT NULL,
        `name` varchar(255) NOT NULL,
        `priority` int(11) NOT NULL,
        `email` varchar(50) NOT NULL,
        `views` int(11) NOT NULL,
        `date_time` int(11) NOT NULL,
        `id_users` int(11) NOT NULL,
        `date_time_new` int(11) NOT NULL,
        `id_user_new` int(11) NOT NULL,
        `enable` enum('N','Y') NOT NULL DEFAULT 'Y',
        `visible` enum('N','Y') NOT NULL DEFAULT 'Y',
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

    se_db_query("CREATE TABLE IF NOT EXISTS `forum_users` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_author` int(11) NOT NULL,
        `id_status` int(11) NOT NULL,
        `nick` varchar(20) NOT NULL,
        `realname` varchar(50) NOT NULL,
        `location` varchar(255) NOT NULL,
        `jobtitle` varchar(255) NOT NULL,
        `interests` varchar(255) NOT NULL,
        `email` varchar(50) NOT NULL,
        `icq` varchar(12) NOT NULL,
        `url` varchar(50) NOT NULL,
        `img` varchar(25) NOT NULL,
        `origin` varchar(255) NOT NULL,
        `enabled` enum('N','Y') NOT NULL DEFAULT 'Y',
        `registered` int(11) NOT NULL,
        `last` int(11) NOT NULL,
        `smoderator` enum('Y','N') NOT NULL DEFAULT 'N',
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

        $tbl = new seTable ("forum_status", "fs");
        $tbl->select("COUNT(fs.id) AS id");
        $tbl->fetchOne();
        if (!intval($tbl->id)) {
            $tbl->insert();
            $tbl->name = $section->language->lang191;
            $tbl->save();
        }
        unset($tbl);
        
        $tbl = new seTable ("forum_msg", "fm");
        $tbl->addField ('msg_id', 'integer');
        $tbl->addField ('to_whom', 'integer');
        unset ($tbl);
        
        
        foreach (array ('forum_area', 'forum_attached', 'forum_forums', 'forum_msg',
                        'forum_session', 'forum_status', 'forum_topic', 'forum_users') 
                    as $v) {
            if (!se_db_is_field($v, 'updated_at')) {
                se_db_query ("ALTER TABLE `$v` 
                                    ADD `updated_at` TIMESTAMP NOT NULL 
                                        DEFAULT CURRENT_TIMESTAMP");
                $err .= se_db_error();
            }
            if (!se_db_is_field($v, 'created_at')) {
                se_db_query ("ALTER TABLE `$v` 
                                    ADD `created_at` TIMESTAMP NOT NULL AFTER `updated_at`");
                $err .= se_db_error();
            }
        }

    
        se_db_query("ALTER TABLE `forum_forums` CHANGE `name` `name` VARCHAR(255) NOT NULL");
        $err .= se_db_error();
    
        if (!se_db_is_field('forum_forums', 'lang')) {
            se_db_query("ALTER TABLE `forum_forums` ADD `lang` VARCHAR( 6 ) NOT NULL DEFAULT 'rus' AFTER `id`");
            $err .= se_db_error();
        }

        if (!se_db_is_field('forum_area', 'lang')) {
            se_db_query("ALTER TABLE `forum_area` ADD `lang` VARCHAR( 6 ) NOT NULL DEFAULT 'rus' AFTER `id`");
            $err .= se_db_error();
        }

        if(!$err) {
            if (!file_exists(getcwd().'/modules/forum/')) {
                mkdir(getcwd().'/modules/forum');
            }
            if (!file_exists(getcwd().'/modules/forum/upload/')) {
                mkdir(getcwd().'/modules/forum/upload');
            }
            if (!file_exists(getcwd().'/modules/forum/images/')) {
                mkdir(getcwd().'/modules/forum/images');
            }
            if (!file_exists(getcwd().'/modules/forum/download/')) {
                mkdir(getcwd().'/modules/forum/download');
            }
            if(!is_dir(getcwd().'/system/logs/')) 
                mkdir(getcwd().'/system/logs/');
            
            file_put_contents('system/logs/mforum.upd', '');
        }
    }
    return;
    
}
?>
