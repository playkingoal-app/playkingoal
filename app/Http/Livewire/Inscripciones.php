<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Torneo;
use App\Models\Inscripcione;
use Illuminate\Support\Facades\Auth;

class Inscripciones extends Component
{
    use WithFileUploads;

    public $inscripciones;
    public $torneos;
       public $torneoSeleccionadoId = null;

   
   

    public function mount()
    {
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        $this->inscripciones = Inscripcione::with('torneo')
            ->where('usuario_id', Auth::id())
            ->get();

      $this->torneos = Torneo::with('grupo')
    ->whereHas('grupo', function ($query) {
        $query->whereIn('propietario_id', [1, 2]);
    })
    ->get();
    }
public function abrirModalInscripcion($torneoId)
{
    $this->resetErrorBag();
    $this->resetValidation();

    $this->torneoSeleccionadoId = $torneoId;

    $this->dispatchBrowserEvent('openModalInscripcion');
}
    public function seleccionarTorneo($torneoId)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->torneoSeleccionadoId = $torneoId;
    }
public function getTorneoSeleccionadoProperty()
{
    return $this->torneoSeleccionadoId
        ? Torneo::with('grupo')->find($this->torneoSeleccionadoId)
        : null;
}

    public function inscribirse()
{
    
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (!$this->torneoSeleccionadoId) {
        session()->flash('error', __('subscriptions.tournament_not_selected'));
        $this->dispatchBrowserEvent('closeModalInscripcion');
        return;
    }

    $torneo = Torneo::with('grupo')->find($this->torneoSeleccionadoId);

    if (!$torneo || !$torneo->grupo) {
        session()->flash('error', __('groups.tournament_without_group'));
        $this->dispatchBrowserEvent('closeModalInscripcion');
        return;
    }

    $grupo = $torneo->grupo;

    $existe = $grupo->usuarios()
        ->where('users.id', Auth::id())
        ->exists();

    if ($existe) {
       session()->flash('error', __('groups.already_requested_or_member'));
        return;
    }

    $grupo->usuarios()->attach(Auth::id(), [
        'rol' => 'jugador',
        'estado' => 'pendiente',
    ]);

    $this->torneoSeleccionadoId = null;

    $this->cargarDatos();

     session()->flash('success', __('groups.request_sent_check_email'));

    $this->dispatchBrowserEvent('closeModalInscripcion');
}
    public function render()
    {
        return view('livewire.inscripciones.view');
    }
}