<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MpsItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mps_id',
        'product_id',
        'planned_qty',
        'confirmed_qty',
        'produced_qty',
        'production_line_id',
        'planned_from',
        'planned_to',
    ];
}