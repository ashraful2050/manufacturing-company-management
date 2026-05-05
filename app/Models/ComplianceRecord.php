<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplianceRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'record_number',
        'compliance_type',
        'regulation_body',
        'description',
        'compliance_date',
        'due_date',
        'responsible_person_id',
        'action_taken',
        'documents_path',
        'status',
        'verified_by',
        'verified_at',
    ];
}