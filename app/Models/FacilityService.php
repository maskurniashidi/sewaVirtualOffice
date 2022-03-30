<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityService extends Model
{
    use HasFactory;
    protected $table = 'facilities_services';
    protected $fillable = [
        'service_id',
        'facility_id'
    ];
}
