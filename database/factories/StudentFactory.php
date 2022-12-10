<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'age' => fake()->numberBetween(),
            'gender' => fake()->randomElement([
                "M",
                "F",
            ]),

        ];
    }
}
