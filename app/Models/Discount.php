<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discount';

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }
}
