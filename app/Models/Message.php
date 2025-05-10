<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'body',
        'parent',
        'status',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    protected $hidden = [
        'updated_at',
    ];
}
