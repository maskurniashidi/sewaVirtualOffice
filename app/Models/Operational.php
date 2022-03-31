<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operational extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'open',
        'close'
    ];
}
