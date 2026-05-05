<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceWorkOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'wo_number',
        'wo_date',
        'maintenance_schedule_id',
        'machine_id',
        'work_type',
        'description',
        'priority',
        'assigned_to',
        'scheduled_date',
        'started_at',
        'completed_at',
        'downtime_minutes',
        'actual_cost',
        'status',
    ];
}