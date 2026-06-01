<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'jornadas';

    protected $fillable = [ 'torneo_id','descripcion','valor_puntaje_me','valor_puntaje_g'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partidos()
    {
        return $this->hasMany('App\Models\Partido', 'jornada_id', 'id');
    }
    public function torneo()
    {
         return $this->belongsTo(\App\Models\Torneo::class, 'torneo_id', 'id');
    }
}
