<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    function test_user_get_all(): void
    {
        $role = \App\Models\Role::factory()->create();
        $permission = \App\Models\Permission::factory()->create();

        // Attach permission to role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'password',
            'role_id' => $role->id,
        ]);

        $response = $this->getJson('/api/users');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    // This returns with pagination
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                            'email_verified_at',
                            'created_at',
                            'updated_at',
                            'role' => [
                                'id',
                                'name',
                                'slug',
                                'created_at',
                                'updated_at'
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

    function test_user_create(): void
    {
        $role = \App\Models\Role::factory()->create();
        $permission = \App\Models\Permission::factory()->create();

        // Attach permission to role
        $user = [
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'password',
            'role_id' => $role->id,
        ];

        $response = $this->postJson('/api/users', $user);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'role' => [
                        'id',
                        'name',
                        'slug',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    function test_user_create_wit_wrong_data(): void
    {
        $user = [
            'name' => 'Test User',
            'email' => 'testemail.com',
            'password' => 'password',
            'role_id' => false,
        ];

        $response = $this->postJson('/api/users', $user);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'role_id'
                ]
            ]);
    }

    function test_user_get(): void
    {
        $role = \App\Models\Role::factory()->create();

        // Attach permission to role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testemail.com',
            'password' => 'password',
            'role_id' => $role->id,
        ]);

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'role' => [
                        'id',
                        'name',
                        'slug',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    function test_user_get_not_found(): void
    {
        $response = $this->getJson("/api/users/1");

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    function test_user_update(): void
    {
        $role = \App\Models\Role::factory()->create();

        // Attach permission to role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testemail.com',
            'password' => 'password',
            'role_id' => $role->id,
        ]);

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Test User Updated',
            'email' => 'testemailupdated@email.com',
            'password' => 'password',
            'role_id' => $role->id,
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'role' => [
                        'id',
                        'name',
                        'slug',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    function test_user_update_with_invalid_data(): void
    {
        $role = \App\Models\Role::factory()->create();

        // Attach permission to role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testemail.com',
            'password' => 'password',
            'role_id' => $role->id,
        ]);

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Test User Updated',
            'email' => 'testemailupdatedemail.com',
            'password' => 'password',
            'role_id' => $role->id,
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email'
                ]
            ]);
    }

    function test_user_delete(): void
    {
        $role = \App\Models\Role::factory()->create();

        // Attach permission to role
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testemail.com',
            'password' => 'password',
            'role_id' => $role->id,
        ]);

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    function test_user_delete_not_found(): void
    {
        $response = $this->deleteJson("/api/users/1");

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }
}
