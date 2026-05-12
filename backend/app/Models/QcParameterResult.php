<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class QcParameterResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'qc_parameter_id',
        'reference_type',
        'reference_id',
        'inspection_date',
        'measured_value',
        'is_pass',
        'remarks',
        'inspected_by',
    ];
}