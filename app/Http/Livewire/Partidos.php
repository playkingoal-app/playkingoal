<?php

namespace App\Http\Livewire;

use App\Models\Torneo;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Partido;
use App\Models\Equipo;
use App\Models\Resultado;
use App\Models\Pronostico;
use App\Models\User;
use App\Models\Jornada;


class Partidos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $idEquipoLocal, $idEquipoVisitante, $jornada_id, $torneo_id, $fecha_hora;
    public function updatedTorneoSeleccionado()
    {
        // Cuando cambia el torneo, reiniciamos la jornada seleccionada
        $this->torneo_id = 0;
    }
    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $equipos = Equipo::all();
        $torneos = Torneo::all();
        $jornadas = Jornada::where('torneo_id', $this->torneo_id)->get();


        return view('livewire.partidos.view', [
            'partidos' => Partido::latest()
                ->when($this->torneo_id, function ($query) {
                    $query->where('torneo_id', $this->torneo_id);
                })
                ->where(function ($query) use ($keyWord) {
                    $query->where('idEquipoLocal', 'LIKE', $keyWord)
                        ->orWhere('idEquipoVisitante', 'LIKE', $keyWord);
                })
                ->paginate(8),
        ], compact('equipos', 'jornadas', 'torneos'));

    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->idEquipoLocal = null;
        $this->idEquipoVisitante = null;
        $this->jornada_id = null;
        $this->torneo_id = null;


    }

    public function store()
    {
        $this->validate([
            'idEquipoLocal' => 'required',
            'idEquipoVisitante' => 'required',
            'jornada_id' => 'required',
            'fecha_hora' => 'required',
            'torneo_id' => 'required',


        ]);

        Partido::create([
            'idEquipoLocal' => $this->idEquipoLocal,
            'idEquipoVisitante' => $this->idEquipoVisitante,
            'estado' => 0,
            'jornada_id' => $this->jornada_id,
            'fecha_hora' => $this->fecha_hora,
            'torneo_id' => $this->torneo_id,


        ]);
        $partido = Partido::latest('created_at')->pluck('id')->first();
        Resultado::create([
            'partido' => $partido,
            'golesLocal' => null,
            'golesVisitante' => null,
            'ganador' => null
        ]);
        $jugadores = User::all()->pluck('id');
       foreach ($jugadores as $i) {


            Pronostico::create([
                'jugador' => $i,
                'partido' => $partido,
                'golesLocal' => null,
                'golesVisitante' => null,
                'ganador' => null


            ]);
        }

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('message', 'Partido creado con éxito.');
    }

    public function edit($id)
    {
        $record = Partido::findOrFail($id);
        $this->selected_id = $id;
        $this->idEquipoLocal = $record->idEquipoLocal;
        $this->idEquipoVisitante = $record->idEquipoVisitante;
        $this->torneo_id = $record->torneo_id;
        $this->jornada_id = $record->jornada_id;
        $this->fecha_hora = $record->fecha_hora;


    }

    public function update()
    {
        $this->validate([
            'idEquipoLocal' => 'required',
            'idEquipoVisitante' => 'required',
        ]);

        if ($this->selected_id) {
            $record = Partido::find($this->selected_id);
            $record->update([
                'idEquipoLocal' => $this->idEquipoLocal,
                'idEquipoVisitante' => $this->idEquipoVisitante,
                'jornada_id' => $this->jornada_id,
                'fecha_hora' => $this->fecha_hora,
                'torneo_id' => $this->torneo_id



            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');
            session()->flash('message', 'Partido actualizado con éxito.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            Partido::where('id', $id)->delete();
        }
    }
}