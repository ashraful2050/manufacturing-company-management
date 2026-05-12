<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCommunication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'customer_id',
        'communication_type',
        'direction',
        'subject',
        'content',
        'communication_date',
        'reference_type',
        'reference_id',
        'created_by',
    ];
}