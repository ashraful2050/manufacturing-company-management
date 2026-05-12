<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'program_name',
        'training_type',
        'description',
        'start_date',
        'end_date',
        'duration_hours',
        'trainer_name',
        'venue',
        'max_participants',
        'cost',
        'status',
    ];
}