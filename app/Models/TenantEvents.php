<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantEvents extends Model
{
    use HasFactory;

    // HACK: use events table since we are using multiple databases
    // and each tenants got their own db
    protected $table = 'events';

    // NOTE: thanks copilot for saving me time from typing all of this xD
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
    ];
}
