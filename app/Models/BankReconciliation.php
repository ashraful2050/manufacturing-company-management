<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankReconciliation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'bank_account_id',
        'reconciliation_number',
        'reconciliation_date',
        'statement_date',
        'statement_balance',
        'book_balance',
        'difference',
        'status',
        'reconciled_by',
    ];
}