<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialReturn extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'return_number',
        'return_date',
        'return_type',
        'job_card_id',
        'department_id',
        'warehouse_id',
        'status',
        'returned_by',
        'approved_by',
        'notes',
    ];
}