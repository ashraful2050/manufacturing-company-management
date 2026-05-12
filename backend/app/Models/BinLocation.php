<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BinLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'warehouse_id',
        'bin_code',
        'zone',
        'row',
        'rack',
        'level',
        'bin_type',
        'max_capacity',
        'current_quantity',
        'is_active',
    ];
}