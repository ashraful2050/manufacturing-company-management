<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialIssue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'issue_number',
        'issue_date',
        'issue_type',
        'store_requisition_id',
        'job_card_id',
        'department_id',
        'warehouse_id',
        'status',
        'issued_by',
        'approved_by',
        'notes',
    ];
}