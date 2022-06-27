<?php

declare(strict_types=1);

namespace App\Services\ThirdParties\Currency;

use Illuminate\Support\Facades\Http;

class APILayerCurrency implements CurrencyServiceInterface
{
    public function getCurrency(string $fromISO, string $toISO): ?float
    {
        try {
            $url = "https://api.apilayer.com/currency_data/convert?from={$fromISO}&to={$toISO}&amount=1" ;
            $response = Http::withHeaders([
                'apikey' => config('app.currency_api_token')
            ])
                ->get($url);

            return json_decode($response->body(), true)['result'] ?? null;
        } catch (\Exception $e) {
            // log
            return null;
        }
    }
}
