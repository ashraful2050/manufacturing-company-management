<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionRouteOperation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'production_route_id',
        'operation_name',
        'operation_code',
        'sequence',
        'machine_id',
        'setup_time',
        'cycle_time',
        'is_active',
    ];
}