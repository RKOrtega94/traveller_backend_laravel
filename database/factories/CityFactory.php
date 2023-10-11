<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        State::factory()->count(10)->create();
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->randomLetter() . $this->faker->randomLetter(),
            'is_active' => $this->faker->boolean(),
            'state_id' => State::all()->random()->id,
        ];
    }
}
