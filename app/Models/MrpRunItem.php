<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MrpRunItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mrp_run_id',
        'product_id',
        'required_qty',
        'available_qty',
        'shortfall_qty',
        'unit_id',
        'required_date',
        'action_recommendation',
    ];
}