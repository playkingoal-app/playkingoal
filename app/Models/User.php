<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use App\Models\Grupo;
use App\Models\Country;
use App\Models\Suscripcione;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'username',
        'country_id',
        'puntos',
        'puntos_aux',
        'total',
        'password',
        'referido',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function inscripciones()
    {
        return $this->hasMany(\App\Models\Inscripcione::class, 'usuario_id', 'id');
    }

    public function tieneInscripcionActiva()
    {
        return $this->inscripciones()->where('estado_pago', 'activo')->exists();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->cod_invitacion) {
                $user->cod_invitacion = strtoupper(Str::random(6));
            }
        });
    }

  public function grupos()
{
    return $this->belongsToMany(
        Grupo::class,
        'grupo_usuario',
        'usuario_id',
        'grupo_id'
    )
    ->withPivot('rol', 'estado')
    ->withTimestamps();
}

    public function suscripciones()
    {
        return $this->hasMany(Suscripcione::class, 'user_id', 'id');
    }

    public function suscripcionActiva()
    {
        return $this->hasOne(Suscripcione::class, 'user_id', 'id')
            ->where('estado', 'activa');
    }

    public function tieneSuscripcionActiva(): bool
    {
        return $this->suscripciones()->where('estado', 'activa')->exists();
    }
}