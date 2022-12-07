<?php

namespace App\Services\Calculator;

use Illuminate\Support\Arr;

class Calculator
{
    public static function evaluate(string $expression): string
    {
        return round(eval("return " . self::parse($expression) . ";"), 10);
    }

    public static function fraction($number): string
    {
        return 1 / ($number);
    }

    private static function parse(string $expression): string
    {
        $expression = str_replace('^', '**', str_replace('--', '+', $expression));

        return $expression;
    }
}
