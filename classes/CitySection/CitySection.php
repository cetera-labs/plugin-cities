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
}
