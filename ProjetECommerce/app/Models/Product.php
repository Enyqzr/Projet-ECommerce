<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Order;

class Product extends Model
{
    use HasFactory, HasUuids;

    public function category() {

        return $this->belongsTo(Category::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'orders_products', 'product_id', 'order_id')
            ->withPivot('quantity');
    }

//    public function users() {
//        return $this->belongsToMany(User::class, 'product_user')->withPivot('comment');
//    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(ProductUser::class);
    }

    protected $fillable = [
        'name',
        'price',
        'description',
    ];
}
