<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'employee_id',
        'attendance_date',
        'shift_id',
        'check_in',
        'check_out',
        'working_hours',
        'overtime_hours',
        'late_minutes',
        'early_departure_minutes',
        'status',
        'remarks',
    ];
}