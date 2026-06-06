<div>
@section('title', __('subscriptions.title'))

{{-- Bootstrap Icons --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container py-5">

    {{-- Mensajes flash --}}
    @if (session()->has('success'))
        <div wire:poll.4s class="alert alert-success text-center shadow-sm rounded-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div wire:poll.4s class="alert alert-danger text-center shadow-sm rounded-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="text-center mb-5">

        <h1 class="subscriptions-title mt-3">
            <i class="fa-solid fa-star" style="color: #ff6600 !important"></i>
            {{ __('subscriptions.my_subscriptions') }}
        </h1>

        <p class="subscriptions-subtitle">
            {{ __('subscriptions.title') }}
        </p>

    </div>

    {{-- RESUMEN --}}
    <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">

        <div class="subscriptions-status-badge success">
            <i class="bi bi-check-circle"></i>
            <span>
                {{ $inscripciones ? $inscripciones->count() : 0 }}
                {{ __('subscriptions.my_subscriptions') }}
            </span>
        </div>

        <div class="subscriptions-status-badge warning">
            <i class="bi bi-trophy"></i>
            <span>
                {{ $torneos->count() }}
                {{ __('subscriptions.sponsored_tournaments') }}
            </span>
        </div>

    </div>

    {{-- MIS INSCRIPCIONES --}}
    <div class="subscription-section-card mb-5">

        <div class="subscription-top">

            <div class="subscription-accent"></div>

            <div class="d-flex justify-content-between align-items-start gap-3">

                <div>
                    <h3 class="subscription-name">
                        {{ __('subscriptions.my_subscriptions') }}
                    </h3>

                    <p class="subscription-description">
                        {{ __('subscriptions.no_active') }}
                    </p>
                </div>

                <div class="subscription-icon success">
                    <i class="bi bi-person-check"></i>
                </div>

            </div>

        </div>

        <div class="subscription-divider"></div>

        @if ($inscripciones && $inscripciones->count())

            <div class="row g-4">

                @foreach ($inscripciones as $inscripcion)

                    <div class="col-12 col-md-6 col-lg-4">

                        <div class="subscription-card h-100">

                            <div class="subscription-accent"></div>

                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

                                <h5 class="subscription-card-title mb-0">
                                    {{ $inscripcion->torneo->nombre_torneo }}
                                </h5>

                                <span class="badge rounded-pill px-3 py-2 bg-{{ $inscripcion->estado_pago === 'activa' ? 'success' : 'warning' }}-subtle text-{{ $inscripcion->estado_pago === 'activa' ? 'success' : 'warning' }}-emphasis">
                                    {{ ucfirst($inscripcion->estado_pago) }}
                                </span>

                            </div>

                            <p class="subscription-meta">
                                <i class="bi bi-calendar-event"></i>
                                {{ $inscripcion->torneo->fecha_inicio }}
                                →
                                {{ $inscripcion->torneo->fecha_fin }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="subscription-empty">

                <i class="bi bi-inbox"></i>

                <h6 class="fw-bold mt-3 mb-1">
                    {{ __('subscriptions.no_active') }}
                </h6>

                <p class="text-muted mb-0">
                    {{ __('subscriptions.explore_tournaments') }}
                </p>

            </div>

        @endif

    </div>

    {{-- TORNEOS PATROCINADOS --}}
    <div class="subscription-section-card">

        <div class="subscription-top">

            <div class="subscription-accent"></div>

            <div class="d-flex justify-content-between align-items-start gap-3">

                <div>
                    <h3 class="subscription-name">
                        {{ __('subscriptions.sponsored_tournaments') }}
                    </h3>

                    <p class="subscription-description">
                        {{ __('subscriptions.sponsored_tournaments_description') }}
                    </p>
                </div>

                <div class="subscription-icon warning">
                    <i class="bi bi-trophy"></i>
                </div>

            </div>

        </div>

        <div class="subscription-divider"></div>

        <div class="row g-4">

            @foreach ($torneos as $torneo)

                <div class="col-12 col-md-6 col-lg-4">

                    <div class="subscription-card h-100 text-center">

                        <div class="subscription-accent mx-auto"></div>

                        <h5 class="subscription-card-title text-dark mb-3">
                            {{ $torneo->nombre_torneo }}
                        </h5>

                        <p class="subscription-price mb-2">
                            {{ __('subscriptions.entry_requires_approval') }}
                        </p>

                        <p class="subscription-meta justify-content-center mb-4">
                            <i class="bi bi-calendar-event"></i>
                            {{ $torneo->fecha_inicio }}
                            →
                            {{ $torneo->fecha_fin }}
                        </p>

                        @php
                            $inscrito = $inscripciones->where('torneo_id', $torneo->id)->count() > 0;
                        @endphp

                        @if ($inscrito)

                            <button type="button"
                                    class="subscription-button disabled w-100"
                                    disabled>
                                {{ __('subscriptions.already_registered') }}
                            </button>

                        @else

                            <button type="button"
                                    class="subscription-button primary w-100"
                                    wire:click="seleccionarTorneo({{ $torneo->id }})"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalInscripcion">
                                {{ __('subscriptions.view_and_request') }}
                            </button>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    {{-- MODAL ÚNICA --}}
    <div class="modal fade"
         id="modalInscripcion"
         tabindex="-1"
         aria-hidden="true"
         data-bs-backdrop="static"
         wire:ignore.self>

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content sponsored-access-modal">

                <div class="sponsored-access-header">

                    <div>

                        <div class="sponsored-access-accent"></div>

                        <span class="sponsored-access-badge">
                            {{ __('subscriptions.sponsored_group') }}
                        </span>

                        <h4 class="sponsored-access-title">
                            {{ __('subscriptions.represent_country') }}
                        </h4>

                        <p class="sponsored-access-subtitle">
                            {{ __('subscriptions.sponsored_group_intro') }}
                        </p>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="sponsored-access-body">

                    <div class="sponsored-tournament-card mb-4">

                        <div class="sponsored-tournament-icon">
                            <i class="bi bi-trophy-fill"></i>
                        </div>

                        <div>
                            <h5>
                                {{ optional($this->torneoSeleccionado)->nombre_torneo }}
                            </h5>

                            <p>
                                {{ __('subscriptions.sponsored_competition_text') }}
                            </p>
                        </div>

                    </div>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <div class="sponsored-benefit">
                                <i class="bi bi-flag-fill"></i>
                                {{ __('subscriptions.benefit_country') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="sponsored-benefit">
                                <i class="bi bi-bar-chart-fill"></i>
                                {{ __('subscriptions.benefit_ranking') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="sponsored-benefit">
                                <i class="bi bi-gift-fill"></i>
                                {{ __('subscriptions.benefit_prizes') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="sponsored-benefit">
                                <i class="bi bi-lightning-charge-fill"></i>
                                {{ __('subscriptions.benefit_realtime') }}
                            </div>
                        </div>

                    </div>

                    <div class="sponsored-info mb-4">

                        <i class="bi bi-shield-check"></i>

                        <div>
                            <h6>
                                {{ __('subscriptions.access_requirements') }}
                            </h6>

                            <p>
                                {{ __('subscriptions.access_requirements_text') }}
                            </p>
                        </div>

                    </div>

                    <div class="sponsored-note mb-4">

                        <i class="bi bi-info-circle"></i>

                        <p>
                            {{ __('subscriptions.access_review_note') }}
                        </p>

                    </div>
<div class="sponsored-access-actions">

    <button type="button"
            class="sponsored-access-primary"
            wire:click="inscribirse"
            data-bs-dismiss="modal"
            wire:loading.attr="disabled"
            wire:target="inscribirse">

        <i class="bi bi-send-check-fill"></i>
        {{ __('subscriptions.request_access') }}

    </button>

</div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

    .subscriptions-title {
        font-size: 2.4rem;
        font-weight: 800;
    }

    .subscriptions-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .subscriptions-status-badge {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .65rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .9rem;
        border: 1px solid transparent;
    }

    .subscriptions-status-badge.warning {
        background: #fff4ef;
        color: #ff4500;
        border-color: #ffd4c2;
    }

    .subscriptions-status-badge.success {
        background: #eef8f2;
        color: #198754;
        border-color: #cfead9;
    }

    .subscription-section-card,
    .subscription-card {
        position: relative;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .2s ease;
    }

    .subscription-section-card {
        padding: 1.8rem;
    }

    .subscription-card {
        padding: 1.5rem;
    }

    .subscription-card:hover,
    .subscription-section-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .subscription-accent {
        width: 46px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .subscription-name {
        font-size: 1.6rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .subscription-description {
        color: #6c757d;
        font-size: .95rem;
        margin-bottom: 0;
    }

    .subscription-icon {
        width: 48px;
        height: 48px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .subscription-icon.warning {
        background: #fff4ef;
        color: #ff4500;
    }

    .subscription-icon.success {
        background: #eef8f2;
        color: #198754;
    }

    .subscription-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .subscription-card-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #212529;
    }

    .subscription-meta {
        display: flex;
        align-items: center;
        gap: .45rem;
        color: #6c757d;
        font-size: .9rem;
        margin-bottom: .5rem;
    }

    .subscription-price {
        font-size: 1rem;
        font-weight: 800;
        color: #ff4500;
    }

    .subscription-button {
        border: none;
        border-radius: 999px;
        padding: .6rem 1rem;
        font-weight: 700;
        font-size: .85rem;
        text-decoration: none;
        transition: all .22s ease;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
    }

    .subscription-button.primary {
        background: #1e40af;
        color: #fff;
        box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
    }

    .subscription-button.primary:hover {
        background: #3157d5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
    }

    .subscription-button.secondary {
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    .subscription-button.disabled {
        background: #adb5bd;
        color: #fff;
        cursor: not-allowed;
    }

    .subscription-empty {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #6c757d;
    }

    .subscription-empty i {
        font-size: 2.8rem;
        color: #adb5bd;
    }

    .sponsored-access-modal {
        border: none;
        border-radius: 1.3rem;
        overflow: hidden;
        box-shadow: 0 1rem 2.5rem rgba(0,0,0,.16);
    }

    .sponsored-access-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.8rem;
        border-bottom: 1px solid #dee2e6;
        background: #fff;
    }

    .sponsored-access-accent {
        width: 46px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .sponsored-access-badge {
        display: inline-flex;
        padding: .45rem .85rem;
        border-radius: 999px;
        background: #fff4ef;
        color: #ff6600;
        border: 1px solid #ffd4c2;
        font-weight: 800;
        font-size: .82rem;
        margin-bottom: 1rem;
    }

    .sponsored-access-title {
        font-size: 1.7rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .sponsored-access-subtitle {
        color: #6c757d;
        margin-bottom: 0;
        max-width: 620px;
    }

    .sponsored-access-body {
        padding: 1.8rem;
        background: #fff;
    }

    .sponsored-tournament-card {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border-radius: 1rem;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .sponsored-tournament-icon {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        background: #fff4ef;
        color: #ff6600;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .sponsored-tournament-card h5 {
        font-weight: 800;
        margin-bottom: .35rem;
        color: #212529;
    }

    .sponsored-tournament-card p {
        color: #6c757d;
        margin-bottom: 0;
    }

    .sponsored-benefit {
        height: 100%;
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: .9rem 1rem;
        border-radius: 1rem;
        background: #fff;
        border: 1px solid #dee2e6;
        color: #495057;
        font-weight: 700;
        box-shadow: 0 .35rem .9rem rgba(0,0,0,.04);
    }

    .sponsored-benefit i {
        color: #1e40af;
    }

    .sponsored-info {
        display: flex;
        gap: .9rem;
        padding: 1rem;
        border-radius: 1rem;
        background: #eef4ff;
        border: 1px solid #dbe7ff;
    }

    .sponsored-info i {
        color: #1e40af;
        font-size: 1.3rem;
        margin-top: .1rem;
    }

    .sponsored-info h6 {
        font-weight: 800;
        margin-bottom: .35rem;
    }

    .sponsored-info p {
        color: #495057;
        margin-bottom: 0;
    }

    .sponsored-note {
        display: flex;
        gap: .75rem;
        padding: 1rem;
        border-radius: 1rem;
        background: #fff4ef;
        border: 1px solid #ffd4c2;
    }

    .sponsored-note i {
        color: #ff6600;
        font-size: 1.15rem;
        margin-top: .1rem;
    }

    .sponsored-note p {
        margin-bottom: 0;
        color: #6c757d;
    }

    .sponsored-access-actions {
        display: flex;
        justify-content: flex-end;
        gap: .8rem;
        padding-top: 1.2rem;
        border-top: 1px solid #dee2e6;
    }

    .sponsored-access-primary,
    .sponsored-access-secondary {
        border: none;
        border-radius: 999px;
        min-height: 46px;
        padding: .75rem 1.2rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
    }

    .sponsored-access-primary {
        background: #1e40af;
        color: #fff;
        box-shadow: 0 8px 20px rgba(30,64,175,.18);
    }

    .sponsored-access-secondary {
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    @media(max-width: 575px) {

        .subscriptions-title {
            font-size: 2rem;
        }

        .subscription-section-card {
            padding: 1.3rem;
        }

        .subscription-button {
            width: 100%;
        }

        .sponsored-access-header,
        .sponsored-access-body {
            padding: 1.3rem;
        }

        .sponsored-tournament-card {
            flex-direction: column;
        }

        .sponsored-access-actions {
            flex-direction: column-reverse;
        }

        .sponsored-access-primary,
        .sponsored-access-secondary {
            width: 100%;
        }

    }

</style>

<script>
    window.addEventListener('closeModalInscripcion', () => {
        const modalElement = document.getElementById('modalInscripcion');

        if (!modalElement) return;

        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
        modalInstance.hide();

        setTimeout(() => {
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
            document.body.style.removeProperty('overflow');

            document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                backdrop.remove();
            });
        }, 300);
    });
</script>
</div>