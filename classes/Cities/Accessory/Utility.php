<?php

namespace Cities\Accessory;

use Pdp\Domain;
use Pdp\TopLevelDomains as topLevelDomains;
use Pdp\Suffix;
use Pdp\Rules;

class Utility
{
    public static function getDomain()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public static function getDomainAlias($domain = null)
    {
        $domain = ($domain) ? $domain : $_SERVER['SERVER_NAME'];
        $cDomain = Domain::fromIDNA2008($domain);
        $labels = $cDomain->labels();
        return end($labels);
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
        $domain = ($domain) ? $domain : $_SERVER['SERVER_NAME'];
        $cDomain = Domain::fromIDNA2008($domain);
        $labels = $cDomain->labels();
        return count($labels) < 3;
    }


    public static function redirect($link)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $link");
    }
}
