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
        return $data;
    }
}
