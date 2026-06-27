<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partido;
use App\Services\PuntajeService;

class CalculatePendingPoints extends Command
{
    protected $signature = 'matches:calculate-points';

    protected $description = 'Calcula los puntos pendientes de los partidos finalizados';

    public function handle(PuntajeService $puntajeService)
    {
        $estadosFinalizados = ['FT', 'AET', 'PEN'];

        $partidos = Partido::where('puntos_calculados', false)
            ->whereIn('estado', $estadosFinalizados)
            ->whereHas('resultado')
            ->get();

        $this->info("Partidos encontrados: {$partidos->count()}");

        foreach ($partidos as $partido) {

            $this->info("Calculando partido {$partido->id}");

            $puntajeService->calcularPartido($partido);
        }

        $this->info('Puntos calculados correctamente.');

        return Command::SUCCESS;
    }
}