<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryIssue extends Model
{
    protected $fillable = [
        'item_id',
        'stock_id',
        'user_id',
        'admin_id',
        'start_date',
        'end_date',
        'bundle',
        'status',
        'is_returned'
    ];

    protected $casts = [
        'start_date' => 'date:d/m/Y',
        'end_date' => 'date:d/m/Y',
        'is_returned' => 'boolean',
        'created_at' => 'datetime:d/m/Y h:i A',
        'updated_at' => 'datetime:d/m/Y h:i A',
    ];

    protected $hidden = [
        'user_id',
        'admin_id',
    ];

    public function member(): BelongsTo
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Library::class, 'item_id', 'id');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(LibraryStock::class, 'stock_id', 'id');
    }
}
