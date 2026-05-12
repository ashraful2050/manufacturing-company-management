<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_id',
        'product_id',
        'description',
        'quantity',
        'unit_id',
        'unit_price',
        'discount_percentage',
        'discount_amount',
        'tax_rate_id',
        'tax_amount',
        'total_amount',
    ];
}