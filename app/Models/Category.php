<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'details'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:i A',
        'updated_at' => 'datetime:d/m/Y h:i A',
    ];

    protected $hidden = [
        'updated_at'
    ];
}
