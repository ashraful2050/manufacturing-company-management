<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatePass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'gate_pass_number',
        'pass_date',
        'pass_type',
        'party_type',
        'party_id',
        'party_name',
        'vehicle_number',
        'driver_name',
        'driver_phone',
        'transporter_id',
        'purpose',
        'returnable_by',
        'status',
        'created_by',
        'approved_by',
    ];
}