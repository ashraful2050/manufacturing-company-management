<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapacityPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'plan_number',
        'plan_date',
        'from_date',
        'to_date',
        'production_line_id',
        'available_capacity',
        'required_capacity',
        'utilization_percentage',
        'status',
        'notes',
    ];
}