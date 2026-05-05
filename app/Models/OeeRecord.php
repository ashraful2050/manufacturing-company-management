<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OeeRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'machine_id',
        'production_line_id',
        'shift_id',
        'record_date',
        'planned_time',
        'actual_run_time',
        'downtime',
        'availability',
        'ideal_cycle_time',
        'total_count',
        'performance',
        'good_count',
        'quality',
        'oee',
    ];
}