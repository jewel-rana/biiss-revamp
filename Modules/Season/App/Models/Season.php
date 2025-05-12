<?php

namespace Modules\Season\App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name',
    ];

    public function scopeFilter($query, $request)
    {
        if($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return $query;
    }
}
