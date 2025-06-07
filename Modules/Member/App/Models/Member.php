<?php

namespace Modules\Member\App\Models;

use App\Models\Library;
use App\Models\LibraryIssue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;
use Modules\Activity\App\Traits\ActivityTrait;
use Modules\Auth\Constants\AuthConstant;

class Member extends Model
{
    use Notifiable, ActivityTrait;

    protected $table = 'users';

    protected $fillable = [
        'account_id',
        'name',
        'email',
        'password',
        'status',
        'address',
        'avatar',
        'contact_number'
    ];
    protected string $guard_name = 'web';

    protected static $logAttributes = ['name', 'email', 'password', 'status'];
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "User {$eventName}";
    }

    public function issuedBooks(): HasManyThrough
    {
        return $this->hasManyThrough(Library::class, LibraryIssue::class, 'item_id', 'id', 'id');
    }


    public function getNiceStatusAttribute()
    {
        return config('auth.user.statuses')[$this->status] ?? 'N/A';
    }

    public function getAvatarAttribute($value): string
    {
        return $value ? asset('storage/uploads/profile/' . $value) : asset('default/avatar.png');
    }

    public function scopeFilter($query, $request)
    {
        $query->where('type', AuthConstant::USER_TYPE_MEMBER);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('keyword')) {
            $query->where('name', 'like', "%{$request->input('keyword')}%")
                ->orWhere('account_id', $request->input('keyword'))
                ->orWhere('email', 'like', "%{$request->input('keyword')}%")
                ->orWhere('contact_number', 'like', "%{$request->input('keyword')}%");
        }

        return $query;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->type = AuthConstant::USER_TYPE_MEMBER;
        });

        static::updating(function ($model) {
            $model->type = AuthConstant::USER_TYPE_MEMBER;
        });
    }
}
