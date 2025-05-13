<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Library extends Model
{
    protected $fillable = [
        'type',
        'abstract',
        'title',
        'author_mark',
        'document_author',
        'core_author',
        'unit',
        'edition',
        'call_number',
        'acc_number',
        'accession',
        'author_status',
        'place',
        'publisher',
        'publication_year',
        'month_of_publish',
        'pagination',
        'book_index',
        'bibliography',
        'volume_number',
        'series',
        'copy_number',
        'qr_string_unique',
        'isbn',
        'issn',
        'currency',
        'price',
        'season',
        'from_where',
        'source',
        'item_number',
        'friq',
        'shelf',
        'rack',
        'cover_photo',
        'e_book',
        'bill_and_voucher',
        'article',
        'keywords',
        'remarks',
        'edate',
        'migration_ref',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:i A',
        'updated_at' => 'datetime:d/m/Y h:i A',
    ];

    protected $hidden = [

    ];

    public $timestamps = true;

    public function authors(): HasMany
    {
    	return $this->hasMany(LibraryAuthor::class, 'item_id', 'id');
    }

    public function featured(): HasOne
    {
        return $this->hasOne(Feature::class, 'book_id', 'id');
    }

    public function featureds(): HasMany
    {
        return $this->hasMany(Feature::class, 'book_id', 'id');
    }

    public function tags(): HasMany
    {
    	return $this->hasMany(LibraryTag::class, 'item_id', 'id');
    }

    public function copies(): HasMany
    {
        return $this->hasMany(LibraryStock::class, 'item_id', 'id');
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(LibraryIssue::class, 'item_id', 'id');
    }

    public function issues(): HasMany
    {
        return $this->hasMany(LibraryIssue::class, 'item_id', 'id');
    }

    public function returns(): HasMany
    {
    	return $this->hasMany(LibraryIssue::class, 'item_id', 'id');
    }

    public function getCoverPhotoAttribute($value): string
    {
        return ( $value != null ) ? asset( $value ) : asset('default/cover/' . strtolower( $this->type ) . '.jpg');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function($library) {
            // before delete() method call this

            //delete all copies from stock
            $library->copies()->delete();
            //delete all tags / subjects
             $library->tags()->delete();

            //delete authors
            $library->authors()->delete();

            //delete al return history
            $library->returns()->delete();

            //delete all issue history
            $library->issues()->delete();

            //delete featured items
            $library->featureds()->delete();
        });
    }
}
