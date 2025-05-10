<?php

namespace Modules\Activity\App\Models;

use Illuminate\Support\Facades\Log;
use MongoDB\Laravel\Eloquent\Model;

class ActivityLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'activity_logs';
    protected $fillable = [
        'causer_id',
        'causer_type',
        'causer_name',
        'causer_mobile',
        'subject_id',
        'subject_type',
        'message',
        'data',
        'ip',
        'log_name',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s'
    ];

    protected $dates = ['created_at'];

    public function scopeFilter($query, $request)
    {
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->input('subject_id'));
        }

        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->input('subject_type'));
        }

        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->input('causer_id'));
        }

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            if (is_numeric($keyword)) {
                $query->where('causer_id', $keyword);
            } else {
                $query->where('causer_name', 'like', "%{$keyword}%")
                    ->orWhere('causer_mobile', 'like', "%{$keyword}%");
            }
        }

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->input('log_name'));
        }
        return $query;
    }

    public function format(): array
    {
        return $this->attributesToArray() + ['causer_mobile' => '', 'causer_name' => '', 'subject_id' => '', 'subject_type' => ''];
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function (ActivityLog $activityLog) {
            try {
                if (!$activityLog->ip) {
                    $activityLog->ip = request()->ip();
                }
                if (!$activityLog->log_name) {
                    $activityLog->log_name = config('mongovity.log_name', 'default');
                }
                $activityLog->data = $activityLog->data + [
                        'hosts' => [
                            'name' => gethostname(),
                            'uri' => $_SERVER['REQUEST_URI'] ?? null
                        ]
                    ];
            } catch (\Exception $exception) {
                Log::error($exception, [
                    'keyword' => 'ActivityLog::creating.boot'
                ]);
            }
        });
    }
}
