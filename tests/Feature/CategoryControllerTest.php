<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    function test_get_all_categories(): void
    {
        Category::factory()->count(100)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'icon',
                    'is_active',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    function test_get_all_by_search(): void
    {
        Category::factory()->count(100)->create();

        $category = Category::inRandomOrder()->first();

        $response = $this->getJson("/api/categories?search=$category->name");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'icon',
                    'is_active',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    function test_get_all_by_search_not_found(): void
    {
        Category::factory()->count(100)->create();

        $response = $this->getJson('/api/categories?search=not_found');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => []
        ]);
    }

    function test_create_category(): void
    {

        $response = $this->postJson('/api/categories', [
            'name' => 'Category Test',
            'description' => 'Category Test Description',
            'icon' => 'Category Test Icon',
            'is_active' => true
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'icon',
                'is_active',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    function test_create_category_validation_error(): void
    {

        $response = $this->postJson('/api/categories', [
            'name' => '',
            'description' => '',
            'icon' => '',
            'is_active' => true
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            'errors',
            'message',
        ]);
    }

    function test_show_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/$category->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'icon',
                'is_active',
                'created_at',
                'updated_at',
                'tourist_spot' => [
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
                        ]
                    ]
                ],
            ],
        ]);
    }

    function test_show_category_not_found(): void
    {
        $response = $this->getJson('/api/categories/1000');

        $response->assertStatus(404)->assertJsonStructure([
            'errors',
            'message',
        ]);
    }

    function test_update_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->putJson("/api/categories/$category->id", [
            'name' => 'Category Test',
            'description' => 'Category Test Description',
            'icon' => 'Category Test Icon',
            'is_active' => true
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'icon',
                'is_active',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    function test_update_with_invalid_data(): void
    {
        $category = Category::factory()->create();

        $response = $this->putJson("/api/categories/$category->id", [
            'name' => '',
            'description' => '',
            'icon' => '',
            'is_active' => true
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            'errors',
            'message',
        ]);
    }

    function test_update_not_found(): void
    {
        $response = $this->putJson('/api/categories/1000', [
            'name' => 'Category Test',
            'description' => 'Category Test Description',
            'icon' => 'Category Test Icon',
            'is_active' => true
        ]);

        $response->assertStatus(404)->assertJsonStructure([
            'errors',
            'message',
        ]);
    }

    function test_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/$category->id");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'icon',
                'is_active',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    function test_delete_not_found(): void
    {
        $response = $this->deleteJson('/api/categories/1000');

        $response->assertStatus(404)->assertJsonStructure([
            'errors',
            'message',
        ]);
    }
}
