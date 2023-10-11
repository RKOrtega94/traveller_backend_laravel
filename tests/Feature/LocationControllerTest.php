<?php

namespace Tests\Feature;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;
    function test_get_all_locations(): void
    {
        Location::factory()->count(10)->create();

        $response = $this->getJson('/api/locations');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'code',
                        'is_active',
                        'city' => [
                            'name',
                            'code',
                            'flag',
                            'is_active',
                            'state' => [
                                'name',
                                'code',
                                'flag',
                                'is_active',
                                'country' => [
                                    'name',
                                    'code',
                                    'phone_code',
                                    'flag',
                                    'is_active'
                                ]
                            ],
                        ],
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

    function test_get_all_locations_with_search(): void
    {
        Location::factory()->count(10)->create();

        $randomLocation = Location::inRandomOrder()->first();

        $response = $this->getJson("/api/locations?search=$randomLocation->name");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'code',
                        'is_active',
                        'city' => [
                            'name',
                            'code',
                            'flag',
                            'is_active',
                            'state' => [
                                'name',
                                'code',
                                'flag',
                                'is_active',
                                'country' => [
                                    'name',
                                    'code',
                                    'phone_code',
                                    'flag',
                                    'is_active'
                                ]
                            ],
                        ],
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

    function test_get_all_locations_by_city(): void
    {
        Location::factory()->count(10)->create();

        $city = Location::inRandomOrder()->first()->city;

        $response = $this->getJson("/api/locations?city_id=$city->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'code',
                        'is_active',
                        'city' => [
                            'name',
                            'code',
                            'flag',
                            'is_active',
                            'state' => [
                                'name',
                                'code',
                                'flag',
                                'is_active',
                                'country' => [
                                    'name',
                                    'code',
                                    'phone_code',
                                    'flag',
                                    'is_active'
                                ]
                            ],
                        ],
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

    function test_get_all_locations_by_city_and_search(): void
    {
        Location::factory()->count(10)->create();

        $city = Location::inRandomOrder()->first()->city;

        $randomLocation = Location::inRandomOrder()->first();

        $response = $this->getJson("/api/locations?city_id=$city->id&search=$randomLocation->name");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'code',
                        'is_active',
                        'city' => [
                            'name',
                            'code',
                            'flag',
                            'is_active',
                            'state' => [
                                'name',
                                'code',
                                'flag',
                                'is_active',
                                'country' => [
                                    'name',
                                    'code',
                                    'phone_code',
                                    'flag',
                                    'is_active'
                                ]
                            ],
                        ],
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

    function test_get_all_locations_by_state(): void
    {
        Location::factory()->count(10)->create();

        $state = Location::inRandomOrder()->first()->city->state;

        $response = $this->getJson("/api/locations?state_id=$state->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'code',
                        'is_active',
                        'city' => [
                            'name',
                            'code',
                            'flag',
                            'is_active',
                            'state' => [
                                'name',
                                'code',
                                'flag',
                                'is_active',
                                'country' => [
                                    'name',
                                    'code',
                                    'phone_code',
                                    'flag',
                                    'is_active'
                                ]
                            ],
                        ],
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
}
