<?php

namespace MaterialSeo;

class MaterialSeo extends \Cetera\Widget\Material
{
    protected function init()
    {
        parent::init();
        $m = $this->getMaterial();
        if ($this->getParam('show_meta') && $m) {
            if ($m->meta_title)
                $name = $m->meta_title;
            else $name = strip_tags($m->name);

            if ($m->meta_description)
                $short = strip_tags($m->meta_description);
            else $short = strip_tags($m->short);

            $name = str_replace("[местгео]", 'mosk', $name);
            $this->setMetaTitle($name);
            $this->setMetaDescription($short);
            $this->setMetaPicture($m->pic);

            $a = $this->application;

            if ($m->meta_keywords) {
                $a->setPageProperty('keywords', $m->meta_keywords);
            }

        }
    }
}
