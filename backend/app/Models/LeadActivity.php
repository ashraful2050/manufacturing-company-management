<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'activity_type',
        'activity_date',
        'description',
        'outcome',
        'next_action',
        'next_action_date',
        'created_by',
    ];
}