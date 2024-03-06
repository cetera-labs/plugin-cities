<?php


namespace Cities\Reason;

use \Cities\Accessory\Utility;

Class City
{

    const  MATERIAL_TYPE = 'cities';

    private $host;

    private $od;

    public static $city;

    public function __construct()
    {

        $this->settings = \Cities\Accessory\Settings::getInstance();

        $this->host = Utility::getDomain(true);

        if (empty($this->host) || $this->host == $_SERVER['SERVER_NAME']) {
            $this->host = $this->settings->fields['default_city'];
        }

        $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);

        $materials = $this->od->getMaterials()->where('alias like "' . $this->host . '"');

        $this->city = $materials[0];

        if (Utility::isMainSite()) {
            $this->city->fields['link'] = Utility::getProtocol() . Utility::getDomain();
        } else {
            $this->city->fields['link'] = Utility::getProtocol() . $this->city->alias . '.' . Utility::getDomain();
        }
    }

    public function getCities($citiesList = [])
    {

            if (sizeof($citiesList)) {
                $cities = $this->od->getMaterials()->where('id in (' . implode(', ', $citiesList) . ')');
            } else {
               $cities = $this->od->getMaterials();
            }
            return $this->setLinks($cities);
    

    }

    public function setLinks($materials)
    {
        foreach ($materials as $key => $value) {
            $value->fields['link'] = Utility::getProtocol() . $materials[$key]->alias . '.' . Utility::getDomain();
        }
        return $materials;
    }
}
