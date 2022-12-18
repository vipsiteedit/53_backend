<?php

/**
 * @copyright EDGESTILE
 */
class plugin_routertags
{

    private static $instance = null;
    private $tags = array();

    private $host;

    public function __construct($option = array())
    {
        $this->host = $this->getHost();
    }

    private function getHost()
    {
        return _HOST_;
    }

    private function getRequestUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if ($pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        if (SE_DIR != '' && substr($uri, 1, strlen(SE_DIR)) == SE_DIR && seMultiDir() == ''){
            $uri = substr($uri, strlen(SE_DIR), strlen($uri));
        }
        return $uri;
    }
    
    public function setMetaTags($tags = array(), $type = '')
    {
        if ($type == 'og') {
            $se = seData::getInstance();
            
            if (empty($tags['site_name'])) {
                $tags['site_name'] = se_getAdmin('shopname');
            }
            
            if (empty($tags['link'])) {
                $tags['link'] = $this->host . $this->getRequestUri();
            }
            
            if (empty($tags['title'])) {
                $tags['title'] = $se->page->titlepage;
            }
            
            if (empty($tags['description'])) {
                $tags['description'] = htmlspecialchars($se->page->description, ENT_QUOTES);
            }
            
            foreach ($tags as $name => $value) {
                $se->meta_tags[] = array(
                    'name' => 'og:' . $name,
                    'content' => $value,
                );
            }
        }
    }
}