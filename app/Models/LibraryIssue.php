<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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

    public function scopeFilter($query, $request)
    {
        $query->where('is_returned', 0);
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('book_title', 'like', '%' . $search . '%');
            $query->orWhere('copy_number', 'like', '%' . $search . '%');
            $query->orWhere('user_name', 'like', '%' . $search . '%');
            $query->orWhere('start_date', 'like', '%' . $search . '%');
        }

        //filter type
        if ($request->filled('type')) {
            $type = $request->get('type');
            $today = date('Y-m-d');
            if ($type == 'expire') {
                $query->where('end_date', '<', $today);
            }

            if ($type == 'active') {
                $query->where('end_date', '>=', $today);
            }
        }
        return $query;
    }

    public function lateCount(): int
    {
        return (int) $this->end_date->diffInDays(now());
    }
}
