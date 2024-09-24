<?php

namespace Cities\Reason;

use \Cities\Accessory\Utility;

Class LocationReady
{

    const  MATERIAL_TYPE = 'cities';

    public static $city;

    public static $cityInstance;

    protected $_cities;

    public $arrayCities;

    public $redirect;


    public function __construct($arrayCities = [])
    {

        $this->cityInstance = new  \Cities\Reason\City();
        $this->city = $this->cityInstance->city;
        if (is_string($arrayCities)) {
            $arrayCitiesAlso = explode(',', $arrayCities);
        } else {
            $arrayCitiesAlso = $arrayCities;
        }

        $this->cities = $this->cityInstance->getCities($arrayCitiesAlso);

    }

    public function startRedirect()
    {

    }

    public function isIp()
    {
        return array_key_exists($this->cityInstance->settings->fields['server_city_key'], $_SERVER) && isset($_SERVER[$this->cityInstance->settings->fields['server_city_key']]);

    }


}
