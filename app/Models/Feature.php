<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model
{
    protected $fillable = [
        'book_id',
        'type',
        'publication_year'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:i A',
        'updated_at' => 'datetime:d/m/Y h:i A',
    ];

    protected $hidden = [
        'book_id',
        'updated_at',
    ];

	public $timestamps = false;

    public function item(): BelongsTo
    {
    	return $this->belongsTo(Library::class, 'book_id', 'id');
    }
}
