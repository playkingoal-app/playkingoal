<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partido;
use App\Models\Resultado;
use App\Services\ApiFootballService;
use App\Services\PuntajeService;

class SyncMatchResults extends Command
{
    protected $signature = 'matches:sync-results {--only-calc}';

    protected $description = 'Sincroniza resultados y calcula puntos pendientes';

    public function handle(
        ApiFootballService $apiService,
        PuntajeService $puntajeService
    ) {
        $estadosFinalizados = ['FT', 'AET', 'PEN'];

        if (!$this->option('only-calc')) {

            $fechas = Partido::whereNotNull('api_id')
                ->where('puntos_calculados', false)
                ->whereDate('fecha_hora', '<=', now())
                ->selectRaw('DATE(fecha_hora) as fecha')
                ->distinct()
                ->pluck('fecha');

            foreach ($fechas as $fecha) {

                $fixtures = $apiService->getFixturesByDate($fecha);

                foreach ($fixtures as $fixture) {

                    $apiId = $fixture['fixture']['id'] ?? null;

                    if (!$apiId) {
                        continue;
                    }

                    $partido = Partido::where('api_id', $apiId)->first();

                    if (!$partido) {
                        continue;
                    }

                    $estado = strtoupper(trim($fixture['fixture']['status']['short'] ?? ''));

                    $golesLocal = $fixture['goals']['home'] ?? null;
                    $golesVisitante = $fixture['goals']['away'] ?? null;

                    $ganador = null;

                    if ($golesLocal !== null && $golesVisitante !== null) {
                        if ($golesLocal > $golesVisitante) {
                            $ganador = 'local';
                        } elseif ($golesVisitante > $golesLocal) {
                            $ganador = 'visitante';
                        } else {
                            $ganador = 'empate';
                        }
                    }

                    $partido->update([
                        'estado' => $estado,
                    ]);

                    if (in_array($estado, $estadosFinalizados) && $golesLocal !== null && $golesVisitante !== null) {
                        Resultado::updateOrCreate(
                            ['partido' => $partido->id],
                            [
                                'golesLocal' => $golesLocal,
                                'golesVisitante' => $golesVisitante,
                                'ganador' => $ganador,
                            ]
                        );
                    }
                }
            }
        }

       $partidos = Partido::where('puntos_calculados', false)
    ->whereIn('estado', $estadosFinalizados)
    ->whereHas('resultado')
    ->whereHas('pronosticos', function ($q) {
        $q->whereNotNull('golesLocal')
          ->whereNotNull('golesVisitante');
    })
    ->limit(20)
    ->get();

        $this->info('Partidos para calcular: ' . $partidos->count());

        foreach ($partidos as $partido) {
            $this->info('Calculando partido ID: ' . $partido->id);
            $puntajeService->calcularPartido($partido);
        }

        $this->info('Resultados sincronizados y puntos calculados correctamente.');

        return Command::SUCCESS;
    }
}