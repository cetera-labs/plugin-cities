<?php

namespace CitySection;

class CitySection extends \Cetera\Section
{
    public function getPath()
    {
        parent::getPath();
        if (!$this->_path) {
            $this->_path = new Iterator\Catalog\Path($this);
        }
        return $this->_path;
    }
}
