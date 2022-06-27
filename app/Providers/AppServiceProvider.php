<?php

namespace App\Providers;

use App\Services\Cache\CacheInterface;
use App\Services\Cache\RedisCache;
use App\Services\ThirdParties\Currency\APILayerCurrency;
use App\Services\ThirdParties\Currency\CurrencyServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurrencyServiceInterface::class, APILayerCurrency::class);
        $this->app->bind(CacheInterface::class, RedisCache::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
