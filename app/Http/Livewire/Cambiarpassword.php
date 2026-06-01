<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Cambiarpassword extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selected_id;
    public $keyWord;
    public $newpassword;
    public $newpassword_confirmation;

    protected $listeners = ['updatePassword'];

    public function render()
    {
        return view('livewire.cambiarpassword.view');
    }

    private function resetInput()
    {
        $this->newpassword = null;
        $this->newpassword_confirmation = null;
    }

    public function updatePassword($id)
    {
        $this->validate([
            'newpassword' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'newpassword.required' => __('change_password.validation.required'),
            'newpassword.min' => __('change_password.validation.min'),
            'newpassword.confirmed' => __('change_password.validation.confirmed'),
        ]);

        $record = User::findOrFail(auth()->id());

        $record->update([
            'password' => Hash::make($this->newpassword),
        ]);

        $this->resetInput();

        session()->flash('message', __('change_password.success'));
    }
}