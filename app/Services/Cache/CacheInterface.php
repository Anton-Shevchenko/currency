<?php

declare(strict_types=1);

namespace App\Services\Cache;

interface CacheInterface
{
    public static function del(string $string): int;

    public static function lpush(string $string, mixed $string1): int;

    public static function ltrim(string $string, int $int, int $int1): bool;

    public static function lrange(string $string, int $int, int $int1): array;

    public static function get(string $key): mixed;

    public static function set(string $key, ?float $data, ?int $ttl = null): bool;
}
