<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'date', 'data'];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'data' => 'array',
    ];
}
