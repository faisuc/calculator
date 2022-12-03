<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TickerTape>
 */
class TickerTapeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $firstNum = rand(1, 10);
        $secondNum = rand(1, 10);
        $expression = $firstNum . '+' . $secondNum;
        
        return [
            'visitor' => $this->faker->ipv4(),
            'expression' => $expression,
            'answer' => $firstNum + $secondNum,
        ];
    }
}
