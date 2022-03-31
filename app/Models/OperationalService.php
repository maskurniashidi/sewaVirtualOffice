<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalService extends Model
{
    use HasFactory;
    protected $table = 'operationals_services';
    protected $fillable = [
        'service_id',
        'operational_id',
    ];
}
