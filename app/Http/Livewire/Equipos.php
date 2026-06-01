<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Equipo;
Use Livewire\WithFileUploads;

class Equipos extends Component
{
    use WithPagination;
    use WithFileUploads;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre_equipo,$escudo;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.api-teams.view', [
            'equipos' => Equipo::with('league')
                ->where('name', 'LIKE', $keyWord)
                ->paginate(10)
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
    }
	
    private function resetInput()
    {		
		$this->nombre_equipo = null;
    }

    public function store()
    {
        $this->validate([
		'nombre_equipo' => 'required',
		'escudo' => 'required',

        ]);
        
        Equipo::create([ 
			'nombre_equipo' =>ucwords(mb_strtolower($this->nombre_equipo)),
			'escudo' => $this->escudo->store('escudos','public')

        ]);
        
        $this->resetInput();
		$this->dispatchBrowserEvent('closeModal');
		session()->flash('message', 'Equipo creado con éxito.');
    }

    public function edit($id)
    {
        $record = Equipo::findOrFail($id);
        $this->selected_id = $id; 
		$this->nombre_equipo = $record-> nombre_equipo;
		$this->escudo = $record-> escudo;

    }

    public function update()
    {
        $this->validate([
		'nombre_equipo' => 'required',
		'escudo' => 'required',

        ]);

        if ($this->selected_id) {
			$record = Equipo::find($this->selected_id);
            $record->update([ 
			'nombre_equipo' => $this-> nombre_equipo,
			'escudo' => $this->escudo->store('escudos','public')

            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');
			session()->flash('message', 'Equipo actualizado con éxito.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            Equipo::where('id', $id)->delete();
        }
    }
}