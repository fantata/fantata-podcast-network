<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'         => $this->faker->catchPhrase(),
            'subtitle'      => $this->faker->catchPhrase(),
            'description'   => $this->faker->text(),
            'user_id'       => 2,
            'explicit'      => $this->faker->boolean,
            'category_id'   => rand(1, 6),
            'email'         => $this->faker->email(),
            'status'        => rand(1, 3)
        ];
    }
}
