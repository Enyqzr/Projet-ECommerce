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
    public function product() {
        return $this->belongsToMany(Product::class, 'contents', 'order_id', 'product_id')
            ->withPivot('quantity');
    }
    protected $fillable = [
        'date',
    ];
}
