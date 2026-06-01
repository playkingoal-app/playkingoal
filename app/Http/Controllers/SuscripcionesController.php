<?php

namespace App\Http\Controllers;

use App\Models\Suscripcione;
use App\Models\Plan;
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

    // Iniciar pago de plan
    public function checkout($planId)
    {
        $plan = Plan::findOrFail($planId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'metadata' => [
                'tipo' => 'plan',
                'user_id' => Auth::id(),
                'plan_id' => $plan->id,
            ],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $plan->precio * 100,
                        'product_data' => ['name' => $plan->nombre],
                    ],
                    'quantity' => 1,
                ]
            ],
            'success_url' => route('suscripcion.success'),
            'cancel_url' => route('suscripcion.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    // Stripe success (simula webhook para desarrollo local)
    public function success()
    {
        // Obtenemos el último plan comprado por el usuario (modo simplificado)
        $planId = request()->get('plan_id');

        if (!$planId) {
            // Para pruebas, si no se pasa plan_id, tomamos el último plan activo
            $planId = Plan::where('activo', true)->latest()->first()->id;
        }

        // Crear la suscripción directamente (modo desarrollo)
        $suscripcion = Suscripcione::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'plan_id' => $planId,
                'inicia_en' => now(), 
                'vence_en' => now()->addMonth(), 
            ],
            [
                'estado' => 'activa',
            ]
        );

        return redirect()->route('planes',)
            ->with('success', '🎉 Pago procesado y suscripción activada (modo desarrollo).');
    }

    public function cancel()
    {
        return redirect()->route('planes')
            ->with('warning', '❌ Pago cancelado. Puedes intentarlo nuevamente.');
    }
}
