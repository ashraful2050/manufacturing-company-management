<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionScrap extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'scrap_number',
        'job_card_id',
        'product_id',
        'scrap_qty',
        'scrap_reason',
        'scrap_value',
        'scrap_date',
        'disposed_date',
        'disposal_method',
        'status',
        'created_by',
    ];
}