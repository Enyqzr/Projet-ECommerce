<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        Service::factory()
            ->count(3)
            ->for($user)
            ->create();

        Blog::factory()
            ->count(3)
            ->for($user)
            ->create();

        $order = Order::factory()
            ->count(3)
            ->for($user)
            ->create();
        $category = Category::factory()->create();
        Product::factory()
            ->count(3)
            ->for($category)
            ->hasAttached($order, ['quantity'=>1])
            ->hasAttached($user, ['comment'=>'Ceci est un commentaire'])
            ->create();
    }
}
