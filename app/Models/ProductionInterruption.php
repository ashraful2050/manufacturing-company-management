<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionInterruption extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'interruption_number',
        'job_card_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'reason',
        'action_taken',
        'status',
    ];
}