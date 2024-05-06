<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_a_successful_response()
    {
        $category = Category::factory()->create();
        $response = $this->get('/api/categories');
        $response->assertStatus(200);
        $response->assertJsonFragment(['categories' => ['data' => [['id' => $category->id]]]]);
    }
    public function test_show_returns_a_successful_response()
    {
        $category = Category::factory()->create();
        $response = $this->get("/api/categories/{$category->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['category' => ['id' => $category->id]]);
    }
    public function test_store_creates_a_new_category()
    {
        $response = $this->post('/api/categories', [
            'name' => 'Test Category',
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['category' => ['name' => 'Test Category']]);
    }
    public function test_update_modifies_an_existing_category()
    {
        $category = Category::factory()->create();
        $response = $this->put("/api/categories/{$category->id}", [
            'name' => 'Updated Category Name',
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['category' => ['name' => 'Updated Category Name']]);
    }
    public function test_destroy_deletes_a_category()
    {
        $category = Category::factory()->create();
        $response = $this->delete("/api/categories/{$category->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

}
