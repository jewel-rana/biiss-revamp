<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryTag extends Model
{
    protected $fillable = [
        'item_id',
        'categories'
    ];

    public $timestamps = false;
}
