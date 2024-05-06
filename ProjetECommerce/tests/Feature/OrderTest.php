<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_a_successful_response()
    {
        $order = Order::factory()->create();
        $response = $this->get('/api/orders');
        $response->assertStatus(200);
        $response->assertJsonFragment(['orders' => ['data' => [['id' => $order->id]]]]);
    }
    public function test_show_returns_a_successful_response()
    {
        $order = Order::factory()->create();
        $response = $this->get("/api/orders/{$order->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['order' => ['id' => $order->id]]);
    }
    public function test_store_creates_a_new_order_with_products()
    {
        $product = Product::factory()->create();
        $response = $this->post('/api/orders', [
            'total' => 100,
            'products' => [
                ['id' => $product->id, 'quantity' => 2],
            ],
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['order' => ['total' => 100]]);
    }
    public function test_update_modifies_an_existing_order_with_products()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $response = $this->put("/api/orders/{$order->id}", [
            'total' => 150,
            'products' => [
                ['id' => $product->id, 'quantity' => 3],
            ],
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['order' => ['total' => 150]]);
    }
    public function test_destroy_deletes_an_order()
    {
        $order = Order::factory()->create();
        $response = $this->delete("/api/orders/{$order->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }

}
