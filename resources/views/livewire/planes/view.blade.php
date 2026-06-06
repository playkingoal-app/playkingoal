



@section('title', __('plans.title'))

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">
       
        <h1 class="plans-title mt-3">
            <i class="fa-solid fa-bag-shopping"
                                        style="color: #ff6600 !important"></i>  {{ __('plans.heading') }}
            
        </h1>

        <p class="plans-subtitle">
            {{ __('plans.subtitle') }}
        </p>
    </div>

    {{-- ALERTA --}}
    @if (session('mensaje'))
        <div class="alert alert-warning rounded-4 shadow-sm text-center mb-5">
            {{ session('mensaje') }}
        </div>
    @endif
    @if(session('success'))
    <div class="payment-toast success" id="paymentToast">
        <div class="payment-toast-icon">✓</div>

        <div class="payment-toast-content">
            <h4>{{ __('subscriptions.payment_success_title') }}</h4>
            <p>{{ session('success') }}</p>
        </div>

        <button class="payment-toast-close" onclick="document.getElementById('paymentToast').remove()">
            ×
        </button>
    </div>
@endif

@if(session('error'))
    <div class="payment-toast error" id="paymentToast">
        <div class="payment-toast-icon">!</div>

        <div class="payment-toast-content">
            <h4>{{ __('subscriptions.payment_error_title') }}</h4>
            <p>{{ session('error') }}</p>
        </div>

        <button class="payment-toast-close" onclick="document.getElementById('paymentToast').remove()">
            ×
        </button>
    </div>
@endif
<div class="d-flex justify-content-end mb-4">

    <form method="POST" action="{{ route('change.country') }}">
        @csrf

    <select
    name="country_code"
    class="form-select rounded-pill shadow-sm"
    onchange="this.form.submit()"
>
    <option value="CO" {{ session('country_code') === 'CO' ? 'selected' : '' }}>
        🇨🇴 COP
    </option>

    <option value="US" {{ session('country_code') === 'US' ? 'selected' : '' }}>
        🇺🇸 USD
    </option>

    <option value="EU" {{ session('country_code') === 'FR' ? 'selected' : '' }}>
        🇪🇺 EUR
    </option>
</select>
    </form>

</div>
    {{-- PLANES --}}
    <div class="row justify-content-center g-4">

        @forelse($planes as $plan)

            @php
                $countryCode = session('country_code', 'CO');

                $price = $plan->priceForCountry($countryCode);

                $amount = $price && $price->currency === 'COP'
                    ? $price->amount
                    : (($price?->amount ?? 0) / 100);

                $currency = $price?->currency ?? 'COP';

                $planKey = strtolower($plan->nombre);

                $isPro = $planKey === 'pro';

                $isSubscribed = in_array($plan->id, $suscripciones);
            @endphp

            <div class="col-12 col-md-6 col-lg-4">

                <div class="pricing-card {{ $isPro ? 'pricing-card-featured' : '' }}">

                    @if($isPro)
                        <div class="pricing-badge">
                            {{ __('plans.most_popular') }}
                        </div>
                    @endif

                    <div class="pricing-top">
                        <div class="pricing-accent"></div>

                        <h3 class="pricing-name">
                            {{ __('plans.items.' . $planKey . '.name') }}
                        </h3>

                        <p class="pricing-description">
                            {{ __('plans.items.' . $planKey . '.description') }}
                        </p>
                    </div>

                   <div class="pricing-price">

    @if($currency === 'COP')
        ${{ number_format($amount, 0, ',', '.') }} COP

    @elseif($currency === 'EUR')
        €{{ number_format($amount, 2, ',', '.') }}

    @elseif($currency === 'USD')
        ${{ number_format($amount, 2, '.', ',') }}

    @endif

</div>

                    <div class="pricing-period">
                        {{ __('plans.one_time_payment') }}
                    </div>

                    <div class="pricing-divider"></div>

                    <ul class="pricing-features">
                        <li>
                            {{ trans_choice('plans.groups', $plan->max_grupos, ['count' => $plan->max_grupos]) }}
                        </li>

                        <li>
                            {{ __('plans.participants', ['count' => $plan->max_usuarios_por_grupo]) }}
                        </li>

                        <li>
                            {{ __('plans.features.linked_tournament') }}
                        </li>

                        <li>
                            {{ __('plans.features.automatic_ranking') }}
                        </li>

                        <li>
                            {{ __('plans.features.match_predictions') }}
                        </li>

                        <li>
                            {{ __('plans.features.admin_panel') }}
                        </li>
                    </ul>

                    <div class="pricing-note">
                        {{ __('plans.items.' . $planKey . '.note') }}
                    </div>

                    @if (!$isSubscribed)

                        <button
                            wire:click="pagar({{ $plan->id }})"
                            wire:loading.attr="disabled"
                            class="pricing-button {{ $isPro ? 'pricing-button-featured' : '' }}"
                        >

                            <span wire:loading.remove wire:target="pagar({{ $plan->id }})">
                                {{ __('plans.choose_plan') }}
                            </span>

                            <span wire:loading wire:target="pagar({{ $plan->id }})">
                                {{ __('plans.processing') }}
                            </span>

                        </button>

                    @else

                        <span class="pricing-button pricing-button-success">
                            
                            {{ __('plans.subscribed') }}
                        </span>

                    @endif

                </div>

            </div>

        @empty

            <div class="col-12 text-center text-muted">
                {{ __('plans.empty') }}
            </div>

        @endforelse

    </div>

