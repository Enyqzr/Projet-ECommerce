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
        // Crée une nouvelle instance de la classe Blog en utilisant une factory.
        // Les factories dans Laravel permettent de générer facilement des données de test pour vos modèles.
        // Ici, une nouvelle blog est créée avec des données générées aléatoirement ou spécifiées dans la définition de la factory.
        $blog = Blog::factory()->create();
        // Effectue une requête GET vers l'endpoint '/api/blogs' de l'application.
        // Dans le contexte des tests de fonctionnalité, $this->get() est une méthode fournie par Laravel qui simule une requête HTTP GET.
        // Cela permet de tester la réponse de l'API sans avoir à exécuter l'application entière.
        $response = $this->get('/api/blogs');
        // Vérifie que la réponse à la requête GET a un statut HTTP de 200.
        // Un statut 200 indique que la requête a réussi et que le serveur a renvoyé la réponse demandée.
        // C'est une vérification de base pour s'assurer que l'API fonctionne correctement et renvoie une réponse réussie.
        $response->assertStatus(200);
        // Vérifie que la réponse JSON contient un fragment spécifique.
        // assertJsonFragment est une méthode qui permet de s'assurer que la réponse JSON contient un certain fragment de données.
        // Ici, elle vérifie que la réponse contient un tableau 'blogs' dont les éléments contiennent un tableau 'data' avec au moins un élément ayant un 'id' correspondant à celui du blog créé précédemment.
        // Cela garantit que le blog créé est bien présent dans la réponse de l'API.
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
