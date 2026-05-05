<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'company_id', 'product_code', 'name', 'category_id', 'type', 'brand', 'model',
        'description', 'image', 'specifications', 'warranty_months',
        'is_serial_tracked', 'is_batch_tracked',
        'price_mrp', 'price_dealer', 'price_wholesale', 'price_project', 'cost_price',
        'unit', 'is_active',
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_serial_tracked' => 'boolean',
        'is_batch_tracked' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function company() { return $this->belongsTo(Company::class); }
    public function category() { return $this->belongsTo(ProductCategory::class); }
    public function boms() { return $this->hasMany(Bom::class); }
    public function currentBom() { return $this->hasOne(Bom::class)->where('is_current', true); }
}
