<?php

namespace Cities\Accessory;

use Cities\Reason\City;

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

    public static function getBaseDomain()
    {
        $base = parse_url($_SERVER['SERVER_NAME'])['host'] ?? $_SERVER['SERVER_NAME'];
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:[a-z0-9-]+\.)*([a-z0-9-]+\.[a-z]{2,})/i';
        $domainMatches = [];
        if (preg_match_all($pattern, $base, $domainMatches) && count($domainMatches) > 1) {
            try {
                return array_shift($domainMatches[1]);
            } catch (\Exception $e) {
                return $base;
            }
        }

        return $base;
    }

    /**
     * @return bool|string
     */
    public static function getGeoAlias()
    {

        $uri = $_SERVER['DOCUMENT_URI'];
        $splitted = array_filter(explode('/', $uri), static function ($v) {
            return !empty($v);
        });
        if (!count($splitted)) {
            return false;
        }
        try {
            $potentialGeoValue = $splitted[array_key_first($splitted)];
            /**
             * @var $materials \Cetera\Iterator\Material
             */
            $materials = City::findByAlias($potentialGeoValue);
            return $materials->count() === 1 ? $potentialGeoValue : false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
