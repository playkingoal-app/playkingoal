<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pronostico extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'pronosticos';

    protected $fillable = ['jugador','partido','golesLocal','golesVisitante','ganador','puntos'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jugadore()
    {
        return $this->hasOne('App\Models\Jugadore', 'id', 'jugador');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function partido()
    {
        return $this->hasOne('App\Models\Partido', 'id', 'partido');
    }
    
}
