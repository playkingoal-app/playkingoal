<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'partidos';

    protected $fillable = ['idEquipoLocal','idEquipoVisitante','estado','fecha_hora','jornada_id','torneo_id','api_id','golesLocal','golesVisitante','puntos_calculados', 'ganador'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function equipoLocal()
    {
        return $this->hasOne('App\Models\Equipo', 'id', 'idEquipoLocal');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function equipoVisitante()
    {
        return $this->hasOne('App\Models\Equipo', 'id', 'idEquipoVisitante');
    }

    public function jornada()
    {
        return $this->hasOne('App\Models\Jornada', 'id', 'jornada_id');
    }
     public function torneo()
    {
        return $this->hasOne('App\Models\Torneo', 'id', 'torneo_id');
    }
   public function resultado()
    {
        return $this->hasOne(\App\Models\Resultado::class, 'partido', 'id');
    }
public function pronosticos()
{
    return $this->hasMany(\App\Models\Pronostico::class, 'partido', 'id');
}
protected $casts = [
    'fecha_hora' => 'datetime',
    'puntos_calculados' => 'boolean',
];
 
public function estaBloqueado()
{
    return now()->timestamp >= $this->fecha_hora->timestamp
        || $this->estado !== 'NS';
}
}
