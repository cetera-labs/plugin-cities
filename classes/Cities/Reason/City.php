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


    public function __construct()
    {


        $this->settings = \Cities\Accessory\Settings::getInstance();

        $this->cityAlias = Utility::getDomainAlias();
        $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);

        if ($this->cityAlias === false){
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
            } catch (\Exception $e) {
            }
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

    protected static function redirect($alias)
    {
        /**
         * @todo redirect to main; complete with current page;
         */
//        if (getenv('RUN_MODE') !== 'development') {
//            $location = 'https://'. $alias . '.' .Utility::getDomain();
//            header("Location: $location");
//            die();
//        }
    }

}
