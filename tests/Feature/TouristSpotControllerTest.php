<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Location;
use App\Models\TouristSpot;
use Database\Factories\TouristSpotFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class TouristSpotControllerTest extends TestCase
{
    use RefreshDatabase;
    function test_get_all_tourist_spot(): void
    {
        // Create a 100 tourist spots
        TouristSpot::factory()->count(10)->create();

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
                                'zip_code',
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
                            ],
                            'categories' => [
                                '*' => [
                                    'name',
                                    'description',
                                    'icon',
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
        TouristSpotFactory::new()->count(10)->create();

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
                        'zip_code',
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
                    ],
                    'categories' => [
                        '*' => [
                            'name',
                            'description',
                            'icon',
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

    function test_create_tourist_spot(): void
    {
        // Create a location
        $location = Location::factory()->create();

        $response = $this->postJson('/api/tourist-spots', [
            'name' => 'Test',
            'description' => 'Test',
            'address' => 'Test',
            'latitude' => 1.0,
            'longitude' => 1.0,
            'location_id' => $location->id,
        ]);

        $response->assertStatus(201)
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
                        'zip_code',
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
                    ],
                    'categories' => [
                        '*' => [
                            'name',
                            'description',
                            'icon',
                        ]
                    ]
                ]
            ]);
    }

    function test_create_tourist_spot_validation_error(): void
    {
        $response = $this->postJson('/api/tourist-spots', [
            'name' => 'Test',
            'description' => 'Test',
            'address' => 'Test',
            'latitude' => 1.0,
            'longitude' => 1.0,
            'location_id' => null,
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'errors',
                'message',
            ]);
    }

    function test_update_tourist_spot(): void
    {
        // Create a location
        $location = Location::factory()->create();

        // Create a tourist spot
        $touristSpot = TouristSpot::factory()->create();

        $response = $this->putJson('/api/tourist-spots/' . $touristSpot->id, [
            'name' => 'Test',
            'description' => 'Test',
            'address' => 'Test',
            'latitude' => 1.0,
            'longitude' => 1.0,
            'location_id' => $location->id,
        ]);

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
                        'zip_code',
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
                    ],
                    'categories' => [
                        '*' => [
                            'name',
                            'description',
                            'icon',
                        ]
                    ]
                ]
            ]);
    }

    function test_update_tourist_spot_with_invalid_data(): void
    {
        // Create a tourist spot
        $touristSpot = TouristSpot::factory()->create();

        $response = $this->putJson('/api/tourist-spots/' . $touristSpot->id, [
            'name' => 'Test',
            'description' => 'Test',
            'address' => 'Test',
            'latitude' => 1.0,
            'longitude' => 1.0,
            'location_id' => null,
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'errors',
                'message',
            ]);
    }

    function test_delete_tourist_spot(): void
    {
        // Create a tourist spot
        $touristSpot = TouristSpot::factory()->create();

        $response = $this->deleteJson('/api/tourist-spots/' . $touristSpot->id);

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
                ]
            ]);
    }

    function test_delete_tourist_spot_not_found(): void
    {
        $response = $this->deleteJson('/api/tourist-spots/1');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'errors',
                'message',
            ]);
    }
}
