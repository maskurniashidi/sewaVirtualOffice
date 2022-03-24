<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\Price;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'space',
        'capacity',
        'description',
    ];
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
