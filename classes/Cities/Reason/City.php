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
        $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);

        $materials = $this->od->getMaterials()->where('alias like "' . $this->host . '"');

        $this->city = $materials[0];
    }

    public function getCities($citiesList = [])
    {

        $cities = $this->od->getMaterials();
            return $this->setLinks($cities);


    }

    public function setLinks($materials)
    {
        foreach ($materials as $key => $value) {
            $value->fields['link'] =   'https://'.Utility::getDomain().'/'.$materials[$key]->alias.'/';
        }
        return $materials;
    }
}
