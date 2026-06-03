<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiLeague;
use App\Services\ApiFootballService;

class ImportApiLeagues extends Command
{
    protected $signature = 'import:api-leagues {season=2026}';
    protected $description = 'Importar solo ligas permitidas desde la API';

    public function handle()
    {
        $season = $this->argument('season');

        $allowedLeagueIds = [
            1, // World Cup
        ];

        $this->info("Importando ligas permitidas temporada {$season}...");

        $apiService = new ApiFootballService();
        $leagues = $apiService->getLeagues($season);

        if (empty($leagues)) {
            $this->warn('No se encontraron ligas.');
            return 0;
        }

        foreach ($leagues as $league) {
            if (!in_array($league['id'], $allowedLeagueIds)) {
                continue;
            }

            ApiLeague::updateOrCreate(
                ['api_id' => $league['id']],
                [
                    'name' => $league['name'],
                    'country' => $league['country'] ?? null,
                    'logo' => $league['logo'] ?? null,
                ]
            );

            $this->info("Liga importada: {$league['name']}");
        }

        $this->info('Importación completada.');

        return 0;
    }
}