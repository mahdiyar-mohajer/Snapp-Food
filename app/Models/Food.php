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

    public function foodCategories()
    {
        return $this->hasMany(FoodCategory::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
