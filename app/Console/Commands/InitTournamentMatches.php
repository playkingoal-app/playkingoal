<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partido;
use App\Models\Torneo;
use App\Services\ApiFootballService;
use App\Services\PuntajeService;

class InitTournamentMatches extends Command
{
    protected $signature = 'matches:init {torneo_id}';
    protected $description = 'Inicializa resultados y estado de los partidos de un torneo recién creado';

    public function handle(ApiFootballService $apiService, PuntajeService $puntajeService)
    {
        $torneo = Torneo::findOrFail($this->argument('torneo_id'));

        $this->info("Inicializando torneo: {$torneo->nombre_torneo}");

        $partidos = Partido::where('torneo_id', $torneo->id)->get();

        if ($partidos->isEmpty()) {
            $this->warn("⚠ No hay partidos registrados para este torneo.");
            return;
        }

        foreach ($partidos as $partido) {

            $this->line("Sync partido API ID: {$partido->api_id}");

            $data = $apiService->getFixtureById($partido->api_id);

            if (!$data) continue;

            // Actualizar partido
            $partido->update([
                'golesLocal' => $data['goals']['home'],
                'golesVisitante' => $data['goals']['away'],
                'estado' => $data['fixture']['status']['short'],
            ]);

            // Marcar puntos si ya terminó
            $finalizados = ['FT', 'AET', 'PEN'];
            if (in_array($partido->estado, $finalizados)) {
                $puntajeService->calcularPartido($partido);
                $partido->update(['puntos_calculados' => true]);
            }
        }

        $this->info(" Torneo inicializado correctamente.");
    }
}
