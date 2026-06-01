<?php

namespace App\Http\Controllers;

use App\Models\Inscripcione;
use App\Models\Torneo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class InscripcionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Inscribirse y pagar un torneo
     * Si la inscripción existe y está pendiente, reutiliza la sesión de Stripe
     */
    public function inscribirse($torneoId)
    {
        $torneo = Torneo::findOrFail($torneoId);

        // Crear o reutilizar inscripción pendiente
        $inscripcion = Inscripcione::firstOrCreate(
            [
                'usuario_id' => Auth::id(),
                'torneo_id' => $torneo->id,
            ],
            [
                'estado_pago' => 'pendiente',
            ]
        );

        // Configurar Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => ['name' => $torneo->nombre_torneo],
                    'unit_amount' => (int)$torneo->precio , // precio en céntimos
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['inscripcion_id' => $inscripcion->id]),
            'cancel_url' => route('payment.cancel'),
        ]);

        // Guardar el ID de la sesión
        $inscripcion->update(['stripe_session_id' => $session->id]);

        return redirect()->away($session->url);
    }

    /**
     * Stripe success: actualizar inscripción
     */
    public function success($inscripcion_id)
    {
        $inscripcion = Inscripcione::findOrFail($inscripcion_id);

        $inscripcion->update(['estado_pago' => 'pagado']);

        return redirect('/home')->with('success', '✅ Pago realizado con éxito. ¡Ya puedes participar!');
    }

    /**
     * Stripe cancel: inscripción queda pendiente
     */
    public function cancel()
    {
        return redirect('/home')->with('warning', '❌ Pago cancelado. Puedes intentarlo de nuevo desde el dashboard.');
    }
}
