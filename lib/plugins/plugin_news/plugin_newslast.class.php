<?php

class plugin_newslast
{
    
    public function __construct()
    {
        
    }
    
    private function getPageModule($module = '', $params = array()) {
        if ($module) {
            $module_name = $module . '_' . md5(print_r($params, 1));
            $project_dir = SE_SAFE . 'projects/' . SE_DIR;
            $project_file = $project_dir . 'project.xml';
            $pages_dir = $project_dir . 'pages/';
                
            if (!file_exists($project_dir . 'types/mdl_' . $module_name) || filemtime($project_dir . 'types/mdl_' . $module_name) < filemtime($project_file)) {
                $files = glob($pages_dir . '*.xml');
                
                if (!empty($files)) {
                    foreach ($files as $file) {
                        if (file_exists($file)) {
                            $xml = simplexml_load_file($file);

                            foreach ($xml->sections as $section) {        
                                if ((string)$section->type == $module) {
                                    if ($params) {
                                        foreach ($params as $param => $val) {
                                            if (isset($section->parametrs->{$param}) && $section->parametrs->{$param} == $val) {
                                                continue;
                                            }
                                            break 2;
                                        }
                                    }
                                    $page = substr(basename($file), 0, -4);
                                    break 2;
                                }
                            }
                                
                        }
                    }
                }
                
                return $page;
                
                $f = fopen($project_dir . 'types/mdl_' . $module_name, 'w+');
                fwrite($f, $page);
                fclose($f);
                
                return $page;
            }
            else {
                $ftype = file($project_dir . 'types/mdl_' . $module_name);
                foreach($ftype as $item){
                    return $item;
                }
            }
        }
        return;
    }
    
    private function getRecordList($page, $module)
    {
        $result = array();
        
        if ($page) {
            $page_file = SE_SAFE . 'projects/' . SE_DIR . 'pages/' . $page . '.xml';
            
            if (file_exists($page_file)) {
                $xml = simplexml_load_file($page_file);

                foreach ($xml->sections as $section) {        
                    if ((string)$section->type == $module) {
                        $result = $section->objects;
                    }
                }
                    
            }
        }
        
        return $result;
    }
    
    private function getModuleRecords($module)
    {
        $result = array();
        
        $page = $this->getPageModule($module);
        
        if ($page) {
            $result = $this->getRecordList($page, $module);
        }
        
        return $result;
    }
    
    public function getNewsList($page, $limit = 3)
    {
        $module = 'mnews';
        
        $records = $this->getRecordList($page, $module);
        
        $list = array();
        
        if ($records) {
            $i = 0;
            foreach ($records as $record) {
                
                if ((string)$record->visible == 'on') {
                    
                    if (!empty($record->image) && empty($record->image_prev)) {
                        if (strpos($record->image, '://') === false) {
                            $prev = explode('.', $record->image);
                            $record->image_prev = $prev[0] . '_prev.' . $prev[1];
                        } else {
                            $record->image_prev = $record->image;
                        }
                    }
                    
                    $list[] = array(
                        'title' => (string)$record->title,  
                        'link' => seMultiDir(). '/' . $page . '/'. (!empty($record->url) ? (string)$record->url : se_translite_url($record->title)) . SE_END,
                        'note' => (string)$record->note,   
                        'text' => (string)$record->text, 
                        'date' => (string)$record->field,
                        'image_prev' => $record->image_prev,
                        'image_alt' => $record->image_alt ? (string)$record->image_alt : (string)$record->title,
                        'image_title' => $record->image_title ? (string)$record->image_title : (string)$record->title,
                    );
                    
                    if (!empty($object->image) && empty($object->image_prev)) {
                            if (strpos($object->image, '://') === false) {
                                $prev = explode('.', $object->image);
                                $object->image_prev = $prev[0] . '_prev.' . $prev[1];
                            } else {
                                $object->image_prev = $object->image;
                            }
                        }
                }
            }
            //krsort($list);
            
            $list = array_slice($list, 0, $limit);
        }
        
        return $list;
    }
}