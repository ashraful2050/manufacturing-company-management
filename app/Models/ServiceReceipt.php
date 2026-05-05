<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceReceipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'receipt_number',
        'receipt_date',
        'purchase_order_id',
        'supplier_id',
        'service_description',
        'amount',
        'status',
        'created_by',
    ];
}