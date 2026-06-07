<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PhoneCountryCode;

class Perfils extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $phone_country_code_id = '';

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
        $phoneCountryCodes = PhoneCountryCode::orderBy('country')->get();

        return view('livewire.perfils.view', compact('country_name', 'invitados', 'phoneCountryCodes'));
    }
    public function editProfile()
    {

        $user = Auth::user();

        $this->name = Auth::user()->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->phone_country_code_id = $user->phone_country_code_id;
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

    'phone_country_code_id' => [
        'nullable',
        'exists:phone_country_codes,id',
    ],

    'phone' => [
        'nullable',
        'regex:/^[0-9]{8,15}$/',
    ],
], [
    'phone.regex' => __('profile.phone_invalid'),
]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone_country_code_id' => $this->phone_country_code_id ?: null,
            'phone' => $this->phone ?: null,
        ]);
        $this->dispatchBrowserEvent('closeModal');

        session()->flash('message', __('profile.profile_updated'));
    }

    public function cancel()
    {
        $this->resetValidation();
    }
}