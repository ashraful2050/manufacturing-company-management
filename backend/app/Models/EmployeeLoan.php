<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLoan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'loan_number',
        'employee_id',
        'loan_type',
        'loan_amount',
        'approved_amount',
        'interest_rate',
        'tenure_months',
        'emi_amount',
        'disbursed_date',
        'status',
        'approved_by',
    ];
}