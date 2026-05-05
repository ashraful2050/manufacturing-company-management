<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionWip extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'job_card_id',
        'product_id',
        'operation_name',
        'wip_qty',
        'unit_id',
        'start_date',
        'expected_completion',
        'actual_completion',
        'status',
    ];
}