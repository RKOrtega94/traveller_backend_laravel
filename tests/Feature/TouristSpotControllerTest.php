<?php

namespace Tests\Feature;

use App\Models\TouristSpot;
use Database\Factories\TouristSpotFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TouristSpotControllerTest extends TestCase
{
    use RefreshDatabase;
    function test_get_all_tourist_spot(): void
    {
        // Create a 100 tourist spots
        TouristSpot::factory()->count(100)->create();

        $response = $this->getJson('/api/tourist-spots');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'address',
                            'latitude',
                            'longitude',
                            'created_at',
                            'updated_at',
                            'location' => [
                                'id',
                                'name',
                                'code',
                                'city' => [
                                    'name',
                                    'code',
                                    'flag',
                                    'state' => [
                                        'name',
                                        'code',
                                        'flag',
                                        'country' => [
                                            'name',
                                            'code',
                                            'phone_code',
                                            'flag'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'current_page',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total'
                ]
            ]);
    }

    function test_get_tourist_spot_by_id(): void
    {
        TouristSpotFactory::new()->count(100)->create();

        $response = $this->getJson('/api/tourist-spots/' . TouristSpot::first()->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'address',
                    'latitude',
                    'longitude',
                    'created_at',
                    'updated_at',
                    'location' => [
                        'id',
                        'name',
                        'code',
                        'city' => [
                            'name',
                            'code',
                            'flag',
                            'state' => [
                                'name',
                                'code',
                                'flag',
                                'country' => [
                                    'name',
                                    'code',
                                    'phone_code',
                                    'flag'
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    function test_get_tourist_spot_by_id_not_found(): void
    {
        $response = $this->getJson('/api/tourist-spots/1');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'errors',
                'message',
            ]);
    }
}
