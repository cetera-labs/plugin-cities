<?php

namespace Cities\Accessory;
use Pdp\Domain;
use Pdp\TopLevelDomains;
class Utility
{

    public static function getDomain($domain = null)
    {
        /** @todo implement here*/
    }

    public static function getProtocol()
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            return $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://';
        }

        $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return ($isHttps ? 'https' : 'http') . '://';
    }


    public static function isMainSite()
    {

        return Utility::getDomain() == $_SERVER['SERVER_NAME'];

    }


    public static function redirect($link)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $link");
    }

}


