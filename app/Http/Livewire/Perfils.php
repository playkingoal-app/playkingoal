<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Perfils extends Component
{
   public $name = '';
public $email = '';


public function render()
{
   

    $country_name = DB::table('countries')
        ->where('id', Auth::user()->country_id)
        ->pluck('name')
        ->first();

    $user = Auth::user();

    $invitados = User::where('referido', $user->cod_invitacion)
        ->latest()
        ->get();

    return view('livewire.perfils.view', compact('country_name', 'invitados'));
}
    public function editProfile()
    {
  
        $user = Auth::user();

        $this->name =  Auth::user()->name;
        $this->email = $user->email;

        $this->dispatchBrowserEvent('open-update-profile-modal');
    }

public function updateProfile()
{
    $user = Auth::user();

    $this->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($user->id),
        ],
    ]);

    $user->update([
        'name' => $this->name,
        'email' => $this->email,
    ]);
      $this->dispatchBrowserEvent('closeModal');

    session()->flash('message', __('profile.profile_updated'));
}

    public function cancel()
    {
        $this->resetValidation();
    }
}