<?php

namespace Cities\Accessory;

/**
 *
 */

/**
 * @todo add cache for this
 * class Init
 */
class Init
{
    /**
     * @param \Twig_Environment $twig
     * @return void
     */
    public static function init(\Twig_Environment $twig)
    {
        /**
         * @todo add cache for this
         */

        self::initGlobalVariables();
        self::setTwigGlobals($twig);
    }

    /**
     *
     */
    protected static function initGlobalVariables()
    {
        global $currentCity;
        global $currentCityAlias;
        global $currentCityPR;
        global $currentPhone;
        global $currentEmail;
        global $currentAddres;
        global $currentAddresNoCity;
        global $currentOblastBool;
        global $currentOsnovaBool;
        global $currentCityRP;


        if (isset($currentCity, $currentCityAlias)) {
            return;
        }

        /**
         * @var $city \Cities\Reason\City
         */
        $cityObject = new \Cities\Reason\City();
        $city = $cityObject->getCityMaterial();

        if (!$city instanceof \Cetera\Material) {
            return;
        }

        $fields = $city->fields;

        $currentCity = $fields['name'];
        $currentCityAlias = $cityObject->cityAlias;
        $currentCityPR = $fields['city_pr'];
        $currentPhone = $fields['phone'];
        $currentEmail = $fields['email'];
        $currentAddres = $fields['addres'];
        $currentAddresNoCity = $fields['addres'];
        $currentOblastBool = (bool)$fields['oblast'];
        $currentOsnovaBool = (bool)$fields['osnova'];
        $currentCityRP = $fields['city_rp'];
    }

    /**
     * @param \Twig_Environment $twig
     * @return void
     */
    public static function setTwigGlobals(\Twig_Environment $twig)
    {
        global $currentCity;
        global $currentCityAlias;
        global $currentCityPR;
        global $currentPhone;
        global $currentEmail;
        global $currentAddres;
        global $currentAddresNoCity;
        global $currentOblastBool;
        global $currentOsnovaBool;
        global $currentCityRP;


        $twig->addGlobal('currentCity', $currentCity);
        $twig->addGlobal('currentCityAlias', $currentCityAlias);
        $twig->addGlobal('currentCityPR', $currentCityPR);
        $twig->addGlobal('currentPhone', $currentPhone);
        $twig->addGlobal('currentEmail', $currentEmail);
        $twig->addGlobal('currentAddres', $currentAddres);
        $twig->addGlobal('currentAddresNoCity', $currentAddresNoCity);
        $twig->addGlobal('currentOblastBool', $currentOblastBool);
        $twig->addGlobal('currentOsnovaBool', $currentOsnovaBool);
        $twig->addGlobal('currentCityRP', $currentCityRP);

    }
}
