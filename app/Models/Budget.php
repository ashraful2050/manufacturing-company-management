<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'budget_number',
        'budget_name',
        'budget_year',
        'budget_type',
        'total_amount',
        'utilized_amount',
        'balance_amount',
        'status',
        'approved_by',
        'created_by',
    ];
}