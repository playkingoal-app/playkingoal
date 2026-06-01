<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Grupo;

class Grupos extends Component
{
    public $nombre, $requisito_entrada,$premio;

    protected $rules = [
        'nombre' => 'required|min:3|max:100',
    ];

    public function crearGrupo()
    {
        $this->validate();

        $user = auth()->user();

        // Obtener plan activo
        $plan = $user->suscripcionActiva ? $user->suscripcionActiva->plan : null;

        if (!$plan) {
            session()->flash('error', 'Necesitas una suscripción activa para crear grupos.');
            return;
        }

        // Limite de grupos según plan
        $gruposActuales = Grupo::where('propietario_id', $user->id)->count();
        if ($gruposActuales >= $plan->max_grupos) {
            session()->flash('error', 'Has alcanzado el límite de grupos de tu plan.');
            return;
        }




        // Crear el grupo
        $grupo = Grupo::create([
            'nombre' => $this->nombre,
            'slug' => Str::slug($this->nombre) . '-' . uniqid(),
            'codigo_invitacion' => strtoupper(Str::random(6)),
            'propietario_id' => $user->id,
            'requisito_entrada' => $this->requisito_entrada,
            'premio' => $this->premio,
            'activo' => true,
        ]);

        // Asignar al usuario como admin del grupo
        $grupo->usuarios()->attach($user->id, [
            'rol' => 'admin',
            'estado' => 'aprobado',
        ]);

        // Limpiar formulario
        $this->reset('nombre');

        session()->flash('success', 'Grupo creado con éxito');

        // Redirigir o actualizar lista de grupos
        return redirect()->route('groups');
    }

    public function render()
    {
        $user = auth()->user();
        $grupos = Grupo::where('propietario_id', $user->id)->get();

        return view('livewire.grupos.view', [
            'grupos' => $grupos
        ]);
    }
}
