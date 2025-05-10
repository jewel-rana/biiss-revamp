<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLog extends Model
{
    protected $fillable = [
        'oauth_token',
        'user_id',
        'login_date',
        'is_loggedin',
    ];

    protected $casts = [
        'is_loggedin' => 'boolean',
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s',
    ];

    protected $hidden = [
        'oauth_token',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
