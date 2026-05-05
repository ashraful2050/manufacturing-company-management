<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockCountSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'session_number',
        'count_date',
        'count_type',
        'warehouse_id',
        'category_id',
        'status',
        'counted_by',
        'verified_by',
        'posted_at',
        'notes',
    ];
}