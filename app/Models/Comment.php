<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['food_id', 'resturant_id', 'user_id', 'cart_id', 'score', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

//    public function resturant()
//    {
//        return $this->belongsTo(Resturant::class);
//    }
}
