<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'evaluation_number',
        'employee_id',
        'evaluation_period',
        'year',
        'from_date',
        'to_date',
        'overall_rating',
        'goals_score',
        'competency_score',
        'total_score',
        'status',
        'evaluated_by',
        'approved_by',
    ];
}