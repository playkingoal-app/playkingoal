<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pronostico;
use App\Models\Partido;
use Illuminate\Support\Facades\DB;

class Pronosticos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selected_id;
    public $jugador;
    public $partido;
    public $golesLocal;
    public $golesVisitante;
    public $ganador;

    public $jornada = 0;
    public $torneoSeleccionado = null;

    public $localNombre;
    public $localLogo;
    public $visitanteNombre;
    public $visitanteLogo;
    public $partidoBloqueado = false;

    public function updatedTorneoSeleccionado()
    {
        $this->jornada = 0;
        $this->resetInput();
    }

    public function render()
    {
        $torneos = DB::table('inscripciones')
            ->join('torneos', 'torneos.id', '=', 'inscripciones.torneo_id')
            ->where('inscripciones.usuario_id', auth()->id())
            ->where('inscripciones.estado_pago', 'activo')
            ->select('torneos.id', 'torneos.nombre_torneo')
            ->get();

        $jornadas = collect();

        if ($this->torneoSeleccionado) {
            $jornadas = DB::table('jornadas')
                ->where('torneo_id', $this->torneoSeleccionado)
                ->orderBy('id')
                ->get();
        }

        $pronosticosJornada = collect();

        if ($this->jornada && $this->torneoSeleccionado) {
            $pronosticosJornada = DB::table('pronosticos')
                ->join('partidos', 'partidos.id', '=', 'pronosticos.partido')
                ->join('jornadas', 'jornadas.id', '=', 'partidos.jornada_id')
                ->join('torneos', 'torneos.id', '=', 'jornadas.torneo_id')
                ->join('equipos as local', 'local.id', '=', 'partidos.idEquipoLocal')
                ->join('equipos as visitante', 'visitante.id', '=', 'partidos.idEquipoVisitante')
                ->join('inscripciones', function ($join) {
                    $join->on('inscripciones.torneo_id', '=', 'torneos.id')
                        ->where('inscripciones.usuario_id', auth()->id());
                })
                ->select(
                    'pronosticos.id',
                    'pronosticos.golesLocal',
                    'pronosticos.golesVisitante',
                    'pronosticos.ganador',
                    'partidos.id as partido',
                    'partidos.fecha_hora',
                    'partidos.estado',
                    'partidos.idEquipoLocal',
                    'partidos.idEquipoVisitante',
                    'local.name as local_nombre',
                    'local.logo as local_logo',
                    'visitante.name as visitante_nombre',
                    'visitante.logo as visitante_logo',
                    'jornadas.descripcion',
                    'jornadas.id as jornada'
                )
                ->where('pronosticos.jugador', auth()->id())
                ->where('jornadas.id', $this->jornada)
                ->where('torneos.id', $this->torneoSeleccionado)
                ->get();
        }

        return view('livewire.pronosticos.view', [
            'torneos' => $torneos,
            'jornadas' => $jornadas,
            'pronosticosJornada' => $pronosticosJornada,
        ]);
    }

    public function toggleJornada($id)
    {
        $this->jornada = $this->jornada == $id ? 0 : $id;
        $this->resetInput();
    }

    public function edit($id)
    {
        $record = Pronostico::where('jugador', auth()->id())
            ->findOrFail($id);

        $partido = Partido::join('equipos as local', 'local.id', '=', 'partidos.idEquipoLocal')
            ->join('equipos as visitante', 'visitante.id', '=', 'partidos.idEquipoVisitante')
            ->select(
                'partidos.*',
                'local.name as local_nombre',
                'local.logo as local_logo',
                'visitante.name as visitante_nombre',
                'visitante.logo as visitante_logo'
            )
            ->where('partidos.id', $record->partido)
            ->firstOrFail();

        $this->selected_id = $record->id;
        $this->jugador = $record->jugador;
        $this->partido = $record->partido;
        $this->golesLocal = $record->golesLocal;
        $this->golesVisitante = $record->golesVisitante;
        $this->ganador = $record->ganador;

        $this->localNombre = $partido->local_nombre;
        $this->localLogo = $partido->local_logo;
        $this->visitanteNombre = $partido->visitante_nombre;
        $this->visitanteLogo = $partido->visitante_logo;

        $this->partidoBloqueado = $partido->estaBloqueado();

        if ($this->partidoBloqueado) {
            $this->dispatchBrowserEvent('closeModal');
            session()->flash('error', __('pronostics.locked_match'));
        }
    }

    public function pronosticar($pronostico)
    {
        $this->validate([
            'golesLocal' => 'required|integer|min:0',
            'golesVisitante' => 'required|integer|min:0',
        ]);

        $record = Pronostico::where('jugador', auth()->id())
            ->findOrFail($pronostico);

        $partido = Partido::findOrFail($record->partido);

        if ($partido->estaBloqueado()) {
            $this->dispatchBrowserEvent('closeModal');
            session()->flash('error', __('pronostics.locked_match'));
            return;
        }

        if ($this->golesLocal > $this->golesVisitante) {
            $ganador = DB::table('equipos')
                ->where('id', $partido->idEquipoLocal)
                ->value('name');
        } elseif ($this->golesLocal < $this->golesVisitante) {
            $ganador = DB::table('equipos')
                ->where('id', $partido->idEquipoVisitante)
                ->value('name');
        } else {
            $ganador = 'Empate';
        }

        $record->update([
            'jugador' => auth()->id(),
            'partido' => $partido->id,
            'golesLocal' => $this->golesLocal,
            'golesVisitante' => $this->golesVisitante,
            'ganador' => $ganador,
        ]);

        $this->resetInput();
       $this->dispatchBrowserEvent('closePronosticModal');

        session()->flash('message', __('pronostics.success'));
    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->selected_id = null;
        $this->jugador = null;
        $this->partido = null;
        $this->golesLocal = null;
        $this->golesVisitante = null;
        $this->ganador = null;

        $this->localNombre = null;
        $this->localLogo = null;
        $this->visitanteNombre = null;
        $this->visitanteLogo = null;
        $this->partidoBloqueado = false;
    }
}