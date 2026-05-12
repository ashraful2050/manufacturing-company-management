<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LicenseCertificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'license_number',
        'license_type',
        'issuing_authority',
        'issue_date',
        'expiry_date',
        'renewal_date',
        'fee_amount',
        'status',
        'reminder_days',
        'documents_path',
    ];
}