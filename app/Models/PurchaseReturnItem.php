<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReturnItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_return_id',
        'product_id',
        'quantity',
        'unit_id',
        'unit_price',
        'total_amount',
        'return_reason',
    ];
}