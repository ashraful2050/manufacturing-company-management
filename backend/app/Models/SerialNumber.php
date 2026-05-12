<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerialNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'product_id',
        'serial_number',
        'batch_number',
        'expiry_date',
        'manufacture_date',
        'status',
        'reference_type',
        'reference_id',
    ];
}