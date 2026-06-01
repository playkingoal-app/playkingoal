
{{-- Bootstrap Icons --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">

        <h1 class="invitations-title mt-3">
            <i class="fa-solid fa-envelope-circle-check" style="color: #ff6600 !important"></i>  {{ __('invitations.title') }}
        </h1>

        <p class="invitations-subtitle">
            {{ __('invitations.subtitle') }}
        </p>

    </div>

    {{-- RESUMEN --}}
    <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">

        <div class="invitations-status-badge warning">
            <i class="bi bi-clock-history"></i>

            <span>
                {{ $pendientes->count() }}
                {{ __('invitations.pending_count') }}
            </span>
        </div>

        <div class="invitations-status-badge success">
            <i class="bi bi-check-circle"></i>

            <span>
                {{ $aprobados->count() }}
                {{ __('invitations.approved_count') }}
            </span>
        </div>

    </div>

    <div class="row justify-content-center g-4">

        {{-- PENDIENTES --}}
        <div class="col-12 col-lg-6">

            <div class="invitation-card h-100">

                <div class="invitation-top">

                    <div class="invitation-accent"></div>

                    <div class="d-flex justify-content-between align-items-start gap-3">

                        <div>

                            <h3 class="invitation-name">
                                {{ __('invitations.pending_title') }}
                            </h3>

                            <p class="invitation-description">
                                {{ __('invitations.pending_description') }}
                            </p>

                        </div>

                        <div class="invitation-icon warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>

                    </div>

                </div>

                <div class="invitation-divider"></div>

                @forelse($pendientes as $grupo)

                    <div class="invitation-item">

                        <div>

                            <div class="fw-semibold text-dark">
                                {{ $grupo->nombre }}
                            </div>

                            <small class="text-muted">
                                {{ __('invitations.pending_review') }}
                            </small>

                        </div>

                        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis px-3 py-2">
                            {{ __('invitations.pending_badge') }}
                        </span>

                    </div>

                @empty

                    <div class="invitation-empty">

                        <i class="bi bi-inbox"></i>

                        <h6 class="fw-bold mt-3 mb-1">
                            {{ __('invitations.no_pending_title') }}
                        </h6>

                        <p class="text-muted mb-0">
                            {{ __('invitations.no_pending_description') }}
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

        {{-- APROBADOS --}}
        <div class="col-12 col-lg-6">

            <div class="invitation-card h-100">

                <div class="invitation-top">

                    <div class="invitation-accent"></div>

                    <div class="d-flex justify-content-between align-items-start gap-3">

                        <div>

                            <h3 class="invitation-name">
                                {{ __('invitations.approved_title') }}
                            </h3>

                            <p class="invitation-description">
                                {{ __('invitations.approved_description') }}
                            </p>

                        </div>

                        <div class="invitation-icon success">
                            <i class="bi bi-check2-circle"></i>
                        </div>

                    </div>

                </div>

                <div class="invitation-divider"></div>

                @forelse($aprobados as $grupo)

                    <div class="invitation-item">

                        <div>

                            <div class="fw-semibold text-dark">
                                {{ $grupo->nombre }}
                            </div>

                            <small class="text-muted">
                                {{ __('invitations.approved_member') }}
                            </small>

                        </div>

                        <a href="{{ route('groups.panel', $grupo->id) }}"
                           class="invitation-button">
                            {{ __('invitations.enter') }}
                        </a>

                    </div>

                @empty

                    <div class="invitation-empty">

                        <i class="bi bi-people"></i>

                        <h6 class="fw-bold mt-3 mb-1">
                            {{ __('invitations.no_approved_title') }}
                        </h6>

                        <p class="text-muted mb-0">
                            {{ __('invitations.no_approved_description') }}
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

<style>

    .invitations-title {
        font-size: 2.4rem;
        font-weight: 800;
       
    }

    .invitations-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .invitations-status-badge {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .65rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .9rem;
        border: 1px solid transparent;
    }

    .invitations-status-badge.warning {
        background: #fff4ef;
        color: #ff4500;
        border-color: #ffd4c2;
    }

    .invitations-status-badge.success {
        background: #eef8f2;
        color: #198754;
        border-color: #cfead9;
    }

    .invitation-card {
        position: relative;
        height: 100%;
        padding: 1.8rem;
        border-radius: 1rem;
        background: #fff;
        border: 1px solid #dee2e6;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .2s ease;
    }

    .invitation-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .invitation-accent {
        width: 46px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .invitation-name {
        font-size: 1.6rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .invitation-description {
        color: #6c757d;
        font-size: .95rem;
        margin-bottom: 0;
    }

    .invitation-icon {
        width: 48px;
        height: 48px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .invitation-icon.warning {
        background: #fff4ef;
        color: #ff4500;
    }

    .invitation-icon.success {
        background: #eef8f2;
        color: #198754;
    }

    .invitation-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .invitation-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f5;
    }

    .invitation-item:last-child {
        border-bottom: none;
    }

    .invitation-button {
        border: none;
        border-radius: 999px;
        padding: .55rem 1rem;
        background: #1e40af;
        color: #fff;
        font-weight: 700;
        font-size: .85rem;
        text-decoration: none;
        transition: all .22s ease;
        box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
        white-space: nowrap;
    }

    .invitation-button:hover {
        background: #3157d5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
    }

    .invitation-empty {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #6c757d;
    }

    .invitation-empty i {
        font-size: 2.8rem;
        color: #adb5bd;
    }

    @media(max-width: 575px) {

        .invitation-item {
            align-items: flex-start;
            flex-direction: column;
        }

        .invitation-button {
            width: 100%;
            text-align: center;
        }

    }

</style>
```
