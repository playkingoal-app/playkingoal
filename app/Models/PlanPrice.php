<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanPrice extends Model
{
    protected $fillable = [
        'plan_id',
        'country_code',
        'currency',
        'amount',
        'active',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}