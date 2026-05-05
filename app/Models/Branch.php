<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'company_id', 'name', 'code', 'type', 'address', 'city', 'phone', 'email', 'manager_id', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function company() { return $this->belongsTo(Company::class); }
    public function manager() { return $this->belongsTo(User::class, 'manager_id'); }
    public function warehouses() { return $this->hasMany(Warehouse::class); }
}
