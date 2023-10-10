<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
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

    function test_create_role()
    {
        $permissions = Permission::factory()->count(5)->create();

        $response = $this->postJson('/api/roles', [
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => $permissions->pluck('id')->toArray()
        ]);

        $response->assertStatus(201)
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

    function test_create_role_with_invalid_data(): void
    {
        $response = $this->postJson('/api/roles', [
            'name' => '',
            'slug' => '',
            'permissions' => null
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'permissions'
                ]
            ]);
    }

    function test_update_role(): void
    {
        $role = Role::factory()->create();

        $permissions = Permission::factory()->count(5)->create();

        $response = $this->putJson("/api/roles/{$role->id}", [
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => $permissions->pluck('id')->toArray()
        ]);

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

    function text_update_role_not_found(): void
    {
        $response = $this->putJson("/api/roles/1", [
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => []
        ]);

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    function test_update_role_with_invalid_data(): void
    {
        $role = Role::factory()->create();

        $response = $this->putJson("/api/roles/{$role->id}", [
            'name' => '',
            'slug' => '',
            'permissions' => null
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'permissions'
                ]
            ]);
    }

    function test_delete_role(): void
    {
        $role = Role::factory()->create();

        $response = $this->deleteJson("/api/roles/$role->id");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    function test_delete_role_not_found(): void
    {
        $response = $this->deleteJson("/api/roles/1");

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }
}
