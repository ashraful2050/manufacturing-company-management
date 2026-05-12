<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'contract_number',
        'customer_id',
        'start_date',
        'end_date',
        'contract_value',
        'currency_id',
        'payment_terms',
        'delivery_terms',
        'status',
        'signed_date',
        'created_by',
    ];
}