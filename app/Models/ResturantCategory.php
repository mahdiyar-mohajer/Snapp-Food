<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResturantCategory extends Model
{
    use HasFactory;
    protected $table = 'resturant_categories';

    public function resturant()
    {
        return $this->hasMany(Resturant::class);
    }
}