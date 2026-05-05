<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialReturnItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'material_return_id',
        'product_id',
        'quantity',
        'unit_id',
        'condition',
        'bin_location_id',
    ];
}