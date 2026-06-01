<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Partido;
use App\Models\Inscripcione;
use Illuminate\Support\Facades\Auth;

class Resultados extends Component
{
    public $torneosInscritos;
    public $torneo;

    public $torneoSeleccionadoId;
    public $buscarEquipo = '';
    public $estadoFiltro = '';

    public function mount()
    {
        Partido::with(['equipoLocal', 'equipoVisitante', 'resultado']);
        $this->torneosInscritos = Inscripcione::where('usuario_id', Auth::id())
            ->where('estado_pago', 'activo')
            ->with('torneo')
            ->get()
            ->pluck('torneo')
            ->filter()
            ->values();

        if ($this->torneosInscritos->isEmpty()) {
            $this->torneo = null;
            return;
        }

        $this->torneoSeleccionadoId = $this->torneosInscritos->first()->id;
        $this->cargarTorneo();
    }

    public function updatedTorneoSeleccionadoId()
    {
        $this->buscarEquipo = '';
        $this->estadoFiltro = '';
        $this->cargarTorneo();
    }

    public function cargarTorneo()
    {
        $this->torneo = $this->torneosInscritos
            ->firstWhere('id', (int) $this->torneoSeleccionadoId);
    }

    public function limpiarFiltros()
    {
        $this->buscarEquipo = '';
        $this->estadoFiltro = '';
    }

    public function getPartidosFiltradosProperty()
    {
        if (!$this->torneoSeleccionadoId) {
            return collect();
        }

        return Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('torneo_id', $this->torneoSeleccionadoId)

            ->when($this->buscarEquipo, function ($query) {
                $buscar = $this->buscarEquipo;

                $query->where(function ($q) use ($buscar) {
                    $q->whereHas('equipoLocal', function ($q2) use ($buscar) {
                        $q2->where('name', 'like', '%' . $buscar . '%');
                    })
                    ->orWhereHas('equipoVisitante', function ($q2) use ($buscar) {
                        $q2->where('name', 'like', '%' . $buscar . '%');
                    });
                });
            })

            ->when($this->estadoFiltro, function ($query) {
                if ($this->estadoFiltro === 'LIVE') {
                    $query->whereIn('estado', ['1H', '2H', 'HT', 'LIVE']);
                } elseif ($this->estadoFiltro === 'PENDIENTE') {
                    $query->whereNotIn('estado', ['FT', '1H', '2H', 'HT', 'LIVE']);
                } else {
                    $query->where('estado', $this->estadoFiltro);
                }
            })

            ->orderBy('fecha_hora')
            ->get();
    }

    public function render()
    {
        return view('livewire.resultados.view', [
            'partidosFiltrados' => $this->partidosFiltrados,
        ]);
    }
}