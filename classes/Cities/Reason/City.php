<?php

namespace Cities\Reason;

use Cities\Accessory\Utility;

class City
{
    const  MATERIAL_TYPE = 'cities';

    public $cityAlias;

    private $od;

    public $city;

    const DEFAULT_CITY_ALIAS = 'moscow';

    public function __construct()
    {

        $this->settings = \Cities\Accessory\Settings::getInstance();

        $this->cityAlias = Utility::getDomainAlias();

        $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);

        /** @var \Cetera\Material $materials */
        $materials = $this->od->getMaterials()->where('alias like "' . $this->cityAlias . '"');


        $defaultCityMaterial = $this->od->getMaterials()->where('alias like "' . self::DEFAULT_CITY_ALIAS . '"');

        $baseDomain = "";
        if ($materials->count() > 0) {
            $this->city = $materials[0];
        } elseif ($defaultCityMaterial->count()) {
            $this->city = $defaultCityMaterial[0];
        }

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
