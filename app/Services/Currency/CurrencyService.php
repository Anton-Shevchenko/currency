<?php

declare(strict_types=1);

namespace App\Services\Currency;

use App\Managers\RedisKeyManager as KeyManager;
use App\Services\Cache\CacheInterface;
use App\Services\ThirdParties\Currency\CurrencyServiceInterface;

class CurrencyService
{
    private const DEFAULT_LENGTH = 10;
    private const PREFIX_TREND = 'trend';
    private const ACCURACY = 7;
    private const DEFAULT_TTL = 600;
    private const SIGN_DOWN = '↓';
    private const SIGN_UP = '↑';
    private const SIGN_EQUAL = '-';

    public function __construct(
        private CurrencyServiceInterface $currencyService,
        private CacheInterface $cache
    ) {}

    public function getCurrencyWithTrend(string $fromISO, string $toISO): ?string
    {
        $key = KeyManager::getCurrencyKey($fromISO, $toISO);
        $data = $this->cache::get($key);

        if ($data) {
            return $data;
        }

        $avgValue = $this->getTrendAvgByKey(KeyManager::getKeyWithPrefix($key, self::PREFIX_TREND));
        $currency = $this->currencyService->getCurrency($fromISO, $toISO);

        if (!$currency) {
            return null;
        }

        $data = sprintf(
            "%s%s",
            $currency,
            $avgValue ? " {$this->getSignByTrend($currency, $avgValue)}" : null
        );

        $this->cache::set($key, $data, self::DEFAULT_TTL);
        $this->setToTrend($key, $currency);

        return $data;
    }

    private function setToTrend($key, $value): void
    {
        $trendKey = KeyManager::getKeyWithPrefix($key, self::PREFIX_TREND);
        $this->cache::lpush($trendKey, $value);
        $this->cache::ltrim($trendKey, 0, self::DEFAULT_LENGTH);
    }

    private function getSignByTrend(float $from, float $to): string
    {
        $diff = round($from, self::ACCURACY) - round($to, self::ACCURACY);

        return $diff > 0 ? self::SIGN_UP : (($diff < 0 ? self::SIGN_DOWN : self::SIGN_EQUAL));
    }

    private function getTrendAvgByKey($key): float
    {
        $trendValues = $this->cache->lrange(
            $key,
            0,
            self::DEFAULT_LENGTH
        );

        return (float) $trendValues ? array_sum($trendValues) / count($trendValues) : 0;
    }
}
