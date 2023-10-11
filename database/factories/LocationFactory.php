<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        City::factory()->count(10)->create();
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->postcode(),
            'is_active' => $this->faker->boolean(),
            'city_id' => City::all()->random()->id,
        ];
    }
}
