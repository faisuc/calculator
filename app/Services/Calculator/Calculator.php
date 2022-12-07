<?php

namespace App\Services\Calculator;

use Illuminate\Support\Arr;

class Calculator
{
    public static function evaluate(string $expression): string
    {
        return eval("return " . self::parse($expression) . ";");
    }

    public static function fraction($number): string
    {
        return 1 / ($number);
    }

    private static function parse(string $expression): string
    {
        preg_match_all('/(?:\d+)\^(\d)/', $expression, $exponentMatches, PREG_OFFSET_CAPTURE);

        if (count($exponentMatches[0])) {
            foreach ($exponentMatches[0] as $key => $value) {
                [$number, $exponent] = explode('^', $value[0]);
                $posIndex = $value[1];

                $expression = str_replace($value[0], pow($number, $exponent), $expression);
            }
        }

        $expression = str_replace('--', '+', $expression);

        return $expression;
    }
}
