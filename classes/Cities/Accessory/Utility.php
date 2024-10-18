<?php

namespace Cities\Accessory;

use Cetera\Iterator\Material;
use Cities\Reason\City;

class Utility
{
    public static function getDomain(): string
    {
        return RunMode::isProduction() ? $_SERVER['SERVER_NAME'] : $_SERVER['SERVER_NAME'] . ":8080";
    }

    public static function getDomainAlias($domain = null): string
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


    public static function getProtocol(): string
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            return $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://';
        }

        $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return ($isHttps ? 'https' : 'http') . '://';
    }


    public static function isMainSite($domain = null): bool
    {
        return Utility::getBaseDomain() === $_SERVER['SERVER_NAME'];
    }


    public static function redirect($link): void
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $link");
    }

    public static function getBaseDomain(): string
    {
        $base = parse_url($_SERVER['SERVER_NAME'])['host'] ?? $_SERVER['SERVER_NAME'];
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:[a-z0-9-]+\.)*([a-z0-9-]+\.[a-z]{2,})/i';
        $domainMatches = [];
        $isLocal = RunMode::isLocal();
        if (preg_match_all($pattern, $base, $domainMatches) && count($domainMatches) > 1) {
            try {
                $match =  array_shift($domainMatches[1]);
                if ($isLocal) {
                    return $match . ":8080";
                }
                return $match;
            } catch (\Exception $e) {
                if ($isLocal) {
                    return $base . ":8080";
                }
                return $base;
            }
        }

        if ($isLocal) {
            return $base . ":8080";
        }
        return $base;
    }

    /**
     * @return bool|string
     */
    public static function getGeoAlias(): bool|string
    {

        $uri = $_SERVER['DOCUMENT_URI'];
        $split = array_filter(explode('/', $uri), static function ($v) {
            return !empty($v);
        });
        if (!count($split)) {
            return false;
        }
        try {
            $potentialGeoValue = $split[array_key_first($split)];

            /**
             * @var $materials Material
             */
            $materials = City::findByAlias($potentialGeoValue);
            return $materials->count() === 1 ? $potentialGeoValue : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function isRewriteNeeded(): bool
    {
        return self::getGeoAlias() !== false;
    }

    public static function getRealURI(): string
    {
        if (self::isMainSite() && !self::getDomainAlias()) {
            return $_SERVER['DOCUMENT_URI'];
        }

        return str_replace("/" . self::getGeoAlias(), "", $_SERVER['DOCUMENT_URI']);
    }
}
