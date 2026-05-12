<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesReturn extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'return_number',
        'return_date',
        'customer_id',
        'invoice_id',
        'sales_order_id',
        'return_reason',
        'quality_check_done',
        'refund_type',
        'total_amount',
        'status',
        'created_by',
    ];
}