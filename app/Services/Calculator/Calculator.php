<?php

namespace App\Services\Calculator;

use Illuminate\Support\Arr;

class Calculator
{
    public static function evaluate(string $expression): string
    {

        $data = array_map(function ($data) {
            return is_numeric($data) ? $data : str_split(preg_replace('/\s+/', '', $data));
        }, preg_split('/((?:[0-9]+,)*[0-9]+(?:\.[0-9]+)?)/', $expression, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE));

        return self::calculate(Arr::flatten($data), 0);
    }

    public static function fraction($number): string
    {
        return 1 / ($number);
    }

    private static function calculate(array $expression, int $index): string
    {
        $stack = [];
        $sign = '+';
        $num = 0;

        for ($i = $index; $i < count($expression); $i++) {
            $c = $expression[$i];

            if ($c >= 0 && is_numeric($c)) {
                $num = $num * 10 + ($c - 0);
            }

            if (! ($c >= 0 && $c <= 9) || $i === count($expression) - 1) {
                if ($c === '(') {
                    $num = self::calculate($expression, $i + 1);
                    $l = 1;
                    $r = 0;

                    for ($j = $i+1; $j < count($expression); $j++) {
                        if ($expression[$j] === ')') {
                            $r++;

                            if ($r === $l) {
                                $i = $j;
                                break;
                            }
                        } elseif ($expression[$j] === '(') {
                            $l++;
                        }
                    }
                }

                $pre = -1;

                switch ($sign) {
                    case '+':
                        $stack[] = $num;
                        break;
                    case '-':
                        $stack[] = $num*-1;
                        break;
                    case '*':
                        $pre = array_pop($stack);
                        $stack[] = $pre * $num;
                        break;
                    case '/':
                        $pre = array_pop($stack);
                        $stack[] = $pre / $num;
                        break;
                }

                $sign = $c;
                $num = 0;

                if ($c === ')') break;
            }
        }

        $answer = 0;

        while (count($stack) > 0) {
            $answer += array_pop($stack);
        }

        return round($answer, 10);
    }
}
