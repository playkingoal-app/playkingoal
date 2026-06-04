@extends('layouts.app')

@section('content')

<div class="payment-result-page">
    <div class="payment-result-card {{ $status }}">

        <div class="payment-icon">
            @if($status === 'success')
                <i class="bi bi-check-lg"></i>
            @elseif($status === 'pending')
                <i class="bi bi-hourglass-split"></i>
            @elseif($status === 'cancel')
                <i class="bi bi-x-lg"></i>
            @else
                <i class="bi bi-exclamation-lg"></i>
            @endif
        </div>

        <h1>{{ $title }}</h1>

        <p>{{ $message }}</p>

        @if($status === 'pending')
            <div class="payment-spinner"></div>
            <small>{{ __('subscriptions.payment_pending_hint') }}</small>
        @endif

        <div class="payment-actions">
            <a href="{{ route('planes') }}" class="payment-btn primary">
                {{ __('subscriptions.back_to_plans') }}
            </a>

            <a href="{{ route('home') }}" class="payment-btn secondary">
                {{ __('subscriptions.go_to_dashboard') }}
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const status = @json($status);
    const title = @json($title);
    const message = @json($message);

    let icon = 'info';

    if (status === 'success') icon = 'success';
    if (status === 'error') icon = 'error';
    if (status === 'cancel') icon = 'warning';
    if (status === 'pending') icon = 'info';

    Swal.fire({
        icon: icon,
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#1e40af',
        background: '#ffffff',
        color: '#111827',
    });
});
</script>

<style>
.payment-result-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #111827, #1e40af);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
}

.payment-result-card {
    width: 100%;
    max-width: 520px;
    background: #ffffff;
    border-radius: 28px;
    padding: 2.5rem;
    text-align: center;
    box-shadow: 0 25px 70px rgba(0,0,0,.28);
}

.payment-icon {
    width: 92px;
    height: 92px;
    border-radius: 50%;
    margin: 0 auto 1.4rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.6rem;
    font-weight: 900;
}

.payment-result-card.success .payment-icon {
    background: #dcfce7;
    color: #16a34a;
}

.payment-result-card.pending .payment-icon {
    background: #dbeafe;
    color: #1e40af;
}

.payment-result-card.cancel .payment-icon {
    background: #ffedd5;
    color: #ea580c;
}

.payment-result-card.error .payment-icon {
    background: #fee2e2;
    color: #dc2626;
}

.payment-result-card h1 {
    font-size: 2rem;
    font-weight: 900;
    color: #111827;
    margin-bottom: .8rem;
}

.payment-result-card p {
    color: #6b7280;
    line-height: 1.7;
    margin-bottom: 1.4rem;
}

.payment-spinner {
    width: 44px;
    height: 44px;
    border: 4px solid #dbeafe;
    border-top-color: #1e40af;
    border-radius: 50%;
    margin: 1rem auto;
    animation: spin .8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.payment-actions {
    display: flex;
    gap: .8rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.payment-btn {
    border-radius: 999px;
    padding: .85rem 1.3rem;
    font-weight: 800;
    text-decoration: none;
}

.payment-btn.primary {
    background: #1e40af;
    color: #fff;
}

.payment-btn.secondary {
    background: #f3f4f6;
    color: #111827;
}
</style>

@endsection