<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\TouristType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TouristTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_get_all_types(): void
    {
        TouristType::factory()->count(10)->create();

        $response = $this->get('/api/tourist-types');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'icon',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    function test_get_all_by_location_id(): void
    {
        Location::factory()->count(10)->create();
        TouristType::factory()->count(10)->create();

        
    }
}
