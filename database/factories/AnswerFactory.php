<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'body' => $this->faker->paragraphs(rand(3, 7), true),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
