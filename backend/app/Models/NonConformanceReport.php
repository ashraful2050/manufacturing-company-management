<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class NonConformanceReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'ncr_number',
        'ncr_date',
        'nc_type',
        'reference_type',
        'reference_id',
        'product_id',
        'description',
        'severity',
        'root_cause',
        'immediate_action',
        'raised_by',
        'assigned_to',
        'due_date',
        'resolved_date',
        'status',
    ];
}