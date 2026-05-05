<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockCountItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stock_count_session_id',
        'product_id',
        'bin_location_id',
        'book_qty',
        'counted_qty',
        'variance_qty',
        'unit_id',
        'unit_cost',
        'variance_amount',
    ];
}