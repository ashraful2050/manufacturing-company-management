<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesTarget extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'target_period',
        'year',
        'month',
        'quarter',
        'target_for',
        'target_type_id',
        'target_name',
        'target_amount',
        'achieved_amount',
        'currency_id',
        'assigned_by',
    ];
}