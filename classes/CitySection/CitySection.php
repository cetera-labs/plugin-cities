<?php

namespace CitySection;

class CitySection extends \Cetera\Section
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
