<?php

namespace Cities;

class WidgetCity extends \Cetera\Widget\Templateable
{


    public static $material;

    protected $_params = array(
        'template' => 'default.twig',
    );

    public function init()
    {
        if (sizeof($this->material) == 0) {
            $city = new \Cities\Reason\City();
            $this->material = $city->city;
        }
        if (!$this->material) return false;
    }

}
