<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Equipo;
use App\Models\Torneo;
use App\Models\Jornada;
use App\Models\Partido;

class SyncWorldCup extends Command
{
    protected $signature = 'sync:world-cup';
    protected $description = 'Importar partidos del Mundial usando la estructura actual';

    public function handle()
    {
        $leagueId = env('WORLD_CUP_LEAGUE', 1);
        $season = env('WORLD_CUP_SEASON', 2026);
        $torneoId = env('WORLD_CUP_TORNEO_ID');

       $torneos = Torneo::where('api_league_id', $leagueId)
    ->where('activo', 1)
    ->get();

       if ($torneos->isEmpty()) {
    $this->error('No hay torneos para esta liga.');
    return Command::FAILURE;
}

       $this->info("Importando World Cup {$season}");
$this->info("Se encontraron {$torneos->count()} torneos para sincronizar.");

        $response = Http::withHeaders([
            'x-apisports-key' => config('services.api_football.key'),
        ])->get(config('services.api_football.base_url') . '/fixtures', [
                    'league' => $leagueId,
                    'season' => $season,
                ]);

        if (!$response->successful()) {
            $this->error('Error conectando con API-Football');
            $this->line('Status: ' . $response->status());
            $this->line('Body: ' . $response->body());
            return Command::FAILURE;
        }

        $fixtures = $response->json('response');
foreach ($fixtures as $fixture) {
    $this->line(
        $fixture['fixture']['id'] . ' | ' .
        $fixture['league']['round'] . ' | ' .
        $fixture['teams']['home']['name'] . ' vs ' .
        $fixture['teams']['away']['name']
    );
}
        if (empty($fixtures)) {
            $this->warn('No hay partidos para importar.');
            return Command::SUCCESS;
        }
foreach ($torneos as $torneo) {
    $this->info("Sincronizando {$torneo->nombre_torneo}");
        foreach ($fixtures as $fixture) {
            $home = $fixture['teams']['home'];
            $away = $fixture['teams']['away'];

            $equipoLocal = Equipo::where('api_id', $home['id'])->first();
            $equipoVisitante = Equipo::where('api_id', $away['id'])->first();

            if (!$equipoLocal || !$equipoVisitante) {
                $this->warn("Falta equipo: {$home['name']} o {$away['name']}");
                continue;
            }

            $round = $fixture['league']['round'] ?? 'Sin jornada';

            $jornada = Jornada::firstOrCreate(
                [
                    'torneo_id' => $torneo->id,
                    'descripcion' => $round,
                ],
                [
                    'valor_puntaje_me' => 0,
                    'valor_puntaje_g' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),

                ]
            );
       $partido = Partido::where('api_id', $fixture['fixture']['id'])
    ->where('torneo_id', $torneo->id)
    ->first();
            if (!$partido) {
$this->info("Creando partido {$fixture['fixture']['id']} para torneo {$torneo->id}");
                Partido::create([
                    'api_id' => $fixture['fixture']['id'],
                    'idEquipoLocal' => $equipoLocal->id,
                    'idEquipoVisitante' => $equipoVisitante->id,
                    'fecha_hora' => $fixture['fixture']['date'],
                    'jornada_id' => $jornada->id,
                    'torneo_id' => $torneo->id,
                    'estado' => $fixture['fixture']['status']['short'],
                    'golesLocal' => $fixture['goals']['home'],
                    'golesVisitante' => $fixture['goals']['away'],
                    'ganador' => $fixture['teams']['home']['winner'] === true
                        ? 'local'
                        : ($fixture['teams']['away']['winner'] === true ? 'visitante' : null),
                ]);

            } else {

                $partido->update([
                    'estado' => $fixture['fixture']['status']['short'],
                    'golesLocal' => $fixture['goals']['home'],
                    'golesVisitante' => $fixture['goals']['away'],
                    'ganador' => $fixture['teams']['home']['winner'] === true
                        ? 'local'
                        : ($fixture['teams']['away']['winner'] === true ? 'visitante' : null),
                ]);

            }

            $this->info("Importado: {$home['name']} vs {$away['name']}");
        }
}
$this->call('predictions:init-missing');
        $this->info('Mundial importado correctamente.');

        return Command::SUCCESS;
        
    }
}