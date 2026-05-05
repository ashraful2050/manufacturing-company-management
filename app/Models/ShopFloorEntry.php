<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopFloorEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'entry_number',
        'entry_date',
        'shift_id',
        'production_line_id',
        'machine_id',
        'job_card_id',
        'product_id',
        'operator_id',
        'planned_qty',
        'actual_qty',
        'rejected_qty',
        'scrap_qty',
        'downtime_minutes',
        'notes',
    ];
}