<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }
}
