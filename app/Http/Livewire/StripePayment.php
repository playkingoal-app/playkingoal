<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Torneo;

class StripePayment extends Component
{
    public $title;
    public $amount; // en centavos, ej: 2000 = 20€
    public $torneoId;
    public $user;

    public function mount($torneoId=null, $user = null)
     {
        $this->user = $user ?? auth()->user();
        if (!$this->user)
            abort(403, 'Usuario no autenticado');

        if (!$torneoId)
            return; // NO abortar aquí, lo manejaremos en checkout
        $this->torneoId = $torneoId;

        $torneo = Torneo::find($this->torneoId);
        if ($torneo) {
            $this->amount = (int) round($torneo->precio);
            $this->title = $torneo->nombre_torneo;
        }
    }

   public static function checkoutStatic($user, $torneoId)
{
    if (!$user) {
        abort(403, 'Usuario no autenticado');
    }

    $torneo = \App\Models\Torneo::find($torneoId);
    if (!$torneo) {
        abort(404, 'Torneo no encontrado');
    }

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $amount = (int) round($torneo->precio);
    $title = $torneo->nombre_torneo;

    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => $title],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('payment.success', [
            'userId' => $user->id,
            'torneoId' => $torneoId
        ]),
        'cancel_url' => route('payment.cancel', [], true),
    ]);

    // Guardar inscripción en estado pendiente
    \DB::table('inscripciones')->updateOrInsert(
        ['usuario' => $user->id, 'torneo' => $torneoId],
        ['estado_pago' => 'pendiente', 'updated_at' => now()]
    );

    return redirect()->away($session->url);
}


    public function success($userId, $torneoId)
    {
        $inscripcion = \DB::table('inscripciones')
            ->where('usuario', $userId)
            ->where('torneo', $torneoId)
            ->first();

        if ($inscripcion) {
            \DB::table('inscripciones')
                ->where('id', $inscripcion->id)
                ->update([
                    'estado_pago' => 'pagado',
                    'updated_at' => now()
                ]);
        }

        return redirect('/home')->with('success', '✅ Pago realizado con éxito. Bienvenido!');
    }

    public function cancel()
    {
        return redirect('/payment-cancel');
    }

    public function render()
    {
        return view('livewire.stripe-payment');
    }
}