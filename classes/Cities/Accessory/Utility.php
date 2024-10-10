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
        $domain = ($domain) ? $domain : $_SERVER['SERVER_NAME'];
        $parsed = parse_url($domain);
        $host = $parsed['host'] ?? $parsed['path'];

        if (strpos($host, 'www.') === 0) {
            $host = substr($host, 4);
        }
        $exploded = explode('.', $host);

        if (count($exploded) > 2) {
            return $exploded[0];
        }

        return false; // TODO: Implement
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
