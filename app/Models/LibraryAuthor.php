<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryAuthor extends Model
{
    protected $fillable = [
        'item_id',
        'author_name',
        'author_article',
        'auth_subject',
        'pagi'
    ];

    public $timestamps = false;
}
