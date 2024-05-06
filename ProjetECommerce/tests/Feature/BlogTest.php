<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_a_successful_response()
    {
        $blog = Blog::factory()->create();
        $response = $this->get('/api/blogs');
        $response->assertStatus(200);
        $response->assertJsonFragment(['blogs' => ['data' => [['id' => $blog->id]]]]);
    }

    public function test_show_returns_a_successful_response()
    {
        $blog = Blog::factory()->create();
        $response = $this->get("/api/blogs/{$blog->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['blog' => ['id' => $blog->id]]);
    }

    public function test_store_creates_a_new_blog()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/api/blogs', [
            'content' => 'Test content',
            'date' => now(),
            'user_id' => $user->id,
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['blog' => ['content' => 'Test content']]);
    }
    public function test_update_modifies_an_existing_blog()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->put("/api/blogs/{$blog->id}", [
            'content' => 'Updated content',
            'date' => now(),
            'user_id' => $user->id,
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['blog' => ['content' => 'Updated content']]);
    }
    public function test_destroy_deletes_a_blog()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->delete("/api/blogs/{$blog->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    }
}
