<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesCommission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'commission_setup_id',
        'employee_id',
        'reference_type',
        'reference_id',
        'sale_amount',
        'commission_rate',
        'commission_amount',
        'status',
    ];
}