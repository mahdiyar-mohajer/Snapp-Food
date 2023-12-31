<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResturantCategory extends Model
{
    use HasFactory;

    protected $table = 'resturant_categories';
    protected $fillable = ['name'];
    public function resturants()
    {
        return $this->belongsToMany(Resturant::class,'resturants_resturant_categories');
    }
}
