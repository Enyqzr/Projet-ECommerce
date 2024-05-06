<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_a_successful_response()
    {
        $product = Product::factory()->create();
        $response = $this->get('/api/products');
        $response->assertStatus(200);
        $response->assertJsonFragment(['products' => ['data' => [['id' => $product->id]]]]);
    }
    public function test_store_creates_a_new_product()
    {
        $category = Category::factory()->create();
        $response = $this->post('/api/products', [
            'name' => 'Test Product',
            'price' => 99.99,
            'description' => 'A test product',
            'category' => $category->name,
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['product' => ['name' => 'Test Product']]);
    }
    public function test_show_returns_a_successful_response()
    {
        $product = Product::factory()->create();
        $response = $this->get("/api/products/{$product->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['product' => ['id' => $product->id]]);
    }
    public function test_update_modifies_an_existing_product()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $response = $this->put("/api/products/{$product->id}", [
            'name' => 'Updated Product',
            'price' => 199.99,
            'description' => 'An updated product description',
            'category' => $category->name,
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['product' => ['name' => 'Updated Product']]);
    }
    public function test_destroy_deletes_a_product()
    {
        $product = Product::factory()->create();
        $response = $this->delete("/api/products/{$product->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

}
