<?php

use App\Http\Controllers\Api\CalculatorController;
use App\Http\Controllers\Api\TickerTapeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('calculator', CalculatorController::class);

Route::delete('ticker_tapes/delete-all', [TickerTapeController::class, 'destroyAll']);
Route::apiResource('ticker_tapes', TickerTapeController::class);