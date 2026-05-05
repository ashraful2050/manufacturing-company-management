<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlanketPurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'bpo_number',
        'bpo_date',
        'supplier_id',
        'currency_id',
        'total_value',
        'amount_released',
        'balance_value',
        'valid_from',
        'valid_to',
        'payment_terms',
        'status',
        'created_by',
    ];
}