<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Torneo;
class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'nombre',
        'slug',
        'codigo_invitacion',
        'propietario_id',
        'activo',
        'requisito_entrada',
        'premio',
    ];
    public function usuarios()
{
    return $this->belongsToMany(User::class, 'grupo_usuario')
        ->withPivot('rol', 'estado')
        ->withTimestamps();
}
  public function torneos()
    {
        return $this->hasMany(Torneo::class);
    }
     public function esAdmin($userId)
    {
        return $this->usuarios()
            ->wherePivot('rol', 'admin')
            ->where('users.id', $userId)
            ->exists();
    }
}
