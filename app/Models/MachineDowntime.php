<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineDowntime extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'downtime_number',
        'machine_id',
        'production_line_id',
        'shift_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'downtime_type',
        'root_cause',
        'action_taken',
        'reported_by',
        'resolved_by',
        'status',
    ];
}