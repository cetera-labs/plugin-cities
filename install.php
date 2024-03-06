<?php

$a = \Cetera\Application::getInstance();

$conn = $a->getConn();

$r = $conn->fetchColumn("select count(*) from cities_settings where id = ?", array(1));

if (!$r) {
    $conn->executeQuery(
        'INSERT INTO
				cities_settings (
					  id,
					  default_city,
					  robots_file,
					  sitemap_file,
                      use_sitemap,
                      server_city_key
				)
				VALUES (?,?,?,?,?,?)',
        array(
            1,
            "",
            "",
            "",
            "",
            "HTTP_CITY_NAME"
        )
    );
}