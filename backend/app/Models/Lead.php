<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'lead_number',
        'title',
        'lead_source',
        'status',
        'priority',
        'customer_name',
        'customer_email',
        'customer_phone',
        'estimated_value',
        'territory_id',
        'assigned_to',
        'description',
        'expected_close_date',
    ];
}