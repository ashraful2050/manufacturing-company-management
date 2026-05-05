<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'budget_id',
        'budget_head_id',
        'cost_center_id',
        'annual_amount',
        'q1_amount',
        'q2_amount',
        'q3_amount',
        'q4_amount',
        'utilized_amount',
    ];
}