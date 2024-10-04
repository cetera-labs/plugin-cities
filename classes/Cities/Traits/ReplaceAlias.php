<?php

namespace Cities\Traits;

trait ReplaceAlias
{
    public function getMeta_title()
    {
        return self::replaceAlias($this->fields['meta_title']);
    }

    public function getMeta_description()
    {
        return self::replaceAlias($this->fields['meta_description']);
    }

    public function getMeta_keywords()
    {
        return self::replaceAlias($this->fields['meta_keywords']);
    }

    public static function replaceAlias($data)
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
            $data = str_replace("[[?????]]", $currentCity, $data);
        }
        if ($currentCityPR) {
            $data = str_replace("[[???????]]", $currentCityPR, $data);
        }
        if ($currentCityRP) {
            $data = str_replace("[[??????]]", $currentCityRP, $data);
        }
        if ($currentEmail) {
            $data = str_replace("[[email]]", $currentEmail, $data);
        }
        if ($currentPhone) {
            $data = str_replace("[[???????]]", $currentPhone, $data);
        }
        if ($currentAddres) {
            $data = str_replace("[[?????]]", $currentAddres, $data);
            $data = str_replace("[[city]]", $currentAddres, $data);
        }
        return $data;
    }
}
