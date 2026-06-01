<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Torneo;
use App\Models\Partido;
use App\Models\Equipo;
use App\Services\ApiFootballService;

class ImportApiMatches extends Command
{
    protected $signature = 'api:import-matches {torneoId}';
    protected $description = 'Importa partidos de la API para un torneo específico';

    public function handle(ApiFootballService $apiService)
    {
        $torneo = Torneo::with(['apiLeague', 'jornadas'])->findOrFail($this->argument('torneoId'));

        if (!$torneo->apiLeague) {
            $this->error("El torneo no tiene una liga API asignada.");
            return;
        }

        $season = $torneo->season ?? date('Y'); // usa el campo season si existe, si no el año actual
        $matches = $apiService->getMatches($torneo->apiLeague->api_id, $season);

        if (empty($matches)) {
            $this->info("No se encontraron partidos para esta liga y temporada.");
            return;
        }

        foreach ($matches as $m) {
            // Buscar equipos en tu tabla 'equipos' por api_id
            $local = Equipo::where('api_id', $m['home_team']['id'])->first();
            $visitante = Equipo::where('api_id', $m['away_team']['id'])->first();

            if (!$local || !$visitante) {
                $this->warn("Equipo local o visitante no encontrado para el partido API ID: {$m['fixture_id']}");
                continue;
            }

            // Crear o actualizar partido
            $partido = Partido::updateOrCreate(
                ['api_id' => $m['fixture_id']],
                [
                    'torneo_id' => $torneo->id,
                    'idEquipoLocal' => $local->id,
                    'idEquipoVisitante' => $visitante->id,
                    'fecha_hora' => $m['date'],
                    'estado' => 0, // 0 = pendiente
                ]
            );

            // Asignar jornada automáticamente según fecha
            $jornada = $torneo->jornadas()
                              ->whereDate('fecha_inicio', '<=', $m['date'])
                              ->whereDate('fecha_fin', '>=', $m['date'])
                              ->first();

            if ($jornada) {
                $partido->jornada_id = $jornada->id;
                $partido->save();
            }
        }

        $this->info("Partidos importados correctamente para el torneo: {$torneo->nombre_torneo}");
    }
}
