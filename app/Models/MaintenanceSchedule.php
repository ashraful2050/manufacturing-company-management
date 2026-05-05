<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'machine_id',
        'schedule_name',
        'maintenance_type',
        'frequency',
        'last_done_date',
        'next_due_date',
        'estimated_duration_hours',
        'assigned_to',
        'status',
    ];
}