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

    public function order() {
        return $this->belongsToMany(Order::class, 'contents', 'product_id', 'order_id')
            ->withPivot('quantity');
    }

    protected $fillable = [
        'name',
        'price',
        'description',
    ];
}