<?php

$application = \Cetera\Application::getInstance();

$t = $this->getTranslator();

$twig = $application->getTwig();

$t->addTranslation(__DIR__ . '/lang');

$this->registerWidget(array(
    'name' => 'cities',
    'class' => '\\Cities\\WidgetCity',
    'describ' => $t->_('Города'),
    'icon' => 'city.png',
    'ui' => 'Plugin.cities.Widget',
));

$this->registerWidget(array(
    'name' => 'cities.location',
    'class' => '\\Cities\\WidgetLocation',
    'describ' => $t->_('Определение города'),
    'icon' => 'location.png',
    'ui' => 'Plugin.cities.WidgetLocation',
));

$this->registerWidget(array(
    'name' => 'cities.menu.user',
    'class' => '\\Cities\\MenuUserSeo',
    'describ' => $t->_('Пользовательское SEO меню'),
    'icon' => 'city.png',
    'ui' => 'Plugin.cities.Widget',
));


if ($this->getBo() && $this->getUser() && $this->getUser()->isAdmin()) {
    $this->getBo()->addModule(array(
        'id' => 'cities',
        'position' => MENU_SITE,
        'name' => $t->_('Города'),
        'icon' => 'city.png',
        'class' => 'Plugin.cities.Panel'
    ));
}


try {
    \Cities\Accessory\Init::init($twig);
} catch (Exception $e) {
}


$material = new \Cities\Reason\City();

if (!empty($material->settings->fields['robots_file'])) {

    $application->route('/robots.txt', function () use ($material) {

        $robotsText = $material->settings->fields['robots_file'];

        $result = str_replace('[link]', $material->city->link, trim($robotsText, "\n"));


        header('Content-type: text/plain');

        echo $result;

        return true;

    });
}
if (!empty($material->settings->fields['sitemap_file']) && $material->settings->isUseSitemap()) {

    $application->route('/sitemap.xml', function () use ($material) {

        $sitemap = $material->settings->fields['sitemap_file'];

        $result = str_replace('[link]', $material->city->link, trim($sitemap, "\n"));

        header("Content-type: text/xml");

        echo $result;

        return true;


    });
}
