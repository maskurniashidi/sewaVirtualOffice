<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Facility extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    public function services()
    {
        return $this->belongsToMany(Service::class, '');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'facilities_services');
    }
}
