<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'company_id', 'user_type', 'action', 'table_name',
        'record_id', 'record_label', 'old_values', 'new_values',
        'ip_address', 'user_agent', 'url',
    ];
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
