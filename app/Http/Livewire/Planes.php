<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Suscripcione;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;



class Planes extends Component
{


    public function render()
    {
        // Obtener planes a los que el usuario ya está suscrito
        $suscripciones = Suscripcione::where('user_id', Auth::id())
            ->where('estado', 'activa')
            ->pluck('plan_id') // solo necesitamos los IDs
            ->toArray();
        $planes = Plan::where('activo', true)->get();

        return view('livewire.planes.view', compact('planes', 'suscripciones'));
    }


    public function pagar($planId)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $plan = Plan::findOrFail($planId);

    $countryCode = session('country_code', 'CO');
    $price = $plan->priceForCountry($countryCode);

    if (!$price || $price->amount <= 0) {
        session()->flash('mensaje', 'No hay precio válido para este país.');
        return;
    }

    Stripe::setApiKey(config('services.stripe.secret'));

    $unitAmount = $price->currency === 'COP'
    ? ((int) $price->amount * 100)
    : (int) $price->amount;

$session = StripeSession::create([
    'payment_method_types' => ['card'],
    'mode' => 'payment',

    'metadata' => [
        'user_id' => auth()->id(),
        'plan_id' => $plan->id,
        'tipo' => 'plan',
        'country_code' => $countryCode,
    ],

    'line_items' => [[
        'price_data' => [
            'currency' => strtolower($price->currency),
            'unit_amount' => $unitAmount,
            'product_data' => [
                'name' => $plan->nombre,
            ],
        ],
        'quantity' => 1,
    ]],

    'success_url' => route('suscripcion.success'),
    'cancel_url' => route('suscripcion.cancel'),
]);

    return redirect()->away($session->url);
}
}
