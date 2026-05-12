<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreRequisition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'requisition_number',
        'requisition_date',
        'required_date',
        'department_id',
        'job_card_id',
        'priority',
        'purpose',
        'status',
        'requested_by',
        'approved_by',
    ];
}