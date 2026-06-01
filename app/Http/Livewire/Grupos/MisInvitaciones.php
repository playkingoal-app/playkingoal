<?php

namespace App\Http\Livewire\Grupos;

use Livewire\Component;
use App\Models\Grupo;

class MisInvitaciones extends Component
{
    public function render()
    {
        // Trae todos los grupos donde el usuario existe en el pivot
        // y carga SOLO el pivot del usuario actual
        $grupos = Grupo::whereHas('usuarios', function ($q) {
                $q->where('users.id', auth()->id());
            })
            ->with(['usuarios' => function ($q) {
                $q->where('users.id', auth()->id());
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Separar pendientes / aprobados leyendo el pivot del usuario actual
        $pendientes = $grupos->filter(function ($g) {
            $u = $g->usuarios->first();
            return $u && $u->pivot->estado === 'pendiente';
        });

        $aprobados = $grupos->filter(function ($g) {
            $u = $g->usuarios->first();
            return $u && $u->pivot->estado === 'aprobado';
        });

        return view('livewire.grupos.mis-invitaciones', [
            'pendientes' => $pendientes,
            'aprobados' => $aprobados,
        ]);
    }
}
