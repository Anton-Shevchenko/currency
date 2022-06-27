<?php

namespace Tests\Feature;

use App\Managers\RedisKeyManager;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class CurrencyControllerTest extends TestCase
{
    public function testSuccessful()
    {
        Redis::shouldReceive('get')
            ->once()
            ->with(RedisKeyManager::getCurrencyKey('USD', 'UAH'))
            ->andReturn("1 -");
        $response = $this->postJson('/api/currency', ['from-currency' => 'USD', 'to-currency' => 'UAH']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => "1 -",
            ]);
    }

    public function testFailValidation()
    {
        $response = $this->postJson('/api/currency', ['to-currency' => 'UAH']);

        $response->assertInvalid([
            "from-currency" => "The from-currency field is required."
        ]);
    }
}
