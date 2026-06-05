<?php

namespace App\Http\Livewire\Grupos;

use Livewire\Component;
use App\Models\Grupo;
use App\Models\ApiLeague;
use App\Models\Torneo;
use App\Models\Inscripcione;
use App\Services\ApiFootballService;
use App\Models\Jornada;
use App\Models\Partido;
use App\Models\Equipo;
use Illuminate\Support\Facades\Artisan;
use App\Models\Resultado;
use App\Models\GrupoPremio;

class PanelGrupo extends Component
{
    public $grupo;
    public $tab = 'torneo'; // 'torneo' | 'usuarios'

    // Form asignar torneo
    public $api_league_id;
    public $precio;
    public $buscarLiga = '';
    public $paisLiga = '';
    // Link invitación
    public $linkInvitacion;

    public $requisito_entrada;

   public $premios = [
    ['posicion' => 1, 'premio' => ''],
];

    public function mount($grupo)
    {
        $this->grupo = Grupo::findOrFail($grupo);

        // (Opcional pero recomendado) seguridad: solo miembros del grupo
        if (!$this->grupo->usuarios()->where('users.id', auth()->id())->exists()) {
            abort(403);
        }

        $this->linkInvitacion = route('groups.join.codigo', $this->grupo->codigo_invitacion);
    }
public function agregarPremio()
{
    $this->premios[] = [
        'posicion' => count($this->premios) + 1,
        'premio' => '',
    ];
}
    public function cambiarTab($tab)
    {
        $this->tab = $tab;
    }
    private function calcularGanador($golesLocal, $golesVisitante, $idLocal, $idVisitante)
    {
        if ($golesLocal === null || $golesVisitante === null) {
            return null;
        }

        if ($golesLocal > $golesVisitante) {
            return $idLocal;
        }

        if ($golesVisitante > $golesLocal) {
            return $idVisitante;
        }

        return 0;
    }
    public function esAdmin(): bool
    {
        return $this->grupo->usuarios()
            ->where('users.id', auth()->id())
            ->wherePivot('rol', 'admin')
            ->exists();
    }
    protected function importMatches(Torneo $torneo, ApiFootballService $apiService)
    {
        if (Partido::where('torneo_id', $torneo->id)->exists()) {
            return;
        }

    $season = $torneo->season ?? 2026;

        $fixtures = cache()->remember(
            'fixtures_' . $torneo->apiLeague->api_id . '_' . $season,
            now()->addHours(6),
            function () use ($apiService, $torneo, $season) {
                return $apiService->getMatches(
                    $torneo->apiLeague->api_id,
                    $season
                );
            }
        );
        foreach ($fixtures as $m) {

            if (!isset($m['league']['round'])) {
                continue;
            }

            $jornada = Jornada::firstOrCreate(
                [
                    'torneo_id' => $torneo->id,
                    'descripcion' => $m['league']['round'],
                ],
                [
                    'valor_puntaje_me' => 0,
                    'valor_puntaje_g' => 0,
                ]
            );

            $local = Equipo::updateOrCreate(
                ['api_id' => $m['teams']['home']['id']],
                [
                    'name' => $m['teams']['home']['name'],
                    'logo' => $m['teams']['home']['logo'] ?? null,
                ]
            );

            $visitante = Equipo::updateOrCreate(
                ['api_id' => $m['teams']['away']['id']],
                [
                    'name' => $m['teams']['away']['name'],
                    'logo' => $m['teams']['away']['logo'] ?? null,
                ]
            );

            $partido = Partido::updateOrCreate(
                ['api_id' => $m['fixture']['id']],
                [
                    'torneo_id' => $torneo->id,
                    'jornada_id' => $jornada->id,
                    'idEquipoLocal' => $local->id,
                    'idEquipoVisitante' => $visitante->id,
                    'fecha_hora' => $m['fixture']['date'],
                    'estado' => strtoupper(trim($m['fixture']['status']['short'])),
                ]
            );
            Resultado::updateOrCreate(
                [
                    'partido' => $partido->id,
                ],
                [
                    'golesLocal' => $m['goals']['home'],
                    'golesVisitante' => $m['goals']['away'],
                    'ganador' => $this->calcularGanador(
                        $m['goals']['home'],
                        $m['goals']['away'],
                        $local->id,
                        $visitante->id
                    ),
                ]
            );

        }
    }

