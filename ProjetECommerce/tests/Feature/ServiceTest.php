<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
use RefreshDatabase;

    public function test_index_returns_a_successful_response()
    {
        $service = Service::factory()->create(); // Assurez-vous d'avoir un modèle factory pour Service
        $response = $this->get('/api/services');
        $response->assertStatus(200);
        $response->assertJsonFragment(['service' => ['data' => [['id' => $service->id]]]]);
    }

    public function test_show_returns_a_successful_response()
    {
        $service = Service::factory()->create();
        $response = $this->get("/api/services/{$service->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['service' => ['id' => $service->id]]);
    }

    public function test_store_creates_a_new_service()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/services', [
            'name' => 'Test Service',
            'cost' => 99.99,
            'area' => 'Test Area',
            'user_id' => $user->id,
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['service' => ['name' => 'Test Service']]);
    }

    public function test_update_modifies_an_existing_service()
    {
        $service = Service::factory()->create();
        $user = User::factory()->create();
        $response = $this->put("/api/services/{$service->id}", [
            'name' => 'Updated Service',
            'cost' => 199.99,
            'area' => 'Updated Area',
            'user_id' => $user->id,
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['service' => ['name' => 'Updated Service']]);
    }

    public function test_destroy_deletes_a_service()
    {
        $service = Service::factory()->create();
        $response = $this->delete("/api/services/{$service->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

}
