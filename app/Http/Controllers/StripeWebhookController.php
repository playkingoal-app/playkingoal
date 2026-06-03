<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Suscripcione;
use App\Models\Inscripcione;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            if (($session->payment_status ?? null) !== 'paid') {
                return response('OK', 200);
            }

            $metadata = $session->metadata ?? null;

            if (!$metadata || empty($metadata->tipo) || empty($metadata->user_id)) {
                return response('OK', 200);
            }

            if ($metadata->tipo === 'plan' && !empty($metadata->plan_id)) {
                Suscripcione::updateOrCreate(
                    [
                        'user_id' => $metadata->user_id,
                        'plan_id' => $metadata->plan_id,
                        
                    ],
                    [
                        'estado' => 'activa',

                        'inicia_en' => now(),

                        'vence_en' => '2026-07-19 23:59:59',

                        'stripe_session_id' => $session->id,

                        'stripe_payment_intent_id' => $session->payment_intent ?? null,
                    ]
                );
            }

            if ($metadata->tipo === 'torneo' && !empty($metadata->torneo_id)) {
                Inscripcione::updateOrCreate(
                    [
                        'user_id' => $metadata->user_id,
                        'torneo_id' => $metadata->torneo_id,
                    ],
                    [
                        'estado_pago' => 'activo',
                        'stripe_session_id' => $session->id,
                        'stripe_payment_intent_id' => $session->payment_intent ?? null,
                    ]
                );
            }
        }

        return response('OK', 200);
    }
}