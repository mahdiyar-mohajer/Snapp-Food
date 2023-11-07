<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resturant extends Model
{
    use HasFactory;
    protected $table = 'resturants';
    protected $fillable = [
        'name',
        'phone_number',
        'start_time',
        'end_time',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function foodParties()
    {
        return $this->hasMany(FoodParty::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'resturant_id');
    }

    public function foodCategory()
    {
        return $this->hasMany(FoodCategory::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
