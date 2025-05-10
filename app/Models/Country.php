<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'code',
        'namecap',
        'name',
        'iso3',
        'numcode'
    ];

    public $timestamps = false;
}
