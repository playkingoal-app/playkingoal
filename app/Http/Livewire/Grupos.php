<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Grupo;

class Grupos extends Component
{
    public $nombre, $requisito_entrada;

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
           session()->flash('error', __('groups.active_subscription_required'));
            return;
        }

        // Limite de grupos según plan
        $gruposActuales = Grupo::where('propietario_id', $user->id)->count();
        if ($gruposActuales >= $plan->max_grupos) {
            session()->flash('error', __('groups.plan_group_limit_reached'));
            return;
        }




        // Crear el grupo
        $grupo = Grupo::create([
            'nombre' => $this->nombre,
            'slug' => Str::slug($this->nombre) . '-' . uniqid(),
            'codigo_invitacion' => strtoupper(Str::random(6)),
            'propietario_id' => $user->id,
            'requisito_entrada' => __('groups.not_defined'),
            'premio' => 'SIN DEFINIR',
            'activo' => true,
        ]);

        // Asignar al usuario como admin del grupo
        $grupo->usuarios()->attach($user->id, [
            'rol' => 'admin',
            'estado' => 'aprobado',
        ]);

        // Limpiar formulario
        $this->reset('nombre');

           session()->flash('success', __('groups.group_created_success'));


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
