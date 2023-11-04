<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodParty extends Model
{
    use HasFactory;
    protected $table = 'foods_party';
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Resturant::class);
    }

}
