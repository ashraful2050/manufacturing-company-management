<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'payroll_number',
        'employee_id',
        'month',
        'year',
        'working_days',
        'present_days',
        'paid_leave_days',
        'absent_days',
        'overtime_hours',
        'gross_salary',
        'total_deductions',
        'net_salary',
        'status',
        'paid_date',
        'payment_mode',
        'created_by',
    ];
}