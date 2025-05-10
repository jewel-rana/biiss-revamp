<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $guarded = [];

    public function issue()
    {
    	return $this->belongsTo(\App\BookIssue::class, 'book_issue', 'book_id', 'id');
    }

    public function issuedCopies()
    {
    	return $this->issue()->where('is_returned','=', 0);
    }

    public function scopeFilter($query, $request)
    {
        if($request->has('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        if($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        return $query;
    }
}
