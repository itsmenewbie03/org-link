<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantAttendance extends Model
{
    use HasFactory;

    // HACK: use attendance table since we are using multiple databases
    // and each tenants got their own db
    protected $table = 'attendances';

    // INFO: thanks copilot for saving me time from typing all of this xD
    protected $fillable = [
        'name',
        'email',
        'course',
        'year_level',
        'event_id'
    ];
}