    public function asignarTorneo(ApiFootballService $apiService)
    {
        if (!$this->esAdmin())
            abort(403);

        $this->validate([
          'api_league_id' => 'required|exists:api_leagues,id',
    'premios.*.posicion' => 'required|integer|min:1|max:1000',
    'premios.*.premio' => 'nullable|string|max:255',

        ]);

        // 1 torneo por grupo
        if (Torneo::where('grupo_id', $this->grupo->id)->exists()) {
         session()->flash('error', __('group_panel.tournament_already_assigned'));
            return;
        }

        // Crear torneo interno
        $torneo = Torneo::create([
            'nombre_torneo' => $this->grupo->nombre,
            'activo' => 1,
            'api_league_id' => $this->api_league_id,
            'grupo_id' => $this->grupo->id,
        ]);

        // Importar partidos/jornadas (MISMA lógica que global)
        $this->importMatches($torneo, $apiService);

        // Inicializar
        /*
   Artisan::call('matches:init ' . $torneo->id);
        **/
$fechaInicio = Partido::where('torneo_id', $torneo->id)->min('fecha_hora');
$fechaFin = Partido::where('torneo_id', $torneo->id)->max('fecha_hora');

$torneo->update([
    'fecha_inicio' => $fechaInicio,
    'fecha_fin' => $fechaFin,
]);
       $this->grupo->update([
    'requisito_entrada' => $this->requisito_entrada ?: __('group_panel.not_defined'),
]);

foreach ($this->premios as $item) {
    if (!empty($item['premio'])) {
        GrupoPremio::create([
            'grupo_id' => $this->grupo->id,
            'posicion' => $item['posicion'],
            'premio' => $item['premio'],
        ]);
    }
}
     $this->reset(['api_league_id', 'precio', 'premios']);
        $this->grupo = $this->grupo->fresh();

       session()->flash('success', __('group_panel.tournament_assigned_success'));
    }

    // Aprobar usuario pendiente
    public function aprobarUsuario($userId)
    {
        if (!$this->esAdmin()) {
            abort(403);
        }

        $this->grupo->usuarios()->updateExistingPivot($userId, [
            'estado' => 'aprobado',
        ]);

        $this->grupo = $this->grupo->fresh();
       session()->flash('success', __('group_panel.user_approved'));
    }

    // Rechazar usuario (lo sacamos del grupo)
    public function rechazarUsuario($userId)
    {
        if (!$this->esAdmin()) {
            abort(403);
        }

        $this->grupo->usuarios()->detach($userId);

        $this->grupo = $this->grupo->fresh();
        session()->flash('success', __('group_panel.request_rejected'));
    }
    public function participar()
    {
        // 1) Debe ser miembro aprobado
        $aprobado = $this->grupo->usuarios()
            ->where('users.id', auth()->id())
            ->wherePivot('estado', 'aprobado')
            ->exists();

        if (!$aprobado) {
            abort(403);
        }

        // 2) Debe existir torneo del grupo
        $torneo = Torneo::where('grupo_id', $this->grupo->id)->first();

        if (!$torneo) {
            session()->flash('error', __('group_panel.no_tournament_assigned_yet'));
            return;
        }

        // 3) Crear o reutilizar inscripción
        $inscripcion = Inscripcione::firstOrCreate(
            [
                'grupo_id' => $this->grupo->id,
                'usuario_id' => auth()->id(),
                'torneo_id' => $torneo->id,
            ],
            [
                'estado_pago' => 'activo', // por ahora sin Stripe
            ]
        );

        // Si ya existía y estaba pendiente, la activamos igual (temporal)
        if ($inscripcion->estado_pago !== 'activo') {
            $inscripcion->update(['estado_pago' => 'activo']);
        }

    session()->flash('success', __('group_panel.join_success'));
    }

    public function render()
    {
        $torneo = Torneo::where('grupo_id', $this->grupo->id)->with('apiLeague')->first();
        $yaInscrito = false;

        if ($torneo) {
            $yaInscrito = Inscripcione::where('usuario_id', auth()->id())
                ->where('torneo_id', $torneo->id)
                ->where('estado_pago', 'activo')
                ->exists();
        }
$this->grupo->load('premios');
        return view('livewire.grupos.panel-grupo', [
            'torneo' => $torneo,
            'ligas' => ApiLeague::orderBy('name')->get(),
            'usuariosPendientes' => $this->grupo->usuarios()->wherePivot('estado', 'pendiente')->get(),
            'usuariosAprobados' => $this->grupo->usuarios()->wherePivot('estado', 'aprobado')->get(),
            'yaInscrito' => $yaInscrito,
        ]);
    }
}
