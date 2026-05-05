<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalibrationSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'machine_id',
        'instrument_name',
        'calibration_standard',
        'agency',
        'last_calibration_date',
        'next_due_date',
        'calibration_frequency',
        'certificate_number',
        'valid_until',
        'status',
    ];
}