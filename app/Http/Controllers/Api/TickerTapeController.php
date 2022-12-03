<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TickerTapeResource;
use App\Models\TickerTape;
use Illuminate\Http\Request;

class TickerTapeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return TickerTapeResource::collection(TickerTape::whereVisitor($request->ip())->orderByDesc('id')->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TickerTape $tickerTape)
    {
        $tickerTape->delete();

        return response()->noContent();
    }

    public function destroyAll(Request $request)
    {
        TickerTape::whereVisitor($request->ip())->delete();

        return response()->noContent();
    }
}
