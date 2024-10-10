<?php

namespace Cities\Accessory;

use Pdp\Domain;

class Utility
{
    public static function getDomain()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public static function getDomainAlias($domain = null)
    {
//        if (getenv("RUN_MODE", true) === 'development') {
//            return 'yaroslavl';
//        }

//        $domain = ($domain) ? $domain : $_SERVER['SERVER_NAME'];
//        $cDomain = Domain::fromIDNA2008($domain);
//        $labels = $cDomain->labels();
//
//        var_dump($labels);
//
//
//        if (($key = array_search('www', $labels)) !== false) {
//            unset($labels[$key]);
//        }
//
//        return end($labels);

        $tmpServer = explode('.', $_SERVER['SERVER_NAME']);
        if ($tmpServer[0] === 'www') {
            $NtmpServer = array_slice($tmpServer, intval(1));
            $str = implode(".", $NtmpServer);
        } else {
            $str = implode(".", $tmpServer);
        }

        return explode(".", $str)[0];
    }


    public static function getProtocol()
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            return $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://';
        }

        $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return ($isHttps ? 'https' : 'http') . '://';
    }


    public static function isMainSite($domain = null)
    {
        return Utility::getDomain() == $_SERVER['SERVER_NAME'];
    }


    public static function redirect($link)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $link");
    }
}
