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

    /**
     * @return Material
     */
    public function __construct()
    {


        $this->settings = \Cities\Accessory\Settings::getInstance();

        $this->cityAlias = Utility::getDomainAlias();

        $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);

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
        } catch (\Exception $e) {
        }
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
}
