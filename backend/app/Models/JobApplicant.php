<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplicant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'recruitment_request_id',
        'applicant_name',
        'email',
        'phone',
        'qualification',
        'experience_years',
        'current_ctc',
        'expected_ctc',
        'resume_path',
        'application_date',
        'stage',
        'status',
    ];
}