<?php

//hot reload
namespace Cities\Reason;

use Cities\Accessory\Utility;

class LocationReady
{
    public const  MATERIAL_TYPE = 'cities';

    public static $city;

    public static $cityInstance;
    public $arrayCities;
    public $redirect;

    public $cities;

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

    /**
     * @todo probably known
     * @return void
     */
    public function startRedirect()
    {
        if (
            isset($_COOKIE['link']) && $this->redirect &&
            Utility::isMainSite() && $_COOKIE['link'] != $this->city->link
        ) {
            $link = $_COOKIE['link'];

            Utility::redirect($link);
        }

        if ($this->redirect && $this->isIp() && !isset($_COOKIE['link']) && Utility::isMainSite()) {
            if (!isset($_COOKIE['link'])) {
                foreach ($this->cityInstance->getCities() as $key => $value) {
                    if (
                        $this->cityInstance->getCities()[$key]->name
                        == $_SERVER[$this->cityInstance->settings->fields['server_city_key']]
                    ) {
                        $currentCity = $this->cityInstance->getCities()[$key];
                    }
                }
                if (!$currentCity) {
                    $mainDomain = Utility::getDomain();

                    setcookie("link", $this->city->link, time() + 60 * 60 * 24 * 30, '/', $mainDomain);

                    Utility::redirect($mainDomain);
                } else {
                    Utility::redirect($currentCity->fields['link']);
                }
            }
        }
    }

    /**
     * @todo unknown
     * @return bool
     */

    public function isIp()
    {
        return array_key_exists($this->cityInstance->settings->fields['server_city_key'], $_SERVER)
            && isset($_SERVER[$this->cityInstance->settings->fields['server_city_key']]);
    }
}
