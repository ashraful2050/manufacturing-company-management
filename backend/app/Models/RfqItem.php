<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RfqItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rfq_id',
        'product_id',
        'description',
        'quantity',
        'unit_id',
        'target_price',
        'required_date',
    ];
}