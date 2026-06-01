@section('title', __('group_invitation.title'))

<div class="container py-5">

    <div class="row g-4">

        {{-- ALERTS --}}
        <div class="col-12">

            @if (session()->has('success'))
                <div class="alert alert-success rounded-4 shadow-sm text-center mb-0">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('info'))
                <div class="alert alert-info rounded-4 shadow-sm text-center mb-0">
                    {{ session('info') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger rounded-4 shadow-sm text-center mb-0">
                    {{ session('error') }}
                </div>
            @endif

        </div>

        {{-- LEFT --}}
        <div class="col-12 col-lg-5">

            <div class="invite-card h-100">
                <div class="invite-card-body">

                    {{-- HEADER --}}
                    <div class="d-flex align-items-start justify-content-between">

                        <div>

                            <div class="invite-badge-dark mb-2">
                                <i class="fa-solid fa-envelope-open-text me-1"></i>
                                {{ __('group_invitation.group_invitation') }}
                            </div>

                            <h3 class="invite-group-title">
                                {{ $grupo->nombre }}
                            </h3>

                            <div class="text-muted small">
                                @if($propietario)
                                    {{ __('group_invitation.admin') }}:
                                    <strong>{{ $propietario->name }}</strong>
                                @else
                                    {{ __('group_invitation.group_admin') }}
                                @endif
                            </div>

                        </div>

                        <div class="text-end">
                            <div class="small text-muted">
                                {{ __('group_invitation.members') }}
                            </div>

                            <div class="fw-bold fs-3">
                                {{ $aprobadosCount }}
                            </div>
                        </div>

                    </div>

                    <div class="invite-divider"></div>

                    {{-- STATS --}}
                    <div class="row g-3">

                        <div class="col-6">
                            <div class="invite-stat-card">
                                <div class="text-muted small">
                                    {{ __('group_invitation.approved') }}
                                </div>

                                <div class="fw-bold fs-5">
                                    {{ $aprobadosCount }}
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="invite-stat-card">
                                <div class="text-muted small">
                                    {{ __('group_invitation.pending') }}
                                </div>

                                <div class="fw-bold fs-5">
                                    {{ $pendientesCount }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="invite-divider"></div>

                    {{-- CTA --}}
                    @guest

                        <div class="alert alert-warning rounded-4">
                            <div class="fw-bold mb-1">
                                {{ __('group_invitation.login_required') }}
                            </div>

                            <div class="small mb-0">
                                {{ __('group_invitation.login_required_text') }}
                            </div>
                        </div>

                        <a href="{{ route('login') }}" class="invite-button-dark w-100">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>
                            {{ __('group_invitation.login') }}
                        </a>

                    @else

                        {{-- ADMIN --}}
                        @if($rolMiembro === 'admin')

                            <div class="alert alert-primary rounded-4">
                                <div class="fw-bold mb-1">
                                    {{ __('group_invitation.you_are_admin') }}
                                </div>

                                <div class="small mb-0">
                                    {{ __('group_invitation.you_are_admin_text') }}
                                </div>
                            </div>

                            <a href="" class="invite-button-primary w-100">
                                <i class="fa-solid fa-arrow-right me-2"></i>
                                {{ __('group_invitation.go_groups') }}
                            </a>

                        {{-- APROBADO --}}
                        @elseif($estadoMiembro === 'aprobado')

                            <div class="alert alert-success rounded-4">
                                <div class="fw-bold mb-1">
                                    <i class="fa-solid fa-circle-check me-1"></i>
                                    {{ __('group_invitation.already_member') }}
                                </div>

                                <div class="small mb-0">
                                    {{ __('group_invitation.already_member_text') }}
                                </div>
                            </div>

                            <a href="{{ route('groups.panel', $grupo->id) }}"
                               class="invite-button-success w-100">
                                <i class="fa-solid fa-door-open me-2"></i>
                                {{ __('group_invitation.enter_group') }}
                            </a>

                        {{-- PENDIENTE --}}
                        @elseif($estadoMiembro === 'pendiente')

                            <div class="alert alert-info rounded-4">
                                <div class="fw-bold mb-1">
                                    <i class="fa-solid fa-hourglass-half me-1"></i>
                                    {{ __('group_invitation.request_sent') }}
                                </div>

                                <div class="small mb-0">
                                    {{ __('group_invitation.request_sent_text') }}
                                </div>
                            </div>

                            <button class="invite-button-disabled w-100" disabled>
                                <i class="fa-solid fa-clock me-2"></i>
                                {{ __('group_invitation.in_review') }}
                            </button>

                        {{-- NUEVO --}}
                        @else

                            <div class="alert alert-light border rounded-4">
                                <div class="fw-bold mb-1">
                                    {{ __('group_invitation.want_join') }}
                                </div>

                                <div class="small mb-0">
                                    {{ __('group_invitation.want_join_text') }}
                                </div>
                            </div>

                            <button wire:click="solicitar" class="invite-button-dark w-100">
                                <i class="fa-solid fa-paper-plane me-2"></i>
                                {{ __('group_invitation.request_join') }}
                            </button>

                            <div class="text-muted small mt-3">
                                {{ __('group_invitation.join_note') }}
                            </div>

                        @endif

                    @endguest

                    <div class="text-muted small mt-4">
                        {{ __('group_invitation.security_note') }}
                    </div>

                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-12 col-lg-7">

            <div class="invite-card">
                <div class="invite-card-body">

                    <div class="d-flex align-items-start justify-content-between">

                        <div>

                            <div class="invite-badge-info mb-2">
                                <i class="fa-solid fa-trophy me-1"></i>
                                {{ __('group_invitation.group_tournament') }}
                            </div>

                            <h4 class="mb-0 fw-bold">
                                {{ __('group_invitation.tournament_info') }}
                            </h4>

                            <div class="text-muted small">
                                {{ __('group_invitation.tournament_info_text') }}
                            </div>

                        </div>

                    </div>

                    <div class="invite-divider"></div>

                    @if($torneo)

                        <div class="row g-3">

                            <div class="col-12">

                                <div class="invite-stat-card">

                                    <div class="text-muted small">
                                        {{ __('group_invitation.league') }}
                                    </div>

                                    <div class="fw-bold">
                                        {{ $torneo->apiLeague->nombre ?? 'Liga' }}
                                    </div>

                                    <div class="text-muted small mt-1">
                                        {{ $torneo->nombre_torneo ?? 'Torneo del grupo' }}
                                    </div>

                                </div>

                            </div>

                            <div class="col-6">

                                <div class="invite-stat-card h-100">

                                    <div class="text-muted small">
                                        {{ __('group_invitation.entry_fee') }}
                                    </div>

                                    <div class="fw-bold fs-5">
                                        {{ $grupo->requisito_entrada }} 
                                    </div>

                                    <div class="text-muted small">
                                        {{ __('group_invitation.pay_on_join') }}
                                    </div>

                                </div>

                            </div>

                            <div class="col-6">

                                <div class="invite-stat-card h-100">

                                    <div class="text-muted small">
                                        {{ __('group_invitation.prize') }}
                                    </div>

                                    <div class="fw-bold fs-5">
                                        {{ $grupo->premio ?? __('group_invitation.to_define') }}
                                    </div>

                                    <div class="text-muted small">
                                        {{ __('group_invitation.depends_admin') }}
                                    </div>

                                </div>

                            </div>

                            <div class="col-6">

                                <div class="invite-stat-card h-100">

                                    <div class="text-muted small">
                                        {{ __('group_invitation.start') }}
                                    </div>

                                    <div class="fw-bold">
                                        {{ $torneo->fecha_inicio ? \Carbon\Carbon::parse($torneo->fecha_inicio)->format('d/m/Y') : __('group_invitation.to_define') }}
                                    </div>

                                </div>

                            </div>

                            <div class="col-6">

                                <div class="invite-stat-card h-100">

                                    <div class="text-muted small">
                                        {{ __('group_invitation.end') }}
                                    </div>

                                    <div class="fw-bold">
                                        {{ $torneo->fecha_fin ? \Carbon\Carbon::parse($torneo->fecha_fin)->format('d/m/Y') : __('group_invitation.to_define') }}
                                    </div>

                                </div>

                            </div>

                            <div class="col-12">

                                <div class="alert alert-secondary rounded-4 mb-0">

                                    <div class="fw-bold mb-1">
                                        {{ __('group_invitation.important') }}
                                    </div>

                                    <div class="small mb-0">
                                        {{ __('group_invitation.important_text') }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    @else

                        <div class="alert alert-warning rounded-4">

                            <div class="fw-bold mb-1">
                                {{ __('group_invitation.no_tournament_title') }}
                            </div>

                            <div class="small mb-0">
                                {{ __('group_invitation.no_tournament_text') }}
                            </div>

                        </div>

                        <div class="invite-stat-card">

                            <div class="text-muted small mb-2">
                                {{ __('group_invitation.what_happens') }}
                            </div>

                            <ul class="mb-0 small">
                                <li>{{ __('group_invitation.what_happens_1') }}</li>
                                <li>{{ __('group_invitation.what_happens_2') }}</li>
                                <li>{{ __('group_invitation.what_happens_3') }}</li>
                            </ul>

                        </div>

                    @endif

                </div>
            </div>

            <div class="text-muted small mt-3">
                {{ __('group_invitation.footer_note') }}
            </div>

        </div>

    </div>

</div>

<style>
    .invite-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
    }

    .invite-card-body {
        padding: 2rem;
    }

    .invite-group-title {
        font-weight: 800;
        margin-bottom: .25rem;
    }

    .invite-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.5rem 0;
    }

    .invite-stat-card {
        background: #f8f9fa;
        border-radius: 1rem;
        padding: 1rem;
    }

    .invite-badge-dark,
    .invite-badge-info {
        display: inline-block;
        padding: .35rem .8rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
    }

    .invite-badge-dark {
    background: #fff4ef;
    color: #ff6600;
    border: 1px solid #ffd4c2;
}

    .invite-badge-info {
        background: #e7f1ff;
        color: #1e40af;
    }

    .invite-button-dark,
    .invite-button-primary,
    .invite-button-success,
    .invite-button-disabled {
        border: none;
        border-radius: 999px;
        padding: .9rem 1.2rem;
        width: 100%;
        display: inline-block;
        text-align: center;
        text-decoration: none;
        font-weight: 700;
        transition: all .22s ease;
    }

   .invite-button-dark {
    background: #1e40af;
    color: #fff;
    box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
}

    .invite-button-primary {
        background: #1e40af;
        color: #fff;
    }

    .invite-button-success {
        background: #198754;
        color: #fff;
    }

    .invite-button-disabled {
        background: #dee2e6;
        color: #6c757d;
    }

    .invite-button-dark:hover,
    .invite-button-primary:hover,
    .invite-button-success:hover {
        background: #3157d5;
        transform: translateY(-2px);
        color: #fff;
         box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
    }

    @media(max-width: 768px) {
        .invite-card-body {
            padding: 1.4rem;
        }
    }
</style>