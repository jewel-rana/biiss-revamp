<?php

namespace Modules\Category\App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'details'
    ];

    public function scopeFilter($query, $request)
    {
        if($request->filled('search')) {
            $query->where('name', 'like', "%{$request->get('search')}%");
        }

        return $query;
    }
}
