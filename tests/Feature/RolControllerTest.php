<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_get_all_roles_with_permissions(): void
    {
        Role::factory()->count(5)->create();

        $response = $this->getJson('/api/roles');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'created_at',
                        'updated_at',
                        'permissions' => [
                            '*' => [
                                'id',
                                'name',
                                'slug',
                                'created_at',
                                'updated_at',
                                'pivot' => [
                                    'is_active',
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }
}
