<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'capa_number',
        'capa_date',
        'capa_type',
        'ncr_id',
        'root_cause',
        'corrective_action',
        'preventive_action',
        'assigned_to',
        'due_date',
        'completed_date',
        'verified_by',
        'status',
    ];
}