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

        $city = new \Cities\Reason\City();
        $currentCity = $city->city->name;
        $currentCityAlias = $city->city->cityAlias;
        $currentCityPR = "";
        $currentPhone = $city->city->phone;
        $currentEmail = $city->city->email;
        $currentAddres = $city->city->addres;
        ;
        $currentAddresNoCity = $city->city->addres;
        $currentOblastBool = "";
        $currentOsnovaBool = "";
        $currentCityRP = "";
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
}
