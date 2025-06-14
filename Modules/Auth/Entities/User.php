<?php

namespace Modules\Auth\Entities;

use App\Helpers\CommonHelper;
use App\Models\Library;
use App\Models\LibraryIssue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\Activity\App\Traits\ActivityTrait;
use Modules\Auth\App\Models\UserAccessBlock;
use Modules\Auth\Constants\AuthConstant;
use Spatie\Permission\Traits\HasRoles;

class User extends \App\Models\User
{
    use HasRoles, Notifiable, HasApiTokens, ActivityTrait;

    protected $fillable = ['name', 'email', 'status', 'password', 'is_editable'];
    protected string $guard_name = 'web';

    protected static $logAttributes = ['name', 'email', 'password', 'status'];
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "User {$eventName}";
    }

    public function issuedBooks(): HasManyThrough
    {
        return $this->hasManyThrough(Library::class,  LibraryIssue::class, 'item_id', 'id', 'id');
    }

    public function userAccessBlock(): HasMany
    {
        return $this->hasMany(UserAccessBlock::class)
            ->where('unblocked_at', '>=', now()->toDateTimeString())
            ->where('is_blocked', true);
    }

    public function getAvatarAttribute($value): string
    {
        return $value ? asset('storage/uploads/profile/' . $value) : asset('default/avatar.png');
    }

    public function getNiceStatusAttribute()
    {
        return config('auth.user.statuses')[$this->status] ?? 'N/A';
    }

    public function getCreatedAtAttribute($datetime): string
    {
        return CommonHelper::parseLocalTimeZone($datetime);
    }

    public function scopeFilter($query, $request)
    {
        $query->where('type', AuthConstant::USER_TYPE_ADMIN);

        if ($request->filled('status') && in_array($request->input('status'), ['active', 'inactive', 'pending'])) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('role_id')) {
            $query->whereHas('roles', function($q) use ($request){
                $q->where('roles.id', $request->input('role_id'));
            });
        }

        if ($request->filled('keyword')) {
            $query->where('name', 'like',  "%{$request->input('keyword')}%")
                ->orWhere('email', 'like',  "%{$request->input('keyword')}%");
        }

        return $query;
    }

    public function actionPermitted(): bool
    {
        return $this->id !== auth()->user()->id && $this->is_editable;
    }

    public function isActive(): bool
    {
        return $this->status == AuthConstant::USER_ACTIVE;
    }

    public function isBlocked(): bool
    {
        return (bool) $this->userAccessBlock()->count();
    }
}
