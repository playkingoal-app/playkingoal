<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Suscripcione;
use App\Models\Inscripcione;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $secret
            );
        } catch (\Exception $e) {
            return response('Invalid signature', 400);
        }

        // EVENTO CLAVE
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            //  PAGO DE PLAN (SaaS)
            if ($session->metadata->tipo === 'plan') {

                Suscripcione::updateOrCreate(
                    [
                        'user_id' => $session->metadata->user_id,
                        'plan_id' => $session->metadata->plan_id,
                    ],
                    [
                        'estado' => 'activa',
                        'stripe_session_id' => $session->id,
                    ]
                );
            }

            //PAGO DE TORNEO
            if ($session->metadata->tipo === 'torneo') {

                Inscripcione::updateOrCreate(
                    [
                        'user_id' => $session->metadata->user_id,
                        'torneo_id' => $session->metadata->torneo_id,
                    ],
                    [
                        'estado_pago' => 'activo',
                        'stripe_session_id' => $session->id,
                    ]
                );
            }
        }

        return response('OK', 200);
    }
}
