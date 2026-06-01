<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Torneo;
use App\Models\Inscripcione;

class Suscripciones extends Component
{
    use WithFileUploads;

  
    public function render()
    {
        return view('livewire.suscripciones.view');
    }
}
