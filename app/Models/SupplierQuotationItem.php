<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierQuotationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_quotation_id',
        'rfq_item_id',
        'product_id',
        'quantity',
        'unit_id',
        'unit_price',
        'discount_percentage',
        'tax_rate_id',
        'tax_amount',
        'total_amount',
        'lead_time_days',
    ];
}