<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = ['company_id', 'name', 'symbol', 'unit_type', 'conversion_factor', 'base_unit_id', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'conversion_factor' => 'decimal:6'];

    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function baseUnit(): BelongsTo { return $this->belongsTo(Unit::class, 'base_unit_id'); }
    public function subUnits(): HasMany { return $this->hasMany(Unit::class, 'base_unit_id'); }
}
