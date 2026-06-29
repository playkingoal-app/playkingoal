<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Torneo;
use App\Models\Jornada;
use App\Models\Partido;
use App\Models\Equipo;
use App\Models\ApiTeam;
use App\Services\ApiFootballService;
use Carbon\Carbon;

class Torneos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selected_id;
    public $keyWord;
    public $nombre_torneo;
    public $precio;
    public $fecha_inicio;
    public $fecha_fin;
    public $activo;
    public $api_league_id;

    public function render()
    {
        $keyWord = '%'.$this->keyWord.'%';

        return view('livewire.torneos.view', [
            'torneos' => Torneo::with('apiLeague')
                ->where('nombre_torneo', 'LIKE', $keyWord)
                ->paginate(10),
        ]);
    }

    private function resetInput()
    {
        $this->nombre_torneo = null;
        $this->precio = null;
        $this->fecha_inicio = null;
        $this->fecha_fin = null;
        $this->activo = null;
        $this->api_league_id = null;
    }

    public function cancel()
    {
        $this->resetInput();
    }

    // ================= CREAR TORNEO =================
    public function store(ApiFootballService $apiService)
    {
        $this->validate([
            'nombre_torneo' => 'required',
            'precio' => 'required',
            'api_league_id' => 'required',
        ]);

        // TEMPORADA FIJA POR PLAN GRATUITO CAMBIAR CUANDDO SE COMPRE
        $season = 2026;

        // Crear torneo
        $torneo = Torneo::create([
            'nombre_torneo' => $this->nombre_torneo,
            'precio' => $this->precio,
            'fecha_inicio' => null,
            'fecha_fin' => null,
            'activo' => 1,
            'api_league_id' => $this->api_league_id,
        ]);

      

        // 3Importar partidos
        $this->importMatches($torneo, $apiService, $season);
        
         $torneo->update([
        'fecha_inicio' => Partido::where('torneo_id', $torneo->id)->min('fecha_hora'),
        'fecha_fin' => Partido::where('torneo_id', $torneo->id)->max('fecha_hora'),
    ]);
        \Artisan::call('matches:init ' . $torneo->id);


        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');

        session()->flash(
            'message',
            'Torneo creado con éxito. Jornadas y partidos importados automáticamente.'
        );
    }

    
  

    // ================= IMPORTAR PARTIDOS y JORNADAS =================
  protected function importMatches(Torneo $torneo, ApiFootballService $apiService)
{
    $season = 2026; // API gratuita
    $fixtures = $apiService->getMatches(
        $torneo->apiLeague->api_id,
        $season
    );

    foreach ($fixtures as $m) {

        if (!isset($m['league']['round'])) {
            continue;
        }

        // Crear u obtener jornada
        $jornada = Jornada::firstOrCreate(
            [
                'torneo_id' => $torneo->id,
                'descripcion' => $m['league']['round'],
            ],
            [
                'valor_puntaje_me' => 0,
                'valor_puntaje_g' => 0,
            ]
        );

        // Obtener equipos
        $local = Equipo::where('api_id', $m['teams']['home']['id'])->first();
        $visitante = Equipo::where('api_id', $m['teams']['away']['id'])->first();

        if (!$local || !$visitante) {
            continue;
        }

        // Crear partido
        Partido::updateOrCreate(
            ['api_id' => $m['fixture']['id']],
            [
                'torneo_id' => $torneo->id,
                'jornada_id' => $jornada->id,
                'idEquipoLocal' => $local->id,
                'idEquipoVisitante' => $visitante->id,
                'fecha_hora' => $m['fixture']['date'],
                'estado' => 0,
            ]
        );
    }
}

    // ================= EDITAR =================
    public function edit($id)
    {
        $record = Torneo::findOrFail($id);

        $this->selected_id = $id;
        $this->nombre_torneo = $record->nombre_torneo;
        $this->precio = $record->precio;
        $this->fecha_inicio = $record->fecha_inicio;
        $this->fecha_fin = $record->fecha_fin;
        $this->activo = $record->activo;
        $this->api_league_id = $record->api_league_id;
    }

    // ================= ACTUALIZAR =================
    public function update()
    {
        $this->validate([
            'nombre_torneo' => 'required',
            'precio' => 'required',
            'activo' => 'required',
            'api_league_id' => 'required',
        ]);

        if ($this->selected_id) {
            $record = Torneo::find($this->selected_id);

            $record->update([
                'nombre_torneo' => $this->nombre_torneo,
                'precio' => $this->precio,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'activo' => $this->activo,
                'api_league_id' => $this->api_league_id,
            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');

            session()->flash('message', 'Torneo actualizado con éxito.');
        }
    }

    // ================= ELIMINAR =================
    public function destroy($id)
    {
        if ($id) {
            Torneo::where('id', $id)->delete();
        }
    }
}
