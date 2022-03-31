<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\Price;
use App\Models\Facility;
use App\Models\Rent;

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
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'facilities_services');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'rent');
    }
    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }
}
