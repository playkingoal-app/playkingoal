<?php

namespace App\Services;

use App\Models\Partido;
use App\Models\Pronostico;
use Illuminate\Support\Facades\Log;

class PuntajeService
{
    public function calcularPartido(Partido $partido)
    {
        $partido = Partido::with(['jornada', 'resultado'])->find($partido->id);

        if (!$partido) {
            Log::warning('PARTIDO NO ENCONTRADO');
            return;
        }

        Log::info('INICIO CALCULO', [
            'partido_id' => $partido->id,
            'estado' => $partido->estado,
            'jornada_id' => $partido->jornada_id,
            'resultado_id' => $partido->resultado->id ?? null,
        ]);

        if (!in_array($partido->estado, ['FT', 'AET', 'PEN'])) {
            Log::warning('NO FINALIZADO', [
                'partido_id' => $partido->id,
                'estado' => $partido->estado,
            ]);
            return;
        }

        if (!$partido->jornada) {
            Log::warning('SIN JORNADA', [
                'partido_id' => $partido->id,
            ]);
            return;
        }

        if (!$partido->resultado) {
            Log::warning('SIN RESULTADO', [
                'partido_id' => $partido->id,
            ]);
            return;
        }

        if (
            $partido->resultado->golesLocal === null ||
            $partido->resultado->golesVisitante === null
        ) {
            Log::warning('RESULTADO SIN GOLES', [
                'partido_id' => $partido->id,
                'resultado_id' => $partido->resultado->id,
            ]);
            return;
        }

        $realLocal = (int) $partido->resultado->golesLocal;
        $realVisitante = (int) $partido->resultado->golesVisitante;

        $pronosticos = Pronostico::where('partido', $partido->id)->get();

        Log::info('PRONOSTICOS ENCONTRADOS', [
            'partido_id' => $partido->id,
            'cantidad' => $pronosticos->count(),
            'resultado' => "{$realLocal}-{$realVisitante}",
        ]);

        foreach ($pronosticos as $p) {
             if ($p->golesLocal === null || $p->golesVisitante === null) {
        $p->update([
            'puntos' => 0,
        ]);

        Log::warning('PRONOSTICO SIN GOLES, NO SE CALCULA', [
            'pronostico_id' => $p->id,
            'jugador' => $p->jugador,
            'partido_id' => $partido->id,
        ]);

        continue;
    }
            $pronosticoLocal = (int) $p->golesLocal;
            $pronosticoVisitante = (int) $p->golesVisitante;

            $puntos = 0;

            if (
                $pronosticoLocal === $realLocal &&
                $pronosticoVisitante === $realVisitante
            ) {
                $puntos = (int) $partido->jornada->valor_puntaje_me;
            } elseif (
                ($pronosticoLocal > $pronosticoVisitante && $realLocal > $realVisitante) ||
                ($pronosticoLocal < $pronosticoVisitante && $realLocal < $realVisitante) ||
                ($pronosticoLocal === $pronosticoVisitante && $realLocal === $realVisitante)
            ) {
                $puntos = (int) $partido->jornada->valor_puntaje_g;
            }

            $p->update([
                'puntos' => $puntos,
            ]);

            Log::info('PRONOSTICO ACTUALIZADO', [
                'pronostico_id' => $p->id,
                'jugador' => $p->jugador,
                'pronostico' => "{$pronosticoLocal}-{$pronosticoVisitante}",
                'real' => "{$realLocal}-{$realVisitante}",
                'puntos' => $puntos,
            ]);
        }

        $partido->update([
            'puntos_calculados' => true,
        ]);

        Log::info('PARTIDO CALCULADO', [
            'partido_id' => $partido->id,
        ]);
    }
}