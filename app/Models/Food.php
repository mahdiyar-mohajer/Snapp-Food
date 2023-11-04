<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }

    public function foodCategories()
    {
        return $this->hasMany(FoodCategory::class);
    }
}
