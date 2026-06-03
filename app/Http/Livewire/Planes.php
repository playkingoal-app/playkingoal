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

    $zeroDecimalCurrencies = ['COP', 'JPY', 'KRW', 'CLP', 'PYG'];

    $unitAmount = in_array(strtoupper($price->currency), $zeroDecimalCurrencies)
        ? (int) $price->amount
        : (int) round($price->amount * 100);

    $session = StripeSession::create([
        'payment_method_types' => ['card'],
        'mode' => 'payment',

        'client_reference_id' => auth()->id(),

        'metadata' => [
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'tipo' => 'plan',
            'country_code' => $countryCode,
        ],

        'payment_intent_data' => [
            'metadata' => [
                'user_id' => auth()->id(),
                'plan_id' => $plan->id,
                'tipo' => 'plan',
                'country_code' => $countryCode,
            ],
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

        'success_url' => route('suscripcion.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('suscripcion.cancel'),
    ]);

    return redirect()->away($session->url);
}
}
