<?php

declare(strict_types=1);

namespace App\Managers;

class RedisKeyManager
{
    private const DELIMITER = ':';

    public static function getCurrencyKey(string $fromISO, string $toISO): string
    {
        return sprintf("3%s%s%s", $fromISO, self::DELIMITER, $toISO);
    }

    public static function getKeyWithPrefix(string $key, string $prefix): string
    {
        return sprintf("3%s%s%s", $prefix, self::DELIMITER, $key);
    }
}
