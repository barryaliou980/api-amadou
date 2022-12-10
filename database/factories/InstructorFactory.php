<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
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
            'password' => bcrypt('secret'),
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'age' => fake()->numberBetween(1, 90),
            'gender' => fake()->randomElement(['M', 'F']),
        ];
    }
}
