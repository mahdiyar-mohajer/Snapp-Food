<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShip extends Model
{
    use HasFactory;
    protected $table = 'order_ship';
    protected $fillable = ['carrier_name', 'carrier_number', 'receive_time', 'order_id'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
