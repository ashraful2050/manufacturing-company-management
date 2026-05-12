<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySubscription extends Model
{
    protected $fillable = [
        'company_id', 'plan_id', 'starts_at', 'expires_at',
        'amount_paid', 'payment_method', 'transaction_id', 'status', 'notes',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'expires_at' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
