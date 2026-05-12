<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'name',
        'code',
        'machine_type',
        'manufacturer',
        'model_number',
        'serial_number',
        'purchase_date',
        'purchase_cost',
        'capacity',
        'capacity_uom',
        'production_line_id',
        'department_id',
        'status',
        'is_active',
    ];
}