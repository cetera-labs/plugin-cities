<?php


namespace Cities\Reason;

use \Cities\Accessory\Utility;

class City
{

    const  MATERIAL_TYPE = 'cities';

    private $host;

    private $od;

    public $city;

    protected const DEFAULT_CITY = 'moscow';

    public function __construct()
    {

        $this->settings = \Cities\Accessory\Settings::getInstance();

        $this->host = Utility::getDomain(true);

        $this->od = new \Cetera\ObjectDefinition(self::MATERIAL_TYPE);

        /** @var \Cetera\Material $materials */
        $materials = $this->od->getMaterials()->where('alias like "' . $this->host . '"');
        $defaultCityMaterial = $this->od->getMaterials()->where('alias like "' . self::DEFAULT_CITY . '"');

        if ($materials->count() > 0) {
            $this->city = $materials[0];
            //var_dump($materials[0]);
        }else if  ($defaultCityMaterial->count()){
            //var_dump($defaultCityMaterial);
            return $this->city = $defaultCityMaterial[0];
        } else{

            echo "foo";
        }


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
