<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Blog extends Model
{
    use HasFactory, HasUuids;
    public function users() {
     return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'content',
        'date',
    ];
}
