<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Suscripcione;
use Illuminate\Http\Request;
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

    // Checkout Stripe
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

                        // SI 59€ ESTA GUARDADO COMO 5900
                        'unit_amount' => (int) $plan->precio,

                        'product_data' => [
                            'name' => $plan->nombre,
                        ],
                    ],

                    'quantity' => 1,
                ]
            ],

            'success_url' =>
                route('suscripcion.success')
                . '?session_id={CHECKOUT_SESSION_ID}',

            'cancel_url' =>
                route('suscripcion.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    // Pago exitoso
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {

            return redirect()->route('planes')
                ->with(
                    'error',
                    __('subscriptions.payment_error_message')
                );
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {

            $session = StripeSession::retrieve($sessionId);

        } catch (\Exception $e) {

            return redirect()->route('planes')
                ->with(
                    'error',
                    __('subscriptions.payment_error_message')
                );
        }

        // SOLO PARA LOCAL
        if (
            app()->environment('local')
            && $session->payment_status === 'paid'
        ) {

            Suscripcione::updateOrCreate(
                [
                    'user_id' =>
                        $session->metadata->user_id,

                    'plan_id' =>
                        $session->metadata->plan_id,
                ],
                [
                    'estado' => 'activa',

                    'inicia_en' => now(),

                    'vence_en' => '2026-07-19',

                    'stripe_session_id' => $session->id,

                    'stripe_payment_intent_id' =>
                        $session->payment_intent ?? null,
                ]
            );
        }

        if ($session->payment_status === 'paid') {

            return redirect()->route('planes')
                ->with(
                    'success',
                    __('subscriptions.payment_success_message')
                );
        }

        return redirect()->route('planes')
            ->with(
                'error',
                __('subscriptions.payment_error_message')
            );
    }

    // Pago cancelado
    public function cancel()
    {
        return redirect()->route('planes')
            ->with(
                'error',
                __('subscriptions.payment_cancelled_message')
            );
    }
}