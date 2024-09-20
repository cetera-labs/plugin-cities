<?php

namespace Cities\Accessory;

Class Settings
{


    private $connect;

    private $a;

    public $fields;

    private $querybuilder;

    const  SETTINGS_TABLE = "`cities_settings`";


    public static function getInstance()
    {
        static $instance;

        return !is_null($instance) ? $instance : $instance = new Settings();
    }

    private function __construct()
    {

        $this->a = \Cetera\Application::getInstance();
        $this->connect = $this->a->getConn();
        $this->querybuilder = \Cetera\DbConnection::getDbConnection()->createQueryBuilder();
        $this->fields = $this->getFields();
    }

    public function setFields($field, $value)
    {

        $r = $this->querybuilder
            ->update(self::SETTINGS_TABLE)
            ->set($field, $this->querybuilder->expr()->literal($value))
            ->where('id', 1)
            ->execute();
    }

    public function getFields()
    {

        $r = $this->querybuilder
            ->select('*')
            ->from(self::SETTINGS_TABLE)
            ->where('id', 1)
            ->execute();


        /** @var \Doctrine\DBAL\ForwardCompatibility\Result $r */
        if ($r && $r->rowCount()) {
           return $r->fetch();
        }



        return [""];
    }

    public function getFieldByName($name)
    {

        $r = $this->querybuilder
            ->select($name)
            ->from(self::SETTINGS_TABLE)
            ->where('id', 1)
            ->execute();

        return $r->fetchColumn();
    }

    public function isUseSitemap()
    {

        $r = $this->connect->fetchColumn("select use_sitemap from ? where id = ?", array(self::SETTINGS_TABLE, 1));

        return $r;
    }

}
