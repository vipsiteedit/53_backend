<?php

if (!defined('SE_DB_ENABLE') || !SE_DB_ENABLE || !defined('SE_DIR')) 
    return;

function rss_cenerator($len = 500, $lim = 100, $lng = 'rus') {
    $timesave=10;
    
    if (file_exists(SE_SAFE . 'projects/' . SE_DIR . 'project.xml')) {
        $prj = simplexml_load_file(SE_SAFE . 'projects/' . SE_DIR . $folder . 'project.xml');
        $domain = $prj->sitedomain;
        unset($prj);
    }
    
    if (!$domain) {
        $domain = _HTTP_ . $_SERVER['HTTP_HOST'];
    }
    
    if (DEFAULTTIMEZONE) {
        date_default_timezone_set(DEFAULTTIMEZONE); 
    }
    
    $thisdate = time()+86400;
    $category = new seTable('news_category');
	$category->select('id, ident, title');
	$catlist = $category->getlist();
    
	foreach($catlist as $cat) {
        $filename = getcwd() . '/' . SE_DIR . 'rss/' . $cat['ident'] . '.xml';
        
        if (!file_exists($filename) || (filemtime($filename) < time() - ($timesave*60))) {
            if (!is_dir(getcwd() . '/' . SE_DIR . 'rss')) {
                @mkdir(getcwd() . '/' . SE_DIR . 'rss');
            }
            
            $newss = new seTable('news', 'n');
            $newss->select("n.id, n.news_date, n.title, n.short_txt, n.img, n.text, nc.ident");
            $newss->innerJoin('news_category nc', 'nc.id=n.id_category');
            $newss->where("n.active='Y'");
            //$newss->andwhere('n.id_category=?', $cat['id']);
            $newss->orderby('n.news_date', 1);
            $newslist = $newss->getList(0, $lim);
            
            createFeedNews($cat, $newslist, $domain);
            createFeedNewsTurbo($cat, $newslist, $domain);
        }
    }
}

function createFeedNews($cat, $newslist, $domain, $len = 500, $lng = 'rus')
{
    $filename = getcwd() . '/' . SE_DIR . 'rss/' . $cat['ident'] . '.xml';
    
    $xml ="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $xml .="<rss version=\"2.0\"  xmlns:yandex=\"http://news.yandex.ru\" xmlns:media=\"http://search.yahoo.com/mrss/\" xmlns:turbo=\"http://turbo.yandex.ru\">\n";
    $xml .="\t<channel>\n";
    $xml .="\t\t<title>{$cat['title']}</title>\n";
    $xml .="\t\t<link>" . $domain . "/</link>\n";
    $xml .="\t\t<language>$lng</language>\n";
    
    if (!empty($newslist)) {
        foreach ($newslist as $news) {
            @$note = $news['short_text'];
            if (empty($note)) {
                $note = se_LimitString($news['text'], $len);
            }    
            
            $text = $news['text'];
            
            $link = $domain. '/show' . $news['ident'] . '/' . $news['id'] . '/';
            
            $images = array();

            if (preg_match_all('/<img[^>]+?>/m', $text, $m)) {
                foreach ($m[0] as $val) {
                    $text = str_replace($val, '', $text);
                    preg_match('/src=[\'"](.+?)[\'"]/', $val, $m);
                    $src = trim($m[1]);
                    
                    $src = preg_replace('~^//(.+)~', _HTTP_ . '$1', $src);
                    
                    $images[] = $src;
                }
                $text = preg_replace('~(<(.*)[^<>]*>\s*<\/\2>)~i', '', $text);
            }
            
            $xml .= "\t\t<item>\n";
            $xml .= "\t\t\t<title>" . $news['title'] . "</title>\n";
            $xml .= "\t\t\t<link>" . htmlspecialchars($link) . "</link>\n";
            
            if (!empty($news['img'])) {
                $_imnames = se_getDImage('/images/' . $lng . '/newsimg/' . $news['img'], 300, '', '', '', '', '', '', 'create');
                $images[] = $_image = $domain. $_imnames;
                $xml .= "\t\t\t<image>" . $_image . "</image>\n";
            }
            
            $xml .= "\t\t\t<description>" . htmlspecialchars($note) . "</description>\n";
            $xml .= "\t\t\t<yandex:full-text>" . htmlspecialchars($text) . "</yandex:full-text>\n";
            $xml .= "\t\t\t<pubDate>" . date(DATE_RFC822, $news['news_date']) . "</pubDate>\n";
            
            foreach ($images as $val) {
                $xml .= "\t\t\t<enclosure url=\"" . $val . "\"/>\n";
            }
            
            $xml .= "\t\t</item>\n";
        }
    }
    
    $xml .= "\t</channel>\n";
    $xml .= "</rss>\n";
    
    file_put_contents($filename, $xml);
}

function createFeedNewsTurbo($cat, $newslist, $domain, $len = 500, $lng = 'rus')
{
    $filename = getcwd() . '/' . SE_DIR . 'rss/' . $cat['ident'] . '_turbo.xml';
    
    $xml ="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
    $xml .="<rss version=\"2.0\"  xmlns:yandex=\"http://news.yandex.ru\" xmlns:media=\"http://search.yahoo.com/mrss/\" xmlns:turbo=\"http://turbo.yandex.ru\">\n";
    $xml .="\t<channel>\n";
    $xml .="\t\t<title>{$cat['title']}</title>\n";
    $xml .="\t\t<link>" . $domain . "/</link>\n";
    $xml .="\t\t<language>$lng</language>\n";
    
    if (!empty($newslist)) {
        foreach ($newslist as $news) {
            @$note = $news['short_text'];
            if (empty($note)) {
                $note = se_LimitString($news['text'], $len);
            }    
            
            $link = $domain. '/show' . $news['ident'] . '/' . $news['id'] . '/';
            
            $xml .= "\t\t<item turbo=\"true\">\n";
            $xml .= "\t\t\t<link>" . htmlspecialchars($link) . "</link>\n";
            
            if (!empty($news['img'])) {
                $_imnames = se_getDImage('/images/' . $lng . '/newsimg/' . $news['img'], 300, '', '', '', '', '', '', 'create');
                $_image = $domain. $_imnames;
            }
            
            $xml .= "\t\t\t<pubDate>" . date(DATE_RFC822, $news['news_date']) . "</pubDate>\n";
            
            $header = '<header>
                <h1>' . $news['title'] . '</h1>
                <figure>
                    <img src="' . $_image. '">
                </figure>
            </header>';
            
            
            $xml .= "\t\t\t<turbo:content><![CDATA[" . $header . $note . "]]></turbo:content>\n";
            
            $xml .= "\t\t</item>\n";
        }
    }
    
    $xml .= "\t</channel>\n";
    $xml .= "</rss>\n";
    
    file_put_contents($filename, $xml);
}

rss_cenerator();