<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatePassItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gate_pass_id',
        'product_id',
        'description',
        'quantity',
        'unit_id',
        'serial_number',
        'remarks',
    ];
}