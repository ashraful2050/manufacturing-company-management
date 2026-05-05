<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestForQuotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'rfq_number',
        'rfq_date',
        'required_date',
        'purchase_requisition_id',
        'currency_id',
        'notes',
        'status',
        'created_by',
    ];
}