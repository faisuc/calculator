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
    '(((9*9)/12)+(13-4))*2=31.5',
]);

it('can calculate arithmetic operations that has negative numbers', function ($expression) {
    [$operation, $answer] = explode('=', $expression);

    expect(Calculator::evaluate($operation))->toEqual($answer);
})->with([
    '-1+5=4',
    '10--2=12',
    '-10--2=-8',
]);

it('can calculate the fraction of the number', function ($expression) {
    [$number, $answer] = explode('=', $expression);

    expect(Calculator::fraction($number))->toEqual($answer);
})->with([
    '8=0.125',
    '899=0.0011123470522803',
]);

it('can calculate sqrt operations', function ($expression) {
    [$operation, $answer] = explode('=', $expression);

    expect(Calculator::evaluate($operation))->toEqual($answer);
})->with([
    'sqrt(((((9*9)/12)+(13-4))*2)^2)=31.5',
    'sqrt(2^3*3^2+2+2+3*4)=9.3808315196',
    'sqrt(9)=3'
]);

it('can calculate exponential operations', function ($expression) {
    [$operation, $answer] = explode('=', $expression);

    expect(Calculator::evaluate($operation))->toEqual($answer);
})->with([
    '(3^3)+(2^4)=43',
    '5.6124860801609^2=31.5',
    '(2+2)^2=16',
]);

it('will throw an exception if the expression is invalid', function ($expression) {
    [$operation, $answer] = explode('=', $expression);

    expect(Calculator::evaluate($operation))->toEqual($answer);
})->with([
    'test(3*3)=9',
    'exec(2+2)=4',
])->throws(Exception::class);