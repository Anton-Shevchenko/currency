<?php

namespace App\Services\ThirdParties\Currency;

interface CurrencyServiceInterface
{
    public function getCurrency(string $fromISO, string $toISO): ?float;
}
