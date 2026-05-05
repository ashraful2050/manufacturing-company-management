<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebitCreditNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'note_number',
        'note_date',
        'note_type',
        'supplier_id',
        'customer_id',
        'reference_type',
        'reference_id',
        'amount',
        'tax_amount',
        'total_amount',
        'reason',
        'description',
        'is_settled',
        'settled_date',
    ];
}