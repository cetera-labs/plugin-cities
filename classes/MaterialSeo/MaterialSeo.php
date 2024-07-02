<?php

namespace MaterialSeo;

class MaterialSeo extends \Cetera\Material
{

    public function getMeta_title()
    {
        return self::replaceAliasMaterials($this->fields['meta_title']);
    }

    public function getMeta_description()
    {
        return self::replaceAliasMaterials($this->fields['meta_description']);
    }

    public function getMeta_keywords()
    {
        return self::replaceAliasMaterials($this->fields['meta_keywords']);
    }

    public function getName()
    {
        return self::replaceAliasMaterials($this->fields['name']);
    }

    public function getText()
    {
        return self::replaceAliasMaterials($this->fields['text']);
    }

    public function getShort()
    {
        return self::replaceAliasMaterials($this->fields['short']);
    }

    public static function replaceAliasMaterials($data)
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
        if ($currentCity) {
            $data = str_replace("[[имгео]]", $currentCity, $data);
        }
        if ($currentCityPR) {
            $data = str_replace("[[местгео]]", $currentCityPR, $data);
        }
        if ($currentCityRP) {
            $data = str_replace("[[родгео]]", $currentCityRP, $data);
        }
        if ($currentEmail) {
            $data = str_replace("[[email]]", $currentEmail, $data);
        }
        if ($currentPhone) {
            $data = str_replace("[[телефон]]", $currentPhone, $data);
        }
        if ($currentAddres) {
            $data = str_replace("[[адрес]]", $currentAddres, $data);
            $data = str_replace("[[city]]", $currentAddres, $data);
        }
        if ($currentCityAlias) {
            $data = str_replace("[[алиас]]", $currentCityAlias, $data);
            $data = str_replace('href="/', 'href="/'.$currentCityAlias.'/', $data);
        }
        return $data;
    }
}
