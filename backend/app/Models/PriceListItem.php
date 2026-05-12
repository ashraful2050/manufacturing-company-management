<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceListItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price_list_id',
        'product_id',
        'unit_price',
        'min_qty',
        'max_qty',
        'discount_percentage',
        'effective_from',
        'effective_to',
    ];
}