<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountPolicy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'code',
        'policy_type',
        'discount_type',
        'discount_value',
        'min_order_value',
        'min_order_qty',
        'applicable_for',
        'is_active',
    ];
}