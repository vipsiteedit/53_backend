<?php

class plugin_geovalues
{
    private static $instance = null;
    private $valuelist = array();
    private $cont = array();

    public function __construct()
    {
        if (empty($_SESSION['user_region'])) {
            $geo = new plugin_shopgeo();
        }
        $sc = new seTable('shop_contacts', 'sc');
        $sc->select('sc.id, sc.name, sc.url, sc.address,phone,sc.additional_phones, sc.image, sc.description');
        $sc->innerjoin('shop_contacts_geo scg', 'scg.id_contact=sc.id');
        $sc->where('sc.is_visible=1');
        $sc->andwhere("scg.id_city=?", $_SESSION['user_region']['id_city']);
        $this->cont = $sc->fetchOne();


        $sc = new seTable('shop_variables', 'sv');
        $sc->select('sv.name, IF(sgv.value IS NOT NULL, sgv.value, sv.value) value');
        $sc->leftjoin('shop_geo_variables sgv', 'sgv.id_variable=sv.id AND sgv.id_contact=' . intval($this->cont['id']));
        $sc->orderBy('name');
        $this->valuelist = $sc->getList();
    }

    public function parseValues($text)
    {
        foreach ($this->valuelist as $val) {
            $text = str_replace('{' . $val['name'] . '}', $val['value'], $text);
        }
        return $text;
    }

    public function getContact()
    {
        return $this->cont;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}