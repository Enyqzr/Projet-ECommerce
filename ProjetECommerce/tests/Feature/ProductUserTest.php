<?php

namespace Tests\Feature;

use App\Models\ProductUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductUserTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_a_successful_response()
    {
        $comment = ProductUser::factory()->create();
        $response = $this->get('/api/product-users');
        $response->assertStatus(200);
        $response->assertJsonFragment(['comments' => ['data' => [['id' => $comment->id]]]]);
    }

    public function test_show_returns_a_successful_response()
    {
        $comment = ProductUser::factory()->create();
        $response = $this->get("/api/product-users/{$comment->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['comment' => ['id' => $comment->id]]);
    }

    public function test_store_creates_a_new_comment()
    {
        $response = $this->post('/api/product-users', [
            'content' => 'Test comment'
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['comment' => ['content' => 'Test comment']]);
    }

    public function test_update_modifies_an_existing_comment()
    {
        $comment = ProductUser::factory()->create();
        $response = $this->put("/api/product-users/{$comment->id}", [
            'content' => 'Updated comment',
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['comment' => ['content' => 'Updated comment']]);
    }
    public function test_destroy_deletes_a_comment()
    {
        $comment = ProductUser::factory()->create();
        $response = $this->delete("/api/product-users/{$comment->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('product_users', ['id' => $comment->id]);
    }
    public function test_product_user_relation()
    {
        // Créez des instances de Product et User
        $product = Product::factory()->create();
        $user = User::factory()->create();

        // Associez le produit à l'utilisateur via la table pivot
        $product->users()->attach($user);

        // Récupérez le produit avec les données pivot
        $productWithPivotData = Product::with('users')->find($product->id);

        // Vérifiez que les données pivot sont correctement chargées
        $this->assertDatabaseHas('product_user', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);

        // Vérifiez que les données pivot sont accessibles via la relation
        $this->assertEquals($user->id, $productWithPivotData->users->first()->pivot->user_id);
    }
}
