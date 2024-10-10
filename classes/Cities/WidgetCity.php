<?php

namespace Cities;

class WidgetCity extends \Cetera\Widget\Templateable
{
    public static $material;

// eslint-disable-next-line
    protected $_params = array(
        'template' => 'default.twig',
    );

    public function init()
    {
        if (sizeof($this->material) == 0) {
            $cObject =  new \Cities\Reason\City();

            $this->material = $cObject->city;
        }
        if (!$this->material) {
            return false;
        }
    }
}
