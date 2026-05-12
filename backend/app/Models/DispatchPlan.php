<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'plan_number',
        'plan_date',
        'dispatch_date',
        'transporter_id',
        'vehicle_id',
        'driver_name',
        'driver_phone',
        'status',
        'created_by',
    ];
}