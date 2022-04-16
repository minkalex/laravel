<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $counter = $this->faker->numberBetween(2, 5);
        $description = '';
        for ($i = 2; $i <= $counter; $i++) {
            $description .= $this->faker->realText() . "\r\n";
        }
        return [
            'user_id' => $this->faker->numberBetween(1, 5),
            'title' => $this->faker->realTextBetween(50, 100, 2),
            'description' => $description,
        ];
    }
}
