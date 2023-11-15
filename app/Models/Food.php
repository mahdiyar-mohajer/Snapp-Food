<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';

    protected $fillable = [
        'name',
        'raw_material',
        'price',
    ];

    public function resturant()
    {
        return $this->belongsTo(Resturant::class, 'resturant_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function foodCategories()
    {
        return $this->belongsToMany(FoodCategory::class,'foods_food_categories');
    }
    public function foodParty()
    {
        return $this->hasOne(FoodParty::class);
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }
}
