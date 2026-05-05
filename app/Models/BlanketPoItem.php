<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlanketPoItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blanket_po_id',
        'product_id',
        'total_quantity',
        'released_quantity',
        'balance_quantity',
        'unit_id',
        'unit_price',
    ];
}