<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MwoSparePart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'maintenance_work_order_id',
        'product_id',
        'quantity',
        'unit_id',
        'unit_cost',
        'total_cost',
    ];
}