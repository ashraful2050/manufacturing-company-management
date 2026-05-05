<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreRequisitionItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_requisition_id',
        'product_id',
        'required_quantity',
        'issued_quantity',
        'pending_quantity',
        'unit_id',
    ];
}