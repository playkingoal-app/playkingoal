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
    public function propietario()
{
    return $this->belongsTo(User::class, 'propietario_id');
}
 public function usuarios()
{
    return $this->belongsToMany(
        User::class,
        'grupo_usuario',
        'grupo_id',
        'usuario_id'
    )
    ->withPivot('rol', 'estado')
    ->withTimestamps();
}
  public function torneos()
    {
        return $this->hasMany(Torneo::class);
    }
    public function premios()
{
    return $this->hasMany(GrupoPremio::class)->orderBy('posicion');
}
     public function esAdmin($userId)
    {
        return $this->usuarios()
            ->wherePivot('rol', 'admin')
            ->where('users.id', $userId)
            ->exists();
    }
}
