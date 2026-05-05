<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MrpRun extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'run_number',
        'run_date',
        'run_type',
        'from_date',
        'to_date',
        'mps_id',
        'total_planned_orders',
        'total_materials',
        'status',
        'run_by',
    ];
}