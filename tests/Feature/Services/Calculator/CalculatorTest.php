<?php

use App\Services\Calculator\Calculator;

it('can calculate basic arithmetic operations', function ($expression) {
    [$operation, $answer] = explode('=', $expression);

    expect(Calculator::evaluate($operation))->toEqual($answer);
})->with([
    '(5.5+5.5)=11',
    '1+5=6',
    '10-7=3',
    '10*10=100',
    '9/3=3',
    '100+20/30*2=101.3333333333',
]);

it('can calculate arithmetic operations that has parenthesis', function ($expression) {
    [$operation, $answer] = explode('=', $expression);

    expect(Calculator::evaluate($operation))->toEqual($answer);
})->with([
    '(1+2)*((14+2)/(2*2))=12',
    '(((9*9)/12)+(13-4))*2)=31.5',
]);

it('can calculate arithmetic operations that has negative numbers', function ($expression) {
    [$operation, $answer] = explode('=', $expression);

    expect(Calculator::evaluate($operation))->toEqual($answer);
})->with([
    '-1+5=4',
    '10--2=8',
    '-10--2=-12',
]);

it('can calculate the fraction of the number', function ($expression) {
    [$number, $answer] = explode('=', $expression);

    expect(Calculator::fraction($number))->toEqual($answer);
})->with([
    '8=0.125',
    '899=0.0011123470522803',
]);