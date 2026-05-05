<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostSheet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'sheet_number',
        'sheet_date',
        'product_id',
        'cost_type',
        'production_order_id',
        'quantity',
        'total_material_cost',
        'total_labour_cost',
        'total_overhead_cost',
        'total_cost',
        'unit_cost',
        'status',
        'prepared_by',
        'approved_by',
    ];
}