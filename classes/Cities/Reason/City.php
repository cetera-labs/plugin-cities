<?php

namespace Cities\Reason;

use Cetera\Material;
use Cities\Accessory\Utility;

class City
{
    public const  MATERIAL_TYPE = 'cities';
    public const DEFAULT_CITY_ALIAS = 'moscow';
    public $cityAlias;
    public $city;
    private $od;


    private function setMaterial()
    {
        if (!$this->od) {
            $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);
        }

        $alias = $this->cityAlias;
        try {
            $sql = "`alias` = '{$alias}'";
            $list = $this->od->getMaterials()->where($sql)->asArray();
            $this->city = $list[array_key_first($list)];
        } catch (\Exception $e) {
        }
    }

    /**
     * @todo redirect for materials needed
     */
    public function __construct()
    {


        $this->settings = \Cities\Accessory\Settings::getInstance();

        $this->cityAlias = Utility::getDomainAlias();

        try {
            $geoAlias = Utility::getGeoAlias();
            if ($geoAlias !== false) {
                $this->cityAlias = $geoAlias;
                $this->setMaterial();
                return $this;
            }
        } catch (\Exception $e) {
        }


        $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);
        if ($this->cityAlias === false) {
            $materials = $this->od->getMaterials()->where("osnova = true");
            if (count($materials)) {
                $this->city = $materials[0];
                $this->cityAlias = $this->city['alias'];
                self::redirect($this->cityAlias);
            }
        } else {
            /** @var \Cetera\Iterator\Material $materials */
            $alias = $this->cityAlias;

            $materials = $this->od->getMaterials()->where("`alias` LIKE '{$alias}'");

            if (!$materials->count()) {
                /** @var \Cetera\Iterator\Material $defaultCityMaterial */
                $alias = self::DEFAULT_CITY_ALIAS;
                $materials = $this->od->getMaterials()->where("`alias` LIKE '{$alias}'");
            }

            if (!$materials->count()) {
                $materials = $this->od->getMaterials()->where("`osnova` = 1");
            }

            if (!$materials->count()) {
                $materials = $this->od->getMaterials();
            }

            try {
                $this->city = $materials[0];
                $this->redirect($this->city['alias']);
            } catch (\Exception $e) {
            }
        }

        return $this;
    }


    /**
     * @return Material|null
     */
    public function getCityMaterial()
    {
        return $this->city;
    }

    public function getCities($citiesList = [])
    {

        $cities = $this->od->getMaterials();
        return $this->setLinks($cities);
    }

    public function setLinks($materials)
    {
        foreach ($materials as $key => $value) {
            $value->fields['link'] = 'https://' . Utility::getDomain() . '/' . $materials[$key]->alias . '/';
        }
        return $materials;
    }

    public static function findByAlias($alias)
    {
        $_od = \Cetera\ObjectDefinition::findByAlias(self::MATERIAL_TYPE);

        $sql = "`alias` = '$alias'";
        return $_od->getMaterials()->where($sql);
    }

    /**
     * @todo redirect with URI!!!
     * @param $alias
     * @return void
     */
    protected static function redirect($alias)
    {
        $base = Utility::getBaseDomain();
        $location = $base . "/$alias/";
//        die("Redirecting to $location");
        header("Location: $location");
        die();
    }
}
