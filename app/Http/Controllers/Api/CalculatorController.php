<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TickerTape;
use App\Services\Calculator\Calculator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CalculatorController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $tickerTape = [
                'visitor' => $request->ip(),
                'expression' => $expression = $request->expression,
                'answer' => Calculator::evaluate($expression),
            ];

            $data = TickerTape::create($tickerTape);

            return response()->json($data->toArray(), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }
}
