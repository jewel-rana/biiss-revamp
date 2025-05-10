<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $fillable = [
        'name',
        'value',
        'details',
        'is_active'
    ];

    protected $hidden = [
        'is_active',
        'created_at',
        'updated_at'
    ];
}
