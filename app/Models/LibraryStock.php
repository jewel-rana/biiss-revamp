<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryStock extends Model
{
    public $timestamps = false;
     protected $fillable = [
         'item_id',
         'copy_number',
         'qr_string',
         'issued'
     ];

     protected $casts = [
         'issued' => 'int'
     ];

     public function item(): BelongsTo
     {
     	return $this->belongsTo(Library::class, 'item_id', 'id');
     }
}
