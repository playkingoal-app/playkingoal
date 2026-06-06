<?php

namespace App\Http\Livewire\Grupos;

use Livewire\Component;
use App\Models\Grupo;
use App\Models\Torneo;

class UnirseGrupo extends Component
{
    public $grupo;

    public $torneo; // torneo del grupo (si existe)

    public $estadoMiembro = null; // null | pendiente | aprobado
    public $rolMiembro = null;    // admin | jugador | null

    public function mount($grupo)
    {
        $this->grupo = Grupo::with(['usuarios'])->findOrFail($grupo);

        // Torneo asociado al grupo (si manejas 1 torneo por grupo)
        $this->torneo = Torneo::with('apiLeague')
            ->where('grupo_id', $this->grupo->id)
            ->first();

        // Si está logueado, verificamos si ya pertenece o solicitó
        if (auth()->check()) {
            $mi = $this->grupo->usuarios()
                ->where('users.id', auth()->id())
                ->first();

            if ($mi) {
                $this->estadoMiembro = $mi->pivot->estado; // pendiente / aprobado
                $this->rolMiembro = $mi->pivot->rol;       // admin / jugador
            }
        }
    }

    public function solicitar()
    {
        if (!auth()->check()) {
            // si quisieras: redirect login con intended
            return redirect()->route('login');
        }

        // Si ya existe relación, no duplicar
        $existe = $this->grupo->usuarios()
            ->where('users.id', auth()->id())
            ->exists();

        if ($existe) {
               session()->flash('info', __('groups.already_requested_or_member'));
            return;
        }

        // Crear solicitud pendiente
        $this->grupo->usuarios()->attach(auth()->id(), [
            'rol' => 'jugador',
            'estado' => 'pendiente',
        ]);

        $this->estadoMiembro = 'pendiente';
        $this->rolMiembro = 'jugador';

       session()->flash('success', __('groups.request_sent_wait_approval'));
    }

    public function render()
    {
        // Refrescar el torneo por si el admin lo asigna después
        // (sin recargar toda la página)
        $this->torneo = Torneo::with('apiLeague')
            ->where('grupo_id', $this->grupo->id)
            ->first();

        // Contadores útiles
        $aprobadosCount = $this->grupo->usuarios()
            ->wherePivot('estado', 'aprobado')
            ->count();

        $pendientesCount = $this->grupo->usuarios()
            ->wherePivot('estado', 'pendiente')
            ->count();

        // Admin/propietario (si tienes propietario_id)
        $propietario = null;
        if (isset($this->grupo->propietario_id)) {
            $propietario = \App\Models\User::find($this->grupo->propietario_id);
        }

        return view('livewire.grupos.unirse-grupo', [
            'aprobadosCount' => $aprobadosCount,
            'pendientesCount' => $pendientesCount,
            'propietario' => $propietario,
        ]);
    }
}
