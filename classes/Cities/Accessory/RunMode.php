<?php

namespace Cities\Accessory;

final class RunMode
{
    final public static function isLocal(): bool
    {
        return getenv("RUN_MODE") === "development";
    }

    final public static function isProduction(): bool
    {
        return !self::isLocal();
    }
}
