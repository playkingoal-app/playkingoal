<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partido;
use App\Models\Inscripcione;
use App\Models\Pronostico;

class InitMissingPredictions extends Command
{
    /**
     * Ejecutar:
     * php artisan predictions:init-missing
     */
    protected $signature = 'predictions:init-missing';

    protected $description = 'Crea los pronósticos faltantes para partidos nuevos agregados después de que los usuarios ya estaban inscritos en un torneo.';

    public function handle()
    {
        $this->info('Buscando partidos sin pronósticos para usuarios inscritos...');

        // Recorremos todos los partidos del sistema
        $partidos = Partido::all();

        foreach ($partidos as $partido) {

            // Usuarios inscritos y con pago activo en el torneo del partido
            $inscripciones = Inscripcione::where('torneo_id', $partido->torneo_id)
                ->where('estado_pago', 'activo')
                ->get();

            foreach ($inscripciones as $inscripcion) {

                // Si el pronóstico ya existe no hace nada.
                // Si no existe (porque el partido fue agregado después),
                // lo crea vacío.
                Pronostico::firstOrCreate(
                    [
                        'jugador' => $inscripcion->usuario_id,
                        'partido' => $partido->id,
                    ],
                    [
                        'golesLocal' => null,
                        'golesVisitante' => null,
                        'ganador' => null,
                    ]
                );
            }
        }

        $this->info('Pronósticos faltantes creados correctamente.');

        return Command::SUCCESS;
    }
}