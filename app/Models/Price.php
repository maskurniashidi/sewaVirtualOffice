<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Price extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'duration',
        'unit',
        'service_id'
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
