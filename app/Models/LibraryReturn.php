<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryReturn extends Model
{
    protected $fillable = [
        'issue_id',
        'item_id',
        'user_id',
        'admin_id',
        'return_date',
        'late_count'
    ];

    protected $casts = [
        'return_date' => 'datetime:d/m/Y h:i a',
        'created_at' => 'datetime:d/m/Y h:i a',
        'updated_at' => 'datetime:d/m/Y h:i a',
    ];

    protected $hidden = [
        'issue_id',
        'admin_id',
        'user_id',
        'item_id'
    ];

    public function issue(): BelongsTo
    {
    	return $this->belongsTo(LibraryIssue::class, 'issue_id', 'id');
    }

    public function info(): BelongsTo
    {
        return $this->belongsTo(Library::class, 'item_id', 'id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Library::class, 'item_id', 'id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
