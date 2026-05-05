<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankReconciliationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bank_reconciliation_id',
        'transaction_date',
        'description',
        'transaction_type',
        'book_amount',
        'statement_amount',
        'is_reconciled',
        'remarks',
    ];
}