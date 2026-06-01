<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Jornada;
use App\Models\Torneo;

class Jornadas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selected_id, $keyWord, $descripcion, $valor_puntaje_me, $valor_puntaje_g, $torneo_id;
    public $torneoSeleccionado = null;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $userId = auth()->id();

        $torneosUsuario = Torneo::join('grupos', 'grupos.id', '=', 'torneos.grupo_id')
            ->where('grupos.propietario_id', $userId)
            ->select('torneos.*')
            ->orderBy('torneos.nombre_torneo', 'asc')
            ->get();

        return view('livewire.jornadas.view', [
            'jornadas' => Jornada::select('jornadas.*', 'torneos.nombre_torneo')
                ->join('torneos', 'torneos.id', '=', 'jornadas.torneo_id')
                ->join('grupos', 'grupos.id', '=', 'torneos.grupo_id')
                ->where('grupos.propietario_id', $userId)
                ->when($this->torneoSeleccionado, function ($query) {
                    $query->where('jornadas.torneo_id', $this->torneoSeleccionado);
                })
                ->where(function ($query) use ($keyWord) {
                    $query->where('jornadas.descripcion', 'LIKE', $keyWord)
                        ->orWhere('jornadas.valor_puntaje_me', 'LIKE', $keyWord)
                        ->orWhere('jornadas.valor_puntaje_g', 'LIKE', $keyWord)
                        ->orWhere('torneos.nombre_torneo', 'LIKE', $keyWord);
                })
                ->latest('jornadas.id')
                ->paginate(10),

            'torneos' => $torneosUsuario,
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->descripcion = null;
        $this->valor_puntaje_me = null;
        $this->valor_puntaje_g = null;
        $this->torneo_id = null;
    }

    public function store()
    {
        $this->validate([
            'torneo_id' => 'required',
            'descripcion' => 'required',
            'valor_puntaje_me' => ['required', 'integer'],
            'valor_puntaje_g' => ['required', 'integer'],
        ]);

        $torneoPermitido = Torneo::join('grupos', 'grupos.id', '=', 'torneos.grupo_id')
            ->where('grupos.propietario_id', auth()->id())
            ->where('torneos.id', $this->torneo_id)
            ->exists();

        if (!$torneoPermitido) {
            abort(403);
        }

        Jornada::create([
            'torneo_id' => $this->torneo_id,
            'descripcion' => ucwords(mb_strtolower($this->descripcion)),
            'valor_puntaje_me' => $this->valor_puntaje_me,
            'valor_puntaje_g' => $this->valor_puntaje_g
        ]);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('message', 'Jornada creada con éxito.');
    }

    public function edit($id)
    {
        $record = Jornada::join('torneos', 'torneos.id', '=', 'jornadas.torneo_id')
            ->join('grupos', 'grupos.id', '=', 'torneos.grupo_id')
            ->where('grupos.propietario_id', auth()->id())
            ->where('jornadas.id', $id)
            ->select('jornadas.*')
            ->firstOrFail();

        $this->selected_id = $id;
        $this->descripcion = $record->descripcion;
        $this->valor_puntaje_me = $record->valor_puntaje_me;
        $this->valor_puntaje_g = $record->valor_puntaje_g;
    }

    public function update()
    {
        $this->validate([
            'descripcion' => 'required',
            'valor_puntaje_me' => 'required|integer',
            'valor_puntaje_g' => 'required|integer',
        ]);

        if ($this->selected_id) {
            $record = Jornada::join('torneos', 'torneos.id', '=', 'jornadas.torneo_id')
                ->join('grupos', 'grupos.id', '=', 'torneos.grupo_id')
                ->where('grupos.propietario_id', auth()->id())
                ->where('jornadas.id', $this->selected_id)
                ->select('jornadas.*')
                ->firstOrFail();

            $record->update([
                'descripcion' => $this->descripcion,
                'valor_puntaje_me' => $this->valor_puntaje_me,
                'valor_puntaje_g' => $this->valor_puntaje_g
            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');
            session()->flash('message', 'Jornada actualizada con éxito.');
        }
    }

    public function destroy($id)
    {
        $record = Jornada::join('torneos', 'torneos.id', '=', 'jornadas.torneo_id')
            ->join('grupos', 'grupos.id', '=', 'torneos.grupo_id')
            ->where('grupos.propietario_id', auth()->id())
            ->where('jornadas.id', $id)
            ->select('jornadas.*')
            ->firstOrFail();

        $record->delete();
    }
}