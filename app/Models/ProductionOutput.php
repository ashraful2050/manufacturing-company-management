<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionOutput extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'output_number',
        'output_date',
        'job_card_id',
        'product_id',
        'output_qty',
        'rejected_qty',
        'warehouse_id',
        'bin_location_id',
        'batch_number',
        'created_by',
    ];
}