<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Allpronosticos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedTorneo = null;

    public function mount()
    {
        $primerTorneo = DB::table('inscripciones')
            ->where('usuario_id', auth()->id())
            ->value('torneo_id');

        $this->selectedTorneo = $primerTorneo;
    }

    public function updatedSelectedTorneo()
    {
        $this->resetPage();
    }

    public function render()
    {
        $torneos = DB::table('torneos')
            ->join('inscripciones', 'inscripciones.torneo_id', '=', 'torneos.id')
            ->where('inscripciones.usuario_id', auth()->id())
            ->select('torneos.id', 'torneos.nombre_torneo')
            ->get();

        $torneosIds = $torneos->pluck('id');

        $pronosticos = collect();

        if ($this->selectedTorneo && $torneosIds->contains($this->selectedTorneo)) {
            $pronosticos = DB::table('pronosticos')
                ->join('users', 'users.id', '=', 'pronosticos.jugador')
                ->join('partidos', 'partidos.id', '=', 'pronosticos.partido')
                ->join('equipos as local', 'local.id', '=', 'partidos.idEquipoLocal')
                ->join('equipos as visitante', 'visitante.id', '=', 'partidos.idEquipoVisitante')
                ->join('inscripciones', function ($join) {
                    $join->on('inscripciones.usuario_id', '=', 'pronosticos.jugador')
                        ->on('inscripciones.torneo_id', '=', 'partidos.torneo_id');
                })
                ->where('partidos.torneo_id', $this->selectedTorneo)
                ->whereNotIn('partidos.estado', [
                    'NS', 'TBD', 'PST', 'CANC', 'ABD', 'AWD', 'WO'
                ])
                ->select(
                    'users.name as user_name',
                    'pronosticos.id',
                    'pronosticos.golesLocal',
                    'pronosticos.golesVisitante',
                    'pronosticos.ganador',
                    'partidos.estado',
                    'partidos.id as partido_id',
                    'local.name as local_name',
                    'visitante.name as visitante_name'
                )
                ->orderBy('partidos.id', 'desc')
                ->get();
        }

        return view('livewire.allpronosticos.view', [
            'torneos' => $torneos,
            'pronosticos' => $pronosticos,
        ]);
    }
}