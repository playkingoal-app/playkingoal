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
        $season = env('WORLD_CUP_SEASON', 2022);
        $torneoId = env('WORLD_CUP_TORNEO_ID');

        $torneo = Torneo::find($torneoId);

        if (!$torneo) {
            $this->error('No existe el torneo interno. Revisa WORLD_CUP_TORNEO_ID en el .env');
            return Command::FAILURE;
        }

        $this->info("Importando World Cup {$season} para torneo interno ID {$torneo->id}");

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

        if (empty($fixtures)) {
            $this->warn('No hay partidos para importar.');
            return Command::SUCCESS;
        }

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
                    'nombre' => $round,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            Partido::updateOrCreate(
                [
                    'api_id' => $fixture['fixture']['id'],
                ],
                [
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
                    'updated_at' => now(),
                ]
            );

            $this->info("Importado: {$home['name']} vs {$away['name']}");
        }

        $this->info('Mundial importado correctamente.');

        return Command::SUCCESS;
    }
}