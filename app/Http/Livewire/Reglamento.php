<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Jugadore;
use Illuminate\Support\Facades\DB;



class Reglamento extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre_equipo;

    public function render()
    {
       
		
        
         return view('livewire.reglamento.view', [
        
        ]);
    }
}