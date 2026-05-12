<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerInquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'inquiry_number',
        'inquiry_date',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'channel',
        'subject',
        'description',
        'assigned_to',
        'status',
        'follow_up_date',
    ];
}