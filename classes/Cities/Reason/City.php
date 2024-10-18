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
            $list = $this->od->getMaterials()->where($sql);
            $this->city = $list[0];
        } catch (\Exception $e) {
        }
    }

    /**
     * @todo redirect for materials needed
     */
    public function __construct()
    {

       // die("cityConstruct");

        /** @var \Cities\Accessory\Settings */
        $this->settings = \Cities\Accessory\Settings::getInstance();
        $this->cityAlias = Utility::getDomainAlias();

        try {
            /** @todo what this shit?*/
            $geoAlias = Utility::getGeoAlias();


            if ($geoAlias !== false) {
                $this->cityAlias = $geoAlias;
                $this->setMaterial();
                $this->setRedirectFlag();

               // $this->redirect($this->cityAlias);
                return $this;
            }
        } catch (\Exception $e) {
        }




        $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);
        if ($this->cityAlias === false) {
//            var_dump($this->cityAlias)   ;
//
            //die("City1");
            /**
             * @todo grab default city by $this->settings instead this code
             */
            $materials = $this->od->getMaterials()->where("osnova = true");
            if (count($materials)) {
                $this->city = $materials[0];
                $this->cityAlias = $this->city['alias'];
                $this->setRedirectFlag();

                return $this;
                //self::redirect($this->cityAlias);
            }
        } elseif (!$this->city) {
           // die("City2");
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

        /*@todo wrong link */

        global $geoURL;


        if (Utility::isMainSite()) {
            $geoURL = Utility::getProtocol() . Utility::getBaseDomain();
        } elseif (Utility::getDomainAlias()) {
                /* this not main domain and have geo subdomain*/
            self::redirect($this->cityAlias);
            $geoURL = Utility::getProtocol() . Utility::getBaseDomain() . "/" . $this->cityAlias . "/";
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

    public function setRedirectFlag()
    {
        //$_COOKIE['link'] = $this->cityAlias;
    }
    /**
     * @todo redirect with URI!!!
     * @param $alias
     * @return void
     */
    protected static function redirect($alias)
    {
        $realUri = Utility::getRealURI();
        $location    = Utility::getProtocol() . Utility::getBaseDomain() . "/" . $alias . "/";
        if (strlen($realUri) > 2) {
            $location .= $realUri . '/';
        }
        header("Location: $location");
        die();
    }
}
