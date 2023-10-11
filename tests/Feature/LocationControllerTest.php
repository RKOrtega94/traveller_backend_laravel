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
                        'zip_code',
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
                        'zip_code',
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
                        'zip_code',
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
                        'zip_code',
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
                        'zip_code',
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

    function test_get_all_locations_by_city_and_state(): void
    {
        Location::factory()->count(10)->create();

        $city = Location::inRandomOrder()->first()->city;
        $state = $city->state;

        $response = $this->getJson("/api/locations?city_id=$city->id&state_id=$state->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'zip_code',
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

    function test_get_all_locations_by_city_and_state_and_country(): void
    {
        Location::factory()->count(10)->create();

        $city = Location::inRandomOrder()->first()->city;

        $state = $city->state;

        $country = $state->country;

        $response = $this->getJson("/api/locations?city_id=$city->id&state_id=$state->id&country_id=$country->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'zip_code',
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

    function test_get_all_locations_by_state_and_country(): void
    {
        Location::factory()->count(10)->create();

        $state = Location::inRandomOrder()->first()->city->state;

        $country = $state->country;

        $response = $this->getJson("/api/locations?state_id=$state->id&country_id=$country->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'zip_code',
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

    function test_get_all_locations_by_city_nexists_and_state_and_country(): void
    {
        Location::factory()->count(10)->create();

        $state = Location::inRandomOrder()->first()->city->state;

        $country = $state->country;

        $response = $this->getJson("/api/locations?city_id=9999&state_id=$state->id&country_id=$country->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'data' => []
            ]
        ]);
    }

    function test_create_location(): void
    {
        $location = Location::factory()->make();

        $response = $this->postJson('/api/locations', [
            'name' => $location->name,
            'zip_code' => $location->zip_code,
            'is_active' => $location->is_active,
            'city_id' => $location->city_id
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'zip_code',
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
        ]);
    }

    function test_create_location_with_invalid_data(): void
    {
        $response = $this->postJson('/api/locations', [
            'name' => '',
            'zip_code' => '',
            'is_active' => '',
            'city_id' => ''
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            'errors',
            'message'
        ]);
    }

    function test_create_location_with_invalid_nexists_city(): void
    {
        $response = $this->postJson('/api/locations', [
            'name' => 'Test',
            'zip_code' => '123456',
            'is_active' => true,
            'city_id' => 9999
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            'errors',
            'message'
        ]);
    }

    function test_get_location_by_id(): void
    {
        Location::factory()->count(10)->create();

        $location = Location::inRandomOrder()->first();

        $response = $this->getJson("/api/locations/$location->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'zip_code',
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
        ]);
    }

    function test_get_location_by_id_not_found(): void
    {
        $response = $this->getJson('/api/locations/9999');

        $response->assertStatus(404)->assertJsonStructure([
            'errors',
            'message'
        ]);
    }

    function test_update_location(): void
    {
        Location::factory()->count(10)->create();

        $location = Location::inRandomOrder()->first();

        $response = $this->putJson("/api/locations/$location->id", [
            'name' => 'Test',
            'zip_code' => '123456',
            'is_active' => true,
            'city_id' => $location->city_id
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'zip_code',
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
        ]);
    }

    function test_update_not_found(): void
    {
        $response = $this->putJson('/api/locations/9999', [
            'name' => 'Test',
            'zip_code' => '123456',
            'is_active' => true,
            'city_id' => 1
        ]);

        $response->assertStatus(404)->assertJsonStructure([
            'errors',
            'message'
        ]);
    }

    function test_update_with_invalid_data(): void
    {
        Location::factory()->count(10)->create();

        $location = Location::inRandomOrder()->first();

        $response = $this->putJson("/api/locations/$location->id", [
            'name' => '',
            'zip_code' => '',
            'is_active' => '',
            'city_id' => ''
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            'errors',
            'message'
        ]);
    }

    function test_delete(): void
    {
        Location::factory()->count(10)->create();

        $location = Location::inRandomOrder()->first();

        $response = $this->deleteJson("/api/locations/$location->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'zip_code',
                'is_active',
            ]
        ]);
    }

    function test_delete_not_found(): void
    {
        $response = $this->deleteJson('/api/locations/9999');

        $response->assertStatus(404)->assertJsonStructure([
            'errors',
            'message'
        ]);
    }
}
