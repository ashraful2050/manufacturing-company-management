<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyProduction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'entry_number',
        'production_date',
        'shift_id',
        'production_line_id',
        'job_card_id',
        'product_id',
        'planned_qty',
        'actual_qty',
        'rejected_qty',
        'scrap_qty',
        'operator_id',
        'supervisor_id',
    ];
}