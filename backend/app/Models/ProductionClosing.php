<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionClosing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'closing_number',
        'closing_date',
        'closing_period',
        'year',
        'month',
        'status',
        'closed_by',
    ];
}