<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_a_successful_response()
    {
        $user = User::factory()->create();
        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $response->assertJsonFragment(['user' => ['data' => [['id' => $user->id]]]]);
    }

    public function test_store_creates_a_new_user()
    {
        $response = $this->post('/api/users', [
            'firstname' => 'Test',
            'lastname' => 'test',
            'mail' => 'test@example.com',
            'address' => '74 campus',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['user' => ['firstname' => 'Test', 'lastname' => 'test', 'mail' => 'test@example.com']]);
    }

    public function test_show_returns_a_successful_response()
    {
        $user = User::factory()->create();
        $response = $this->get("/api/users/{$user->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['user' => ['id' => $user->id]]);
    }

    public function test_update_modifies_an_existing_user()
    {
        $user = User::factory()->create();
        $response = $this->put("/api/users/{$user->id}", [
            'firstname' => 'Testmod',
            'lastname' => 'mod',
            'address' => 'CampusNum',
            'password' => 'password',
            'role' => 'utilisateur',
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['user' => ['firstname' => 'Testmod', 'lastname' => 'mod', 'address' => 'CampusNum', 'role' => 'utilisateur']]);
    }

    public function test_destroy_deletes_a_user()
    {
        $user = User::factory()->create();
        $response = $this->delete("/api/users/{$user->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

}
