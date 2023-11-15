<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use HasFactory;
    protected $table = 'food_categories';
    protected $fillable = ['name'];
    public function foods()
    {
        return $this->belongsToMany(Food::class,'foods_food_categories');
    }
}
