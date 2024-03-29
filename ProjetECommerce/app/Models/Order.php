<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuids;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products() {
        return $this->belongsToMany(Product::class, 'orders_products', 'order_id', 'product_id')
            ->withPivot('quantity');
    }
    protected $fillable = [
        'user_id',
        'date',
    ];
}
