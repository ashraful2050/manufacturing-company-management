<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'quotation_number',
        'quotation_date',
        'valid_until',
        'customer_id',
        'territory_id',
        'price_list_id',
        'currency_id',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'grand_total',
        'terms_and_conditions',
        'status',
        'created_by',
    ];
}