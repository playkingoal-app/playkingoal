<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'planes';
    protected $fillable = [
        'nombre',
        'precio',
        'max_grupos',
        'max_usuarios_por_grupo',
        'periodo',
        'activo',
    ];

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }
    public function prices()
{
    return $this->hasMany(PlanPrice::class);
}

public function priceForCountry(string $countryCode)
{
    return $this->prices()
        ->where('country_code', strtoupper($countryCode))
        ->where('active', true)
        ->first()
        ?? $this->prices()
            ->where('country_code', 'US')
            ->where('active', true)
            ->first();
}
}
