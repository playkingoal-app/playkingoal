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
    

        return view('auth.register', compact('torneoId', 'countries'));
    }

    // Validación del registro
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'string', 'max:255'],
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
            'puntos' => 0,
            'puntos_aux' => 0,
            'password' => Hash::make($data['password']),
            'referido' => $data['cod_invitacion'] ?? null,
        ])->assignRole('Jugador');
    }




}
