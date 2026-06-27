<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partido;
use App\Models\Resultado;
use App\Services\ApiFootballService;
use App\Services\PuntajeService;


class SyncMatchResults extends Command
{

protected $signature = 'matches:sync-results {league_id=1} {season=2026}';
    protected $description = 'Sincroniza resultados desde la API';

  public function handle(ApiFootballService $apiService, PuntajeService $puntajeService)
{
    $leagueId = $this->argument('league_id');
    $season = $this->argument('season');

    $this->info("Sincronizando liga {$leagueId} temporada {$season}");

    $fixtures = $apiService->getMatches($leagueId, $season);

    foreach ($fixtures as $fixture) {

        $apiId = $fixture['fixture']['id'] ?? null;

        if (!$apiId) continue;

        $partido = Partido::where('api_id', $apiId)->first();

        if (!$partido) continue;

        $estado = strtoupper($fixture['fixture']['status']['short'] ?? '');

        $golesLocal = $fixture['goals']['home'] ?? null;
        $golesVisitante = $fixture['goals']['away'] ?? null;

        $partido->update([
            'estado' => $estado,
        ]);

        if (in_array($estado, ['FT','AET','PEN'])) {

            Resultado::updateOrCreate(
                ['partido' => $partido->id],
                [
                    'golesLocal' => $golesLocal,
                    'golesVisitante' => $golesVisitante,
                    'ganador' => $golesLocal > $golesVisitante
                        ? 'local'
                        : ($golesLocal < $golesVisitante ? 'visitante' : 'empate')
                ]
            );
        }
    }

    $this->call('matches:calculate-points');

    return Command::SUCCESS;
}
}