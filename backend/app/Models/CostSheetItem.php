<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostSheetItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cost_sheet_id',
        'cost_category',
        'item_name',
        'quantity',
        'unit_id',
        'rate',
        'amount',
    ];
}