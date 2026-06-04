<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcione extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'estado',
        'inicia_en',
        'vence_en',
          'stripe_session_id',
    'stripe_payment_intent_id',
    ];

    protected $dates = ['inicia_en', 'vence_en'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function activa()
    {
        return $this->estado === 'activa'
            && now()->between($this->inicia_en, $this->vence_en);
    }
}
