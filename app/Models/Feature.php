<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'module', 'feature_key', 'feature_name', 'description', 'icon', 'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_features')
            ->withPivot('is_enabled', 'limit_value')
            ->withTimestamps();
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
