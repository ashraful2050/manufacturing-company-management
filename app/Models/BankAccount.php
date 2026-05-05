<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'account_name',
        'account_number',
        'account_type',
        'bank_name',
        'branch_name',
        'ifsc_code',
        'swift_code',
        'currency_id',
        'opening_balance',
        'current_balance',
        'is_active',
    ];
}