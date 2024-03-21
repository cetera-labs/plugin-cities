<?php

namespace CitySection;

class CitySection extends \Cetera\Catalog
{
    public function getUrl()
    {
        global $currentCityAlias;
        if ($currentCityAlias != '') {
            $alias = '/' . $currentCityAlias;
            return $alias . parent::getUrl();
        } else {
            return parent::getUrl();
        }
    }

    public function getMeta_title() {
        return self::replaceAliasSection($this->fields['meta_title']);
    }

    public function getMeta_description() {
        return self::replaceAliasSection($this->fields['meta_description']);
    }

    public function getMeta_keywords() {
        return self::replaceAliasSection($this->fields['meta_keywords']);
    }

    public static function replaceAliasSection($data) {
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
        $data = str_replace("[[имгео]]", $currentCity, $data);
        $data = str_replace("[[местгео]]", $currentCityPR, $data);
        $data = str_replace("[[родгео]]", $currentCityRP, $data);
        $data = str_replace("[[email]]", $currentEmail, $data);
        $data = str_replace("[[телефон]]", $currentPhone, $data);
        $data = str_replace("[[адрес]]", $currentAddres, $data);
        $data = str_replace("[[city]]", $currentAddres, $data);
        return $data;
    }
}
