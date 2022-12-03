<?php

use App\Models\TickerTape;
use App\Services\Calculator\Calculator;
use Illuminate\Http\Response;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('will save the expression on the ticker tape', function () {
    $response = postJson('/api/calculator', [
        'expression' => '1+2',
    ]);

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJson([
            'visitor' => request()->ip(),
            'expression' => '1+2',
            'answer' => Calculator::evaluate('1+2'),
        ]);

    assertDatabaseCount('ticker_tapes', 1);
});