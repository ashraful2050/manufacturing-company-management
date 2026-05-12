<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'registration_number',
        'vehicle_type',
        'make',
        'model',
        'year',
        'capacity',
        'capacity_uom',
        'fuel_type',
        'transporter_id',
        'driver_name',
        'driver_phone',
        'status',
        'is_active',
    ];
}