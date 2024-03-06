<?php

$application->connectDb();
$application->initSession();
$application->initPlugins();

$res = array(
    "success" => false,
);

if (isset($_REQUEST["action"]))
    $action = $_REQUEST["action"];

$city = new \Cities\Reason\City();
$cities = new \Cities\Reason\LocationReady();

try {
    switch ($action) {
        /* Поиск города */
        case "searchCities":
            $rows = [];
            $data = '%' . trim($_REQUEST['data']) . '%';
            $count = (int)trim($_REQUEST['count']);
            $conn = $application->getConn();

            $r = $conn->executeQuery("SELECT * FROM `cities` WHERE `name` like ?  order by `name` asc LIMIT {$count}", array($data));
            foreach ($r as $f) {
                $f['link'] = \Cities\Accessory\Utility::getProtocol() . $f['alias'] . '.' . \Cities\Accessory\Utility::getDomain();
                $rows[] = $f;
            }
            if (sizeof($rows) != 0) {
                $res['success'] = true;
                $res['rows'] = $rows;
            }
            break;

        /* Проверка на заголовки ip и главный сайт */
        case "checkIp":
            $checkIp = $cities->isIp();
            if ($checkIp && !isset($_COOKIE['link']) && \Cities\Accessory\Utility::isMainSite()) {
                $res['success'] = true;
            }

            break;
        /* Нажатие на кнопку 'да'. Сохранение текущего города посетителя */
        case "saveCity":
            setcookie("link", $cities->city->link, time() + 60 * 60 * 24 * 30, '/', \Cities\Accessory\Utility::getDomain());
            $res['success'] = true;
            break;
        /* Нажатие на ссылку города. Установка города посетителя */
        case "setCity":
            $data = $_REQUEST['link'];
            setcookie("link", $data, time() + 60 * 60 * 24 * 30, '/', \Cities\Accessory\Utility::getDomain());
            $res['success'] = true;
            break;
        /* Сохранение robots.txt */
        case "setRobots":
            $robots = $_REQUEST['robots_file'];

            $city->settings->setFields('robots_file', $robots);
            $res['success'] = true;;
            break;
        /* Сохранение sitemap.xml */
        case "setSitemap" :
            $sitemap = $_REQUEST['sitemap_file'];
            $city->settings->setFields('sitemap_file', $sitemap);
            $res['success'] = true;
            break;

        /* Сохранение  настроек*/
        case "saveFields" :
            $fields = $city->settings->fields;

            foreach ($_REQUEST as $field => $value) {
                if (array_key_exists($field, $fields)) {
                    $city->settings->setFields($field, $value);
                }
            }
            $res['success'] = true;
            break;
        /*  Подгрузка настроек  */
        case "getFiles":

            $fields = $city->settings->fields;

            foreach ($fields as $field => $value) {
                $res[$field] = $value;
            }
            $res['res'] = true;
            break;

        default:
            throw new \Exception("Error Processing Request");
            break;
    }
} catch (\Exeption $e) {
    $res["errors"] = $e->getMessage();
}

echo json_encode($res);

