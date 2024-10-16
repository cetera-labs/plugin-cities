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
        self::setCookie();
        self::final();
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

    protected static function final()
    {

        /**
         * @TODO rewrite and reformat
         */
        return;
        $conn = new mysqli(
            $application->getVar('dbhost'),
            $application->getVar('dbuser'),
            $application->getVar('dbpass'),
            $application->getVar('dbname')
        );

        $sql = "SELECT alias FROM cities";
        $result = $conn->query($sql);

        /* Формируем url */
        $arURL = explode('/', $_SERVER['REQUEST_URI']);
        global $canonicalURL;
        $canonicalURL = $_SERVER['REQUEST_URI'];

        $currentCityAlias = $arURL[1];

        while ($row = $result->fetch_assoc()) {
            if ($arURL[1] == $row["alias"]) {
                $arURL[1] = '';
            }
        }

        $fullPath = '/';
        foreach ($arURL as $path) {
            if ($path) {
                $fullPath .= $path . '/';
            }
        }

        if ($fullPath && $fullPath != '/') {
            $_SERVER['REQUEST_URI'] = $fullPath;
        } else {
            $_SERVER['REQUEST_URI'] = '';
        }

        /* Формируем alias */
        $sql = "SELECT name, alias, city_pr, addres, phone, email, osnova, oblast, city_rp FROM cities WHERE alias = '" . $currentCityAlias . "'";
        $result = $conn->query($sql);
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
        while ($row = $result->fetch_assoc()) {
            $currentCity = $row["name"];
            $currentCityAlias = $row["alias"];
            $currentCityPR = $row["city_pr"];
            $currentPhone = $row["phone"];
            $currentEmail = $row["email"];
            $currentAddres = $row["addres"];
            $currentAddresNoCity = str_replace($row["name"] . ", ", "", $row["addres"]);
            $currentOblastBool = $row["osnova"];
            $currentOsnovaBool = $row["oblast"];
            $currentCityRP = $row["city_rp"];
        }
        $conn->close();

        if (class_exists('CitySection\CitySection')) {
            \Cetera\Section::extend('CitySection\CitySection');
        }

        if (class_exists('MaterialSeo\MaterialSeo')) {
            \Cetera\Material::extend('MaterialSeo\MaterialSeo');
        }
    }
}
