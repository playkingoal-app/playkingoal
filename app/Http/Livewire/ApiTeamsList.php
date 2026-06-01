<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ApiTeam;

class ApiTeamsList extends Component
{
    use WithPagination;

    public $keyWord;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';

        return view('livewire.api-teams.view', [
            'equipos' => ApiTeam::with('league')
                ->where('name', 'LIKE', $keyWord)
                ->paginate(10)
        ]);
    }
    public function updatingKeyWord()
{
    $this->resetPage();
}

}
