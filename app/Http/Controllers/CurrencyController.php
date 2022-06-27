<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Services\Currency\CurrencyService;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    private CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index(CurrencyRequest $request): JsonResponse
    {
        return response()->json([
            'result' => $this->currencyService->getCurrencyWithTrend(
                $request->input('from-currency'),
                $request->input('to-currency')
            ),
        ]);
    }
}
