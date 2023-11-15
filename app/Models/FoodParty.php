<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodParty extends Model
{
    use HasFactory;
    protected $table = 'foods_party';
    protected $fillable = [
        'start_time','end_time', 'count', 'discount'
    ];
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Resturant::class);
    }

}
