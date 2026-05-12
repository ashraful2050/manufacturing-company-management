<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionVariance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'job_card_id',
        'product_id',
        'planned_qty',
        'actual_qty',
        'qty_variance',
        'planned_material_cost',
        'actual_material_cost',
        'material_variance',
        'planned_labour_cost',
        'actual_labour_cost',
        'labour_variance',
        'planned_overhead_cost',
        'actual_overhead_cost',
        'overhead_variance',
        'total_variance',
    ];
}