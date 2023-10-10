<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolControllerTest extends TestCase
{
    use RefreshDatabase;

    function signIn(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

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

    function test_get_role_by_id(): void
    {
        $role = Role::factory()->create();

        $response = $this->getJson("/api/roles/{$role->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
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
            ]);
    }
}
