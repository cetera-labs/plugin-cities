<?php

namespace Cities;

class WidgetLocation extends \Cetera\Widget\Templateable
{
    public static $location;

    protected $_params = array(
        "count" => 16,
        "arrayCities" => '',
        "redirect" => '',
        "template" => 'default.twig',
        "showmodalregion" => ''
    );

    public function init()
    {
        $this->location = new \Cities\Reason\LocationReady($this->getParam('arrayCities'));
        /*$this->location->redirect = $this->getParam('redirect');

        if ($this->location->redirect) {
            $this->location->startRedirect();
        }*/
    }
}
