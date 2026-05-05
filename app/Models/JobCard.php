<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'card_number',
        'card_date',
        'work_order_id',
        'sales_order_id',
        'product_id',
        'bom_id',
        'production_route_id',
        'production_line_id',
        'shift_id',
        'planned_qty',
        'produced_qty',
        'rejected_qty',
        'scrap_qty',
        'operation_name',
        'start_datetime',
        'end_datetime',
        'actual_start',
        'actual_end',
        'status',
        'created_by',
    ];
}