<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'torneos';

    protected $fillable = ['nombre_torneo','precio','fecha_inicio','fecha_fin','activo','api_league_id','grupo_id'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inscripciones()
    {
        return $this->hasMany('App\Models\Inscripcione', 'torneo_id', 'id');
    }
    public function apiLeague()
{
    return $this->belongsTo(ApiLeague::class);
}
public function partidos()
{
    return $this->hasMany(Partido::class);
}
 public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
