<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierRateContractItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_rate_contract_id',
        'product_id',
        'unit_id',
        'unit_price',
        'min_quantity',
        'max_quantity',
    ];
}