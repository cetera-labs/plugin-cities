<?php

namespace CitySection;

use Cities\Traits\ReplaceAlias;

class CitySection extends \Cetera\Catalog
{
    use ReplaceAlias;

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
