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
        self::fillMetas();
        self::extend();
        self::setCookie();
        self::rewrite();
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

    public static function fillMetas()
    {
        global $currentCity;
//        global $currentCityAlias;
        global $currentCityPR;
        global $currentPhone;
        global $currentEmail;
        global $currentAddres;
//        global $currentAddresNoCity;
//        global $currentOblastBool;
//        global $currentOsnovaBool;
        global $currentCityRP;

        $a = \Cetera\Application::getInstance();
        //die();
        // Сервер
        $s = $a->getServer();

// Активный раздел
        $c = $a->getCatalog();


        $title = ($s->meta_title) ? $s->meta_title : $s->name;
        $title = str_replace("[[имгео]]", $currentCity, $title);
        $title = str_replace("[[местгео]]", $currentCityPR, $title);
        $title = str_replace("[[родгео]]", $currentCityRP, $title);
        $title = str_replace("[[email]]", $currentEmail, $title);
        $title = str_replace("[[телефон]]", $currentPhone, $title);
        $title = str_replace("[[адрес]]", $currentAddres, $title);
        $title = str_replace("[[city]]", $currentAddres, $title);
        $a->setPageProperty('title', $title);
        $a->addHeadString('<meta property="og:title" content="' . $title . '">', 'og:title');

        $catCpy = $c;
        while (!$a->getPageProperty('keywords') && !$catCpy->isRoot()) {
            $metaKeywords = str_replace("[[имгео]]", $currentCity, $catCpy->meta_keywords);
            $metaKeywords = str_replace("[[местгео]]", $currentCityPR, $metaKeywords);
            $metaKeywords = str_replace("[[родгео]]", $currentCityRP, $metaKeywords);
            $metaKeywords = str_replace("[[email]]", $currentEmail, $metaKeywords);
            $metaKeywords = str_replace("[[телефон]]", $currentPhone, $metaKeywords);
            $metaKeywords = str_replace("[[адрес]]", $currentAddres, $metaKeywords);
            $metaKeywords = str_replace("[[city]]", $currentAddres, $metaKeywords);
            $a->setPageProperty('keywords', $metaKeywords);
            $catCpy = $catCpy->getParent();
        }

        $catCpy = $c;
        while (!$a->getPageProperty('description') && !$catCpy->isRoot()) {
            $metaDescription = str_replace("[[имгео]]", $currentCity, $catCpy->meta_description);
            $metaDescription = str_replace("[[местгео]]", $currentCityPR, $metaDescription);
            $metaDescription = str_replace("[[родгео]]", $currentCityRP, $metaDescription);
            $metaDescription = str_replace("[[email]]", $currentEmail, $metaDescription);
            $metaDescription = str_replace("[[телефон]]", $currentPhone, $metaDescription);
            $metaDescription = str_replace("[[адрес]]", $currentAddres, $metaDescription);
            $metaDescription = str_replace("[[city]]", $currentAddres, $metaDescription);
            $a->setPageProperty('description', $metaDescription);
            $a->addHeadString('<meta property="og:description" content="' .
                htmlspecialchars($metaDescription) . '">', 'og:description');
            $catCpy = $catCpy->getParent();
        }
    }

    protected static function setCookie()
    {
        /**
         * @todo implement here
         */
    }

    protected static function extend()
    {
        if (class_exists('CitySection\CitySection')) {
            \Cetera\Section::extend('CitySection\CitySection');
        }

        if (class_exists('MaterialSeo\MaterialSeo')) {
            \Cetera\Material::extend('MaterialSeo\MaterialSeo');
        }
    }

    /** todo disable if admin page*/

    protected static function rewrite()
    {
        if (Utility::isRewriteNeeded()) {
            $a = \Cetera\Application::getInstance();
            $a->setRequestUri(Utility::getRealURI());
        }
    }
}
