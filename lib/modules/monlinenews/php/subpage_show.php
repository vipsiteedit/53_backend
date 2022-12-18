<?php

// показать субстраницу для текущей новости
if (!empty($id)) {
    $news->select("id, title, short_txt, text, img, active, pub_date, news_date");
    $news->find($id);
    if ($news->active == 'N') {
        header("Location: ".seMultiDir()."/".$_page."/"); 
    }
    $news_title = $news->title;
    if (strpos($news->text,'<') !== false && strpos($news->text,'>') !== false){
        $news_text = $news->text;
    } else {
        $news_text = nl2br($news->text);//str_replace("\n","<br>", $news->text);
    }
    $__data->page->titlepage = htmlspecialchars(strip_tags($news->title));
    $__data->page->description = htmlspecialchars(se_LimitString(strip_tags($news->text), 195));     
    
    
    if ($section->parametrs->param35 == 'Y') {
        $news_date = date("d.m.y", $news->news_date);
    } else {
        $news_date = date("d.m.y H:i", $news->news_date);    
    }


//    echo "[$news_text]";
    if ($news->img != '') {
        $news_img = '<img class="viewImage objectImage" alt="' . 
                        htmlspecialchars($news->title) . '" src="' . $IMAGE_DIR . strval($news->img) . '" border="0">';
    } else {
        $news_img = '';
    }
    
    if (class_exists('plugin_routertags')) {
        $prt = new plugin_routertags();
        
        $tags['title'] = $news_title;
        
        if ($news->img) {
            $tags['image'] = _HOST_ . $IMAGE_DIR . strval($news->img);
        }
        
        $prt->setMetaTags($tags, 'og');
    }
}

?>
