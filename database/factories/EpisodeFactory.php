<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
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
            'duration'      => $this->faker->time(),
            'explicit'      => $this->faker->boolean,
            'bytes'         => $this->faker->numberBetween(100000, 10000000),
            'status'        => rand(1, 3)
        ];
    }
}
