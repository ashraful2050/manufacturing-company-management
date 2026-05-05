<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialIssueItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'material_issue_id',
        'product_id',
        'quantity',
        'unit_id',
        'unit_cost',
        'total_cost',
        'bin_location_id',
        'batch_number',
    ];
}