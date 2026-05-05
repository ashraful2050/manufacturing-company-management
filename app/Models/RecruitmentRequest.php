<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruitmentRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'request_number',
        'position',
        'department_id',
        'no_of_positions',
        'required_by',
        'qualification',
        'experience',
        'ctc_budget',
        'status',
        'raised_by',
        'approved_by',
    ];
}