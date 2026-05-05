<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReturn extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'return_number',
        'return_date',
        'supplier_id',
        'grn_id',
        'purchase_order_id',
        'return_reason',
        'total_amount',
        'notes',
        'status',
        'created_by',
    ];
}