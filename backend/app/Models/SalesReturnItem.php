<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesReturnItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sales_return_id',
        'product_id',
        'quantity',
        'unit_id',
        'unit_price',
        'condition',
        'action_taken',
        'restocked_qty',
    ];
}