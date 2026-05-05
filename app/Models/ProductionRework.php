<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionRework extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'rework_number',
        'job_card_id',
        'product_id',
        'rework_qty',
        'rework_reason',
        'rework_action',
        'rework_date',
        'completed_date',
        'status',
        'created_by',
    ];
}