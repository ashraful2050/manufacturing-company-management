<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierQuotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'rfq_id',
        'supplier_id',
        'quotation_number',
        'quotation_date',
        'valid_until',
        'currency_id',
        'subtotal',
        'tax_amount',
        'total_amount',
        'delivery_terms',
        'payment_terms',
        'status',
        'notes',
    ];
}