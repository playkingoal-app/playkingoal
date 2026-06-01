<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Torneo;
use App\Models\Pronostico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Posiciones extends Component
{
    public $torneo_id;
    public $torneos;

    public function mount()
    {
        $this->torneos = Torneo::whereHas('inscripciones', function ($q) {
            $q->where('usuario_id', Auth::id())
              ->where('activo', 1);
        })->get();
    }

    public function render()
    {
        return view('livewire.posiciones.view', [
            'posiciones' => $this->posiciones(),
            'torneos' => $this->torneos,
        ]);
    }

    protected function posiciones()
    {
        if (!$this->torneo_id) {
            return collect();
        }

        return Pronostico::select(
                'users.id',
                'users.name',
                 'users.country_id',

                DB::raw('SUM(pronosticos.puntos) as total'),

                DB::raw('SUM(CASE 
                    WHEN pronosticos.golesLocal = resultados.golesLocal
                    AND pronosticos.golesVisitante = resultados.golesVisitante
                    THEN 1 ELSE 0 
                END) as exactos'),

                DB::raw('SUM(CASE 
                    WHEN (
                        (pronosticos.golesLocal > pronosticos.golesVisitante AND resultados.golesLocal > resultados.golesVisitante)
                        OR
                        (pronosticos.golesLocal < pronosticos.golesVisitante AND resultados.golesLocal < resultados.golesVisitante)
                        OR
                        (pronosticos.golesLocal = pronosticos.golesVisitante AND resultados.golesLocal = resultados.golesVisitante)
                    )
                    THEN 1 ELSE 0 
                END) as ganadores'),

                DB::raw('
                    SUM(CASE 
                        WHEN pronosticos.golesLocal = resultados.golesLocal
                        THEN 1 ELSE 0 
                    END)
                    +
                    SUM(CASE 
                        WHEN pronosticos.golesVisitante = resultados.golesVisitante
                        THEN 1 ELSE 0 
                    END)
                    as goles_acertados
                ')
            )
            ->join('users', 'users.id', '=', 'pronosticos.jugador')
            ->join('partidos', 'partidos.id', '=', 'pronosticos.partido')
            ->join('resultados', 'resultados.partido', '=', 'partidos.id')
            ->where('partidos.torneo_id', $this->torneo_id)
            ->whereIn('partidos.estado', ['FT', 'AET', 'PEN'])
            ->whereNotNull('pronosticos.golesLocal')
            ->whereNotNull('pronosticos.golesVisitante')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->orderByDesc('exactos')
            ->orderByDesc('ganadores')
            ->orderByDesc('goles_acertados')
            ->orderBy('users.name')
            ->get();
    }
}