</div>

<style>
    .plans-badge {
        display: inline-block;
        padding: .5rem 1rem;
        border-radius: 999px;
        background: #fff4ef;
        color: #ff4500;
        border: 1px solid #ffd4c2;
        font-weight: 700;
        font-size: .85rem;
    }

    .plans-title {
        font-size: 2.4rem;
        font-weight: 800;
        
    }

    .plans-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .pricing-card {
        position: relative;
        height: 100%;
        padding: 1.8rem;
        border-radius: 1rem;
        background: #fff;
        border: 1px solid #dee2e6;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .2s ease;
    }

    .pricing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .pricing-card-featured {
        border: 2px solid #ff4500;
    }

    .pricing-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: #ff4500;
        color: #fff;
        padding: .35rem .75rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
    }

    .pricing-accent {
        width: 46px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .pricing-name {
        font-size: 1.6rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .pricing-description {
        color: #6c757d;
        font-size: .95rem;
        min-height: 48px;
    }

    .pricing-price {
        font-size: 2.1rem;
        font-weight: 800;
        color: #ff4500;
        margin-top: 1rem;
    }

    .pricing-period {
        color: #6c757d;
        font-size: .9rem;
        font-weight: 600;
    }

    .pricing-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .pricing-features {
        list-style: none;
        padding: 0;
        margin: 0 0 1.3rem;
    }

    .pricing-features li {
        padding: .55rem 0 .55rem 1.3rem;
        position: relative;
        color: #495057;
        font-size: .95rem;
        border-bottom: 1px solid #f1f3f5;
    }

    .pricing-features li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 1rem;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #ff4500;
    }

    .pricing-note {
        background: #f8f9fa;
        border-left: 4px solid #1e40af;
        border-radius: .75rem;
        padding: .9rem;
        color: #6c757d;
        font-size: .9rem;
        margin-bottom: 1.3rem;
    }

    .pricing-button {
    width: 100%;
    border: none;
    border-radius: 999px;
    padding: .85rem 1rem;
    background: #1e40af;
    color: #fff;
    font-weight: 700;
    transition: all .22s ease;
    box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
}

.pricing-button:hover {
    background: #3157d5;
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
}

.pricing-button-featured {
    background: #1e40af;
}

.pricing-button-featured:hover {
    background: #3157d5;
}

.pricing-button-success {
    display: block;
    text-align: center;
    background: #198754;
}

    @media(max-width: 991px) {
        .pricing-badge {
            position: static;
            display: inline-block;
            margin-bottom: 1rem;
        }
    }
    .payment-toast {
    position: fixed;
    top: 24px;
    right: 24px;
    width: 380px;
    max-width: calc(100vw - 40px);
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 18px;
    border-radius: 22px;
    box-shadow: 0 15px 40px rgba(0,0,0,.12);
    z-index: 99999;
    animation: toastIn .45s ease;
}

.payment-toast.success {
    background: rgba(240,253,244,.98);
    border: 1px solid #bbf7d0;
}

.payment-toast.error {
    background: rgba(254,242,242,.98);
    border: 1px solid #fecaca;
}

.payment-toast-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 20px;
    flex-shrink: 0;
}

.payment-toast.success .payment-toast-icon {
    background: #16a34a;
    color: white;
}

.payment-toast.error .payment-toast-icon {
    background: #dc2626;
    color: white;
}

.payment-toast-content h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 800;
    color: #111827;
}

.payment-toast-content p {
    margin: 5px 0 0;
    color: #6b7280;
    line-height: 1.5;
    font-size: 14px;
}

.payment-toast-close {
    margin-left: auto;
    border: none;
    background: none;
    font-size: 24px;
    cursor: pointer;
    color: #9ca3af;
}
@media (max-width: 768px){

    .payment-toast{
        left:16px;
        right:16px;
        top:16px;

        width:auto;

        border-radius:18px;

        padding:16px;
    }

    .payment-toast-content h4{
        font-size:14px;
    }

    .payment-toast-content p{
        font-size:13px;
    }

    .payment-toast-icon{
        width:38px;
        height:38px;
        font-size:17px;
    }

}
@keyframes toastIn {
    from {
        opacity: 0;
        transform: translateY(-10px) scale(.96);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
</style>
<script>
setTimeout(() => {
    const toast = document.getElementById('paymentToast');

    if (toast) {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-10px)';
        setTimeout(() => toast.remove(), 300);
    }
}, 5000);
</script>