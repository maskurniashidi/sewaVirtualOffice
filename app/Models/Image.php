<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_url',
        'description',
        'service_id',
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
