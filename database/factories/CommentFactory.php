<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $counter = $this->faker->numberBetween(1, 7);
        $description = '';
        for ($i = 2; $i <= $counter; $i++) {
            $description .= $this->faker->realText() . "\r\n";
        }
        return [
            'user_id' => $this->faker->numberBetween(1, 5),
            'text' => $this->faker->realText(),
            'commentable_id' => $this->faker->numberBetween(1, 100),
            'commentable_type' => 'App\Models\Post',
        ];
    }
}
