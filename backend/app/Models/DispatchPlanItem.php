<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchPlanItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dispatch_plan_id',
        'sales_order_id',
        'delivery_challan_id',
        'customer_id',
        'product_id',
        'quantity',
        'unit_id',
        'weight_kg',
        'volume_cbm',
    ];
}