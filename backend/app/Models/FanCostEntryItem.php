<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FanCostEntryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fan_cost_entry_id',
        'sort_order',
        'name_bn',
        'name_en',
        'category',
        'qty',
        'unit_price',
        'appreciation',
        'source',
        'amount',
    ];

    protected $casts = [
        'qty'          => 'float',
        'unit_price'   => 'float',
        'appreciation' => 'float',
        'amount'       => 'float',
    ];

    public function entry()
    {
        return $this->belongsTo(FanCostEntry::class, 'fan_cost_entry_id');
    }
}
