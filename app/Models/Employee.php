<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'name_kanji',
        'name_kana',
        'nationality',
        'birthday',
        'gender',
        'avatar',
        'national_id',
        'marital_status',
        'job_title',
        'pay_grade',
        'address',
        'city',
        'country',
        'postal_code',
        'home_phone',
        'mobile_phone',
        'work_phone',
        'work_email',
        'private_email',
        'joined_date',
        'confirmation_date',
        'supervisor',
        'termination_date',
        'notes',
        'status'
    ];
}
