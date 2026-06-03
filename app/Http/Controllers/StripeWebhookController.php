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

        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $metadata = $session->metadata ?? null;

            if (!$metadata || empty($metadata->tipo) || empty($metadata->user_id)) {
                Log::warning('Stripe webhook sin metadata suficiente', [
                    'session_id' => $session->id ?? null,
                ]);

                return response('OK', 200);
            }

            if ($metadata->tipo === 'plan') {
                if (empty($metadata->plan_id)) {
                    return response('OK', 200);
                }

                Suscripcione::updateOrCreate(
                    [
                        'user_id' => $metadata->user_id,
                        'plan_id' => $metadata->plan_id,
                    ],
                    [
                        'estado' => 'activa',
                        'stripe_session_id' => $session->id,
                        'stripe_payment_intent_id' => $session->payment_intent ?? null,
                    ]
                );
            }

            if ($metadata->tipo === 'torneo') {
                if (empty($metadata->torneo_id)) {
                    return response('OK', 200);
                }

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