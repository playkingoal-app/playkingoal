<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class SuscripcionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar planes
    public function index()
    {
        $planes = Plan::where('activo', true)->get();

        return view('livewire.planes.index', compact('planes'));
    }

    // Iniciar pago de plan
    public function checkout($planId)
    {
        $plan = Plan::findOrFail($planId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',

            'client_reference_id' => Auth::id(),

            'metadata' => [
                'tipo' => 'plan',
                'user_id' => Auth::id(),
                'plan_id' => $plan->id,
            ],

            'payment_intent_data' => [
                'metadata' => [
                    'tipo' => 'plan',
                    'user_id' => Auth::id(),
                    'plan_id' => $plan->id,
                ],
            ],

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => (int) round($plan->precio * 100),
                        'product_data' => [
                            'name' => $plan->nombre,
                        ],
                    ],
                    'quantity' => 1,
                ]
            ],

            'success_url' => route('suscripcion.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('suscripcion.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    // Stripe success: NO activa la suscripción
   public function success()
{
    return redirect()->route('planes')
        ->with('success', __('subscriptions.subscription_processing'));
}

public function cancel()
{
    return redirect()->route('planes')
        ->with('warning', __('subscriptions.payment_cancelled'));
}
}