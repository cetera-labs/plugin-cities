<?php

namespace Cities\Accessory;

class Utility
{

    public static function getDomain($sub = false)
    {
        $tmpServer = explode('.', $_SERVER['SERVER_NAME']);

        if ($tmpServer[0] === 'www') {
            $NtmpServer = array_slice($tmpServer, intval(1));
            $str = implode(".", $NtmpServer);
        } else {
            $str = implode(".", $tmpServer);
        }
        return $str;
    }

    public static function getProtocol()
    {
        return 'http://';
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


