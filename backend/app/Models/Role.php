<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'company_id', 'name', 'slug', 'description', 'is_system_role',
    ];

    protected $casts = ['is_system_role' => 'boolean'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
