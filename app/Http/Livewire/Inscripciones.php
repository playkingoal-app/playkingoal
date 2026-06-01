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
    public $comprobante;
    public $torneoSeleccionadoId = null;

    protected $rules = [
        'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    protected $messages = [
        'comprobante.required' => 'Debes subir el comprobante de pago.',
        'comprobante.mimes' => 'El comprobante debe ser JPG, PNG o PDF.',
        'comprobante.max' => 'El archivo no puede superar los 2MB.',
    ];

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
    ->whereRelation('grupo', 'propietario_id', 1)
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

        $this->comprobante = null;
        $this->torneoSeleccionadoId = $torneoId;
    }

    public function getTorneoSeleccionadoProperty()
    {
        return $this->torneoSeleccionadoId
            ? Torneo::find($this->torneoSeleccionadoId)
            : null;
    }

    public function inscribirse()
    {
        $this->validate();

        if (!$this->torneoSeleccionadoId) {
            session()->flash('error', __('subscriptions.tournament_not_selected'));
            return;
        }

        $yaInscrito = Inscripcione::where('usuario_id', Auth::id())
            ->where('torneo_id', $this->torneoSeleccionadoId)
            ->exists();

        if ($yaInscrito) {
            session()->flash('error', __('subscriptions.already_registered_error'));
            return;
        }

        $rutaComprobante = $this->comprobante->store('comprobantes', 'public');

        Inscripcione::create([
            'grupo_id' => null,
            'usuario_id' => Auth::id(),
            'torneo_id' => $this->torneoSeleccionadoId,
            'estado_pago' => 'pendiente',
            'comprobante' => $rutaComprobante,
        ]);

        $this->reset('comprobante');
        $this->torneoSeleccionadoId = null;

        $this->cargarDatos();

        session()->flash('success', __('subscriptions.subscription_success'));

        $this->dispatchBrowserEvent('closeModalInscripcion');
    }

    public function render()
    {
        return view('livewire.inscripciones.view');
    }
}