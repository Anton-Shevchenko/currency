<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Support\Facades\Redis;

class RedisCache extends Redis implements CacheInterface
{

    /**
     * @param string $string
     * @return void
     */
    public static function del(string $string): int
    {
        return Redis::del($string);
    }

    /**
     * @param string $string
     * @param string $string1
     * @return void
     */
    public static function lpush(string $string, mixed $string1): int
    {
        return Redis::lpush($string, $string1);
    }

    public static function ltrim(string $string, int $int, int $int1): bool
    {
        return Redis::ltrim($string, $int, $int1);
    }

    public static function lrange(string $string, int $int, int $int1): array
    {
        return Redis::lrange($string, $int, $int1);
    }

    public static function get(string $key): mixed
    {
        return Redis::get($key);
    }

    public static function set(string $key, mixed $data, ?int $ttl = null): bool
    {
        return Redis::set($key, $data, 'EX', $ttl);
    }
}
