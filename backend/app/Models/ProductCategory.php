<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['company_id', 'name', 'slug', 'parent_id'];

    public function company() { return $this->belongsTo(Company::class); }
    public function parent() { return $this->belongsTo(ProductCategory::class, 'parent_id'); }
    public function children() { return $this->hasMany(ProductCategory::class, 'parent_id'); }
    public function products() { return $this->hasMany(Product::class, 'category_id'); }
}
