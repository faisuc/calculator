<?php

use App\Models\TickerTape;
use Illuminate\Http\Response;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;

it('will return the lists of the ticker tape based on ip address', function () {
    $tickerTape = TickerTape::factory()->count(10)->create(['visitor' => request()->ip()]);

    $response = getJson('/api/ticker_tapes');
    
    expect($response->json('data'))->toHaveCount(10);
});

it('can individually delete ticker tape', function () {
    $tickerTape = TickerTape::factory()->create(['visitor' => request()->ip()]);

    $response = deleteJson('/api/ticker_tapes/' . $tickerTape->id);

    $response->assertStatus(Response::HTTP_NO_CONTENT);

    assertDatabaseCount('ticker_tapes', 0);
});

it('can delete all the ticker tapes based on ip address', function () {
    $tickerTapes = TickerTape::factory()->count(5)->create(['visitor' => request()->ip()]);
    $anotherTickerTapes = TickerTape::factory()->count(3)->create(['visitor' => fake()->ipv4()]);

    $response = deleteJson('/api/ticker_tapes/delete-all');

    $response->assertStatus(Response::HTTP_NO_CONTENT);

    assertDatabaseCount('ticker_tapes', 3);
});