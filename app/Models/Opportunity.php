<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opportunity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'lead_id',
        'customer_id',
        'territory_id',
        'assigned_to',
        'stage',
        'probability',
        'estimated_value',
        'currency_id',
        'expected_close_date',
        'description',
    ];
}