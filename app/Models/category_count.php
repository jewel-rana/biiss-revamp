<?php

namespace App\Models;

class Category extends Model
{
    protected array $fillable = [
        'name',
        'details',
    ];

    protected array $casts = [
        'created_at' => 'datetime:d/m/Y h:i A',
        'updated_at' => 'datetime:d/m/Y h:i A',
    ];

    protected array $hidden = [
        'updated_at'
    ];
}
