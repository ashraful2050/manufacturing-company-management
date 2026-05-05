<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'evaluation_number',
        'evaluation_date',
        'supplier_id',
        'evaluation_period',
        'quality_score',
        'delivery_score',
        'price_score',
        'service_score',
        'total_score',
        'rating',
        'comments',
        'evaluated_by',
    ];
}