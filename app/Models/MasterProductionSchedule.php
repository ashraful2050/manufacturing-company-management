<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProductionSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'mps_number',
        'period',
        'year',
        'month',
        'quarter',
        'from_date',
        'to_date',
        'status',
        'approved_by',
        'created_by',
    ];
}