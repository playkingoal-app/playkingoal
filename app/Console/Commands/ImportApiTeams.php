<?php
namespace App\Console\Commands;

use App\Models\Equipo;
use Illuminate\Console\Command;
use App\Models\ApiLeague;
use App\Models\ApiTeam;
use App\Services\ApiFootballService;

class ImportApiTeams extends Command
{
    protected $signature = 'import:api-teams';
    protected $description = 'Importar equipos desde la API de fútbol';

    public function handle()
    {
        $this->info('Iniciando importación de equipos...');
        $apiService = new ApiFootballService();
        $leagues = ApiLeague::all();

        if ($leagues->isEmpty()) {
            $this->warn('No hay ligas en la base. Primero ejecuta import:api-leagues');
            return 0;
        }

        foreach ($leagues as $league) {
            $this->info("Importando equipos de {$league->name}");
            $teams = $apiService->getTeams($league->api_id, 2023);

            foreach ($teams as $team) {
                Equipo::updateOrCreate(
                    ['api_id' => $team['id']],
                    [
                        'name' => $team['name'],
                        'logo' => $team['logo'] ?? null,
                        'api_league_id' => $league->id,
                    ]
                );
                $this->info("Equipo importado: {$team['name']}");
            }
        }

        $this->info('Importación de equipos completada.');
    }
}
