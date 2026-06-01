<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcione extends Model
{
    use HasFactory;
    
    public $timestamps = true;

    protected $table = 'inscripciones';

    protected $fillable = ['usuario_id', 'torneo_id','comprobante', 'estado_pago' ,'grupo_id'];

    /**
     * Relación con el torneo
     * inscripciones.torneo -> torneos.id
     */
    public function torneo()
    {
         return $this->belongsTo(\App\Models\Torneo::class, 'torneo_id', 'id');
    }
    
    /**
     * Relación con el usuario
     * inscripciones.usuario -> users.id
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id', 'id');
    }
     public function grupo()
    {
        return $this->belongsTo(\App\Models\Grupo::class,'grupo_id', 'id');
    }
    protected static function booted()
{
    static::created(function ($inscripcion) {

        $partidos = Partido::where('torneo_id', $inscripcion->torneo_id)->get();

        foreach ($partidos as $partido) {
            Pronostico::firstOrCreate([
                'jugador' => $inscripcion->usuario_id,
                'partido' => $partido->id,
            ], [
                'golesLocal' => null,
                'golesVisitante' => null,
                'ganador' => null,
            ]);
        }
    });
}

}
