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
        preg_match_all('/(?:\d+(\.\d+))\^(\d)/', $expression, $exponentMatches, PREG_OFFSET_CAPTURE);
        preg_match_all('/\(([^\)]+)\)\^(\d)/', $expression, $exponentMatchesWithParenthesis, PREG_OFFSET_CAPTURE);
        preg_match_all('/(?:\d+)\^(\d)/', $expression, $exponentInParanthesisMatches, PREG_OFFSET_CAPTURE);
  
        if (count($exponentMatches[0])) {
            foreach ($exponentMatches[0] as $key => $value) {
                [$number, $exponent] = explode('^', $value[0]);
                
                $expression = str_replace($value[0], pow($number, $exponent), $expression);
            }
        }
        
        if (count($exponentInParanthesisMatches[0])) {
            foreach ($exponentInParanthesisMatches[0] as $key => $value) {
                [$number, $exponent] = explode('^', $value[0]);
                
                $expression = str_replace($value[0], pow($number, $exponent), $expression);
            }
        }
        
        if (count($exponentMatchesWithParenthesis[0])) {
            foreach ($exponentMatchesWithParenthesis[0] as $key => $value) {
                [$number, $exponent] = explode('^', $value[0]);

                $expression = str_replace($value[0], pow(eval('return ' . $number . ';'), $exponent), $expression);
            }
        }

        $expression = str_replace('--', '+', $expression);

        return $expression;
    }
}
