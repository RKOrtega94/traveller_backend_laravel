<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Country::factory()->create();
        return [
            'name' => $this->faker->name(),
            'code' => 'ab',
            'is_active' => $this->faker->boolean(),
            'country_id' => Country::all()->random()->id,
        ];
    }
}
