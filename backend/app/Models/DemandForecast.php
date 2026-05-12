<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemandForecast extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'forecast_number',
        'forecast_period',
        'year',
        'month',
        'quarter',
        'product_id',
        'customer_id',
        'territory_id',
        'forecast_qty',
        'actual_qty',
        'forecast_method',
        'created_by',
    ];
}