<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'banners';
    protected $fillable = ['title', 'text', 'user_id'];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
