<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Inscripcione;
use App\Models\User;
use App\Models\Torneo;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\PhoneCountryCode;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home'; // dashboard

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Mostrar formulario de registro
    public function showRegistrationForm(Request $request)
    {
        $torneoId = $request->query('torneoId');
        $countries = Country::orderBy('name')->get();
           $phoneCountryCodes = PhoneCountryCode::orderBy('country')->get();
    

        return view('auth.register', compact('torneoId', 'countries','phoneCountryCodes'));
    }

    // Validación del registro
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => 'required|min:3|max:20|unique:users,username',
            'country_id' => ['required', 'string', 'max:255'],
            'phone_country_code_id' => ['nullable','exists:phone_country_codes,id'],
            'phone' => ['nullable', 'regex:/^[0-9]{6,20}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cod_invitacion' => ['nullable', 'exists:users,cod_invitacion'], // verifica que el código exista
        ]);
    }

    // Crear usuario
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'country_id' => $data['country_id'],
            'phone_country_code_id' => $data['phone_country_code_id'] ?? null,
            'phone' => $data['phone'] ?? null,
            'puntos' => 0,
            'puntos_aux' => 0,
            'password' => Hash::make($data['password']),
            'referido' => $data['cod_invitacion'] ?? null,
        ])->assignRole('Jugador');
    }




}
