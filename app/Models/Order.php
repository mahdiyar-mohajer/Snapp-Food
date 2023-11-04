<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderShip()
    {
        return $this->belongsTo(OrderShip::class, 'shipment_id');
    }

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
