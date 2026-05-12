<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FanCostEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'entry_number',
        'entry_date',
        'fan_model',
        'title',
        'quantity',
        'selling_price',
        'total_material_cost',
        'total_labor_cost',
        'total_overhead_cost',
        'total_packing_cost',
        'total_other_cost',
        'total_cost',
        'unit_cost',
        'gross_profit',
        'gross_margin_pct',
        'status',
        'created_by',
    ];

    protected $casts = [
        'entry_date'           => 'date',
        'quantity'             => 'float',
        'selling_price'        => 'float',
        'total_material_cost'  => 'float',
        'total_labor_cost'     => 'float',
        'total_overhead_cost'  => 'float',
        'total_packing_cost'   => 'float',
        'total_other_cost'     => 'float',
        'total_cost'           => 'float',
        'unit_cost'            => 'float',
        'gross_profit'         => 'float',
        'gross_margin_pct'     => 'float',
    ];

    public function items()
    {
        return $this->hasMany(FanCostEntryItem::class)->orderBy('sort_order');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
