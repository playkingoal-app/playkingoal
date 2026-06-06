@section('title', __('group_panel.title', ['name' => $grupo->nombre]))

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">
        <h1 class="group-panel-title mt-3">
            <i class="fa-solid fa-people-group" style="color: #ff6600 !important"></i>
            {{ __('group_panel.heading', ['name' => $grupo->nombre]) }}
        </h1>

        <p class="group-panel-subtitle">
            {{ __('group_panel.subtitle') }}
        </p>
    </div>

    {{-- ALERTAS --}}
    @if (session()->has('success'))
        <div class="alert alert-success rounded-4 shadow-sm text-center mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger rounded-4 shadow-sm text-center mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- TABS --}}
    <div class="group-tabs mb-4">
        <button class="group-tab-button {{ $tab === 'torneo' ? 'active' : '' }}" wire:click="cambiarTab('torneo')">
            <i class="fa-solid fa-trophy me-2"></i>
            {{ __('group_panel.tabs.tournament') }}
        </button>

        <button class="group-tab-button {{ $tab === 'usuarios' ? 'active' : '' }}" wire:click="cambiarTab('usuarios')">
            <i class="fa-solid fa-users me-2"></i>
            {{ __('group_panel.tabs.users') }}
        </button>
    </div>

    {{-- TAB TORNEO --}}
    @if ($tab === 'torneo')

        @if (!$torneo)
            <div class="panel-card">
                <div class="panel-card-body">

                    <div class="panel-header">
                        <div>
                            <h4>{{ __('group_panel.assign_tournament_title') }}</h4>
                            <p>{{ __('group_panel.assign_tournament_text') }}</p>
                        </div>

                        <span class="panel-badge-secondary">
                            <i class="fa-regular fa-circle-xmark me-1"></i>
                            {{ __('group_panel.no_tournament') }}
                        </span>
                    </div>

                    <div class="panel-divider"></div>

                    @if ($this->esAdmin())

                        <div class="mb-4">
                            <label class="panel-label">
                                {{ __('group_panel.search_tournament') }}
                            </label>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control panel-input" wire:model.live="buscarLiga"
                                        placeholder="{{ __('group_panel.search_placeholder') }}">
                                </div>

                                <div class="col-md-6">
                                    <select class="form-select panel-input" wire:model.live="paisLiga">
                                        <option value="">
                                            {{ __('group_panel.all_countries') }}
                                        </option>

                                        @foreach ($ligas->pluck('country')->filter()->unique()->sort() as $pais)
                                            <option value="{{ $pais }}">{{ $pais }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @error('api_league_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @php
                            $ligasFiltradas = $ligas
                                ->when($buscarLiga, function ($items) use ($buscarLiga) {
                                    return $items->filter(
                                        fn($liga) => str_contains(strtolower($liga->name), strtolower($buscarLiga)),
                                    );
                                })
                                ->when($paisLiga, function ($items) use ($paisLiga) {
                                    return $items->filter(fn($liga) => $liga->country === $paisLiga);
                                })
                                ->take(30);

                            $ligaSeleccionada = $api_league_id ? $ligas->firstWhere('id', (int) $api_league_id) : null;
                        @endphp

                        @if ($ligaSeleccionada)
                            <div class="selected-league-card mb-4">
                                @if ($ligaSeleccionada->logo)
                                    <img src="{{ $ligaSeleccionada->logo }}" alt="{{ $ligaSeleccionada->name }}">
                                @else
                                    <div class="league-placeholder">
                                        <i class="fa-solid fa-trophy"></i>
                                    </div>
                                @endif

                                <div>
                                    <strong>{{ __('group_panel.selected_tournament') }}</strong>
                                    <div>{{ $ligaSeleccionada->name }}</div>
                                    <small>{{ $ligaSeleccionada->country ?? __('group_panel.no_country') }}</small>
                                </div>
                            </div>
                        @endif

                        <div class="row g-3 mb-4">
                            @forelse($ligasFiltradas as $liga)
                                <div class="col-md-6 col-lg-4">
                                    <div class="league-card {{ (int) $api_league_id === (int) $liga->id ? 'selected' : '' }}"
                                        wire:click="$set('api_league_id', {{ $liga->id }})">
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($liga->logo)
                                                <img src="{{ $liga->logo }}" alt="{{ $liga->name }}">
                                            @else
                                                <div class="league-placeholder small">
                                                    <i class="fa-solid fa-trophy"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="fw-semibold">{{ $liga->name }}</div>
                                                <small class="text-muted">
                                                    {{ $liga->country ?? __('group_panel.no_country') }}
                                                </small>
                                            </div>
                                        </div>

                                        @if ((int) $api_league_id === (int) $liga->id)
                                            <span class="selected-badge">
                                                <i class="fa-solid fa-circle-check me-1"></i>
                                                {{ __('group_panel.selected') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning rounded-4 mb-0">
                                        {{ __('group_panel.no_leagues_found') }}
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="mb-4">
                            <label class="panel-label">
                                {{ __('group_panel.participation_conditions') }}
                            </label>

                            <input type="text" class="form-control panel-input" wire:model.defer="requisito_entrada"
                                placeholder="{{ __('group_panel.participation_conditions_placeholder') }}">

                            @error('precio')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                     <div class="mb-4">
    <div class="prize-section">

        <div class="prize-section-header">
            <div>
                <label class="panel-label mb-1">
                    {{ __('group_panel.prizes_by_position') }}
                </label>

                <p class="prize-help">
                    {{ __('group_panel.prizes_help') }}
                </p>
            </div>
        </div>

        @foreach ($premios as $index => $item)
            <div class="prize-config-card">

                <div class="prize-config-badge">
                    <i class="fa-solid fa-award"></i>
                    <span>#{{ $item['posicion'] ?? $index + 1 }}</span>
                </div>

                <div class="prize-config-fields">
                    <div>
                        <label class="prize-small-label">
                            {{ __('group_panel.position') }}
                        </label>

                        <input
                            type="number"
                            min="1"
                            max="1000"
                            class="form-control panel-input"
                            wire:model.defer="premios.{{ $index }}.posicion"
                            placeholder="{{ __('group_panel.position_placeholder') }}"
                        >
                    </div>

                    <div>
                        <label class="prize-small-label">
                            {{ __('group_panel.prize') }}
                        </label>

                        <input
                            type="text"
                            class="form-control panel-input"
                            wire:model.defer="premios.{{ $index }}.premio"
                            placeholder="{{ __('group_panel.prize_example') }}"
                        >
                    </div>
                </div>

            </div>
        @endforeach

        <button type="button" class="prize-add-button" wire:click="agregarPremio">
            <i class="fa-solid fa-plus me-1"></i>
            {{ __('group_panel.add_prize') }}
        </button>

    </div>
</div>
                        <button class="panel-button" wire:click="asignarTorneo">
                            <i class="fa-solid fa-check me-2"></i>
                            {{ __('group_panel.assign_button') }}
                        </button>
                    @else
                        <div class="alert alert-info rounded-4 mb-0">
                            {{ __('group_panel.waiting_admin_tournament') }}
                        </div>
                    @endif

                </div>
            </div>
        @else
            <div class="panel-card">
                <div class="panel-card-body">

                    <div class="panel-header">
                        <h4>
                            <i class="fa-solid fa-trophy me-2" style="color:#ff6600"></i>
                            {{ __('group_panel.active_tournament') }}
                        </h4>

                        <span class="panel-badge-success">
                            <i class="fa-solid fa-circle-check me-1"></i>
                            {{ __('group_panel.active') }}
                        </span>
                    </div>

                    <div class="panel-divider"></div>

<div class="row g-4">

    {{-- TORNEO --}}
    <div class="col-md-4">
        <small class="text-muted d-block mb-2">
            {{ __('group_panel.tournament') }}
        </small>

        <div class="d-flex align-items-center gap-3">
            @if($torneo->apiLeague->logo ?? false)
                <img src="{{ $torneo->apiLeague->logo }}" alt="{{ $torneo->apiLeague->name }}" width="52" height="52" style="object-fit: contain;">
            @else
                <div class="league-placeholder">
                    <i class="fa-solid fa-trophy"></i>
                </div>
            @endif

            <div>
                <span class="fw-semibold d-block">
                    {{ $torneo->apiLeague->name ?? '—' }}
                </span>

                <small class="text-muted">
                    {{ __('group_panel.country') }}:
                    {{ $torneo->apiLeague->country ?? __('group_panel.no_country') }}
                </small>
            </div>
        </div>
    </div>

    {{-- CONDICIONES --}}
    <div class="col-md-4">
        <div class="premium-condition-card">
            <div class="premium-card-title">
                <i class="fa-solid fa-circle-info"></i>
                {{ __('group_panel.participation_conditions') }}
            </div>

            <div class="premium-card-text">
                {{ $grupo->requisito_entrada ?: __('group_panel.to_define') }}
            </div>
        </div>
    </div>

    {{-- PREMIOS --}}
    <div class="col-md-4">
        <div class="podium-prizes-card">
            <div class="premium-card-title">
                <i class="fa-solid fa-crown"></i>
                {{ __('group_panel.prize') }}
            </div>

            @if ($grupo->premios->count())
                <div class="podium-prizes-list">
                    @foreach ($grupo->premios as $premio)
                        <div class="podium-prize-card">
                            <div class="podium-rank">
                                #{{ $premio->posicion }}
                            </div>

                            <div class="podium-reward">
                                {{ $premio->premio }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="premium-card-text">
                    {{ __('group_panel.to_define') }}
                </div>
            @endif
        </div>
    </div>

</div>
                    @if (!$this->esAdmin())
                        <div class="panel-divider"></div>

                        @if ($yaInscrito)
                            <div class="alert alert-success rounded-4 mb-0">
                                <i class="fa-solid fa-circle-check me-2"></i>
                                {{ __('group_panel.already_joined') }}
                                <br>
                                {{ __('group_panel.go_predictions') }}
                            </div>
                        @else
                            <button class="panel-button" wire:click="participar">
                                <i class="fa-solid fa-right-to-bracket me-2"></i>
                                {{ __('group_panel.join_tournament') }}
                            </button>

                            <small class="text-muted d-block mt-2">
                                {{ __('group_panel.free_registration_note') }}
                            </small>
                        @endif
                    @endif

                </div>
            </div>
        @endif

    @endif

    {{-- TAB USUARIOS --}}
    @if ($tab === 'usuarios')
        <div class="panel-card">
            <div class="panel-card-body">

                <div class="panel-header">
                    <h4>
                        <i class="fa-solid fa-users me-2" style="color:#ff6600"></i>
                        {{ __('group_panel.group_users') }}
                    </h4>

                    @if ($this->esAdmin())
                        <span class="panel-badge-success">
                            <i class="fa-solid fa-crown me-1"></i>
                            {{ __('group_panel.admin') }}
                        </span>
                    @endif
                </div>

                <div class="panel-divider"></div>

                <div class="mb-4">
                    <label class="panel-label">
                        {{ __('group_panel.invitation_link') }}
                    </label>

                    <div class="input-group invite-wrapper">
                        <input type="text" class="form-control panel-input" value="{{ $linkInvitacion }}"
                            readonly>

                        <button class="panel-copy-button "
                            onclick="navigator.clipboard.writeText('{{ $linkInvitacion }}')">
                            <i class="fa-regular fa-copy me-1"></i>
                            {{ __('group_panel.copy') }}
                        </button>
                    </div>

                    <small class="text-muted d-block mt-2">
                        {{ __('group_panel.pending_note') }}
                    </small>
                </div>

                <div class="panel-divider"></div>

                <h6 class="panel-section-title">
                    {{ __('group_panel.pending_requests') }}
                </h6>

                @forelse($usuariosPendientes as $u)
                    <div class="user-row">
                        <div>
                            <div class="fw-semibold">{{ $u->name }}</div>
                            <small class="text-muted">{{ $u->email }}</small>
                        </div>

                        @if ($this->esAdmin())
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm rounded-pill"
                                    wire:click="aprobarUsuario({{ $u->id }})">
                                    {{ __('group_panel.approve') }}
                                </button>

                                <button class="btn btn-outline-danger btn-sm rounded-pill"
                                    wire:click="rechazarUsuario({{ $u->id }})">
                                    {{ __('group_panel.reject') }}
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-muted">
                        {{ __('group_panel.no_pending_requests') }}
                    </p>
                @endforelse

                <div class="panel-divider"></div>

                <h6 class="panel-section-title">
                    {{ __('group_panel.approved_members') }}
                </h6>

                @forelse($usuariosAprobados as $u)
                    <div class="user-row">
                        <div>
                            <div class="fw-semibold">{{ $u->name }}</div>
                            <small class="text-muted">{{ $u->email }}</small>
                        </div>

                        <div class="d-flex gap-2 align-items-center">
                            <span class="panel-badge-success">
                                {{ __('group_panel.approved') }}
                            </span>

                            <span class="badge bg-light text-dark rounded-pill">
                                {{ $u->pivot->rol }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">
                        {{ __('group_panel.no_approved_members') }}
                    </p>
                @endforelse

            </div>
        </div>
    @endif

</div>
<style>
.prize-section {
    border: 1px solid #dee2e6;
    border-radius: 1.2rem;
    padding: 1.2rem;
    background: linear-gradient(135deg, #ffffff 0%, #fff7f2 100%);
}

.prize-section-header {
    margin-bottom: 1rem;
}

.prize-help {
    color: #6c757d;
    font-size: .9rem;
    margin: 0;
}

.prize-config-card {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
    background: #fff;
    border: 1px solid rgba(255, 69, 0, .14);
    border-radius: 1rem;
    padding: 1rem;
    margin-bottom: .85rem;
    box-shadow: 0 6px 16px rgba(0,0,0,.04);
}

.prize-config-badge {
    min-width: 56px;
    height: 56px;
    border-radius: 1rem;
    background: #fff4ef;
    color: #ff4500;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    flex-shrink: 0;
}

.prize-config-fields {
    width: 100%;
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: .85rem;
}

.prize-small-label {
    display: block;
    font-size: .75rem;
    font-weight: 900;
    color: #6c757d;
    margin-bottom: .35rem;
    text-transform: uppercase;
}

.prize-add-button {
    width: 100%;
    border: 1px dashed #ff4500;
    background: #fff;
    color: #ff4500;
    border-radius: 999px;
    padding: .85rem 1rem;
    font-weight: 900;
    transition: all .22s ease;
}

.prize-add-button:hover {
    background: #ff4500;
    color: #fff;
}

@media(max-width: 768px) {
    .prize-config-card {
        flex-direction: column;
    }

    .prize-config-fields {
        grid-template-columns: 1fr;
    }

    .prize-config-badge {
        width: 100%;
        height: auto;
        padding: .6rem;
        flex-direction: row;
        gap: .4rem;
        border-radius: 999px;
    }
    @media(max-width:768px){

    .input-group {
        flex-wrap: nowrap !important;
    }

    .panel-copy-button {
        width: auto !important;
        flex: 0 0 auto !important;
        padding: 0 .9rem !important;
        font-size: .78rem !important;
    }
}
}
@media(max-width:768px){

    .invite-wrapper{
        display: flex !important;
        align-items: stretch !important;
    }

    .invite-wrapper .panel-input{
        border-right: 0 !important;
    }

    .invite-wrapper .panel-copy-button{
        display: flex !important;
        align-items: center !important;
        margin: 0 !important;
    }
}
</style>
<style>
 .premium-condition-card,
.podium-prizes-card {
    height: 100%;
    border-radius: 1.2rem;
    padding: 1.2rem;
    background: linear-gradient(135deg, #ffffff 0%, #fff7f2 100%);
    border: 1px solid rgba(255, 69, 0, .15);
    box-shadow: 0 10px 28px rgba(0,0,0,.06);
}

.premium-card-title {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .78rem;
    font-weight: 900;
    text-transform: uppercase;
    color: #6c757d;
    margin-bottom: .9rem;
}

.premium-card-title i {
    color: #ff4500;
}

.premium-card-text {
    font-weight: 800;
    color: #212529;
    line-height: 1.45;
}

.podium-prizes-list {
    display: flex;
    flex-direction: column;
    gap: .75rem;
}

.podium-prize-card {
    border-radius: 1rem;
    padding: .85rem;
    background: #fff;
    border: 1px solid rgba(255, 69, 0, .12);
    box-shadow: 0 6px 16px rgba(0,0,0,.04);
}

.podium-rank {
    display: inline-block;
    border-radius: 999px;
    background: #ff4500;
    color: #fff;
    font-size: .72rem;
    font-weight: 900;
    padding: .28rem .65rem;
    margin-bottom: .45rem;
}

.podium-reward {
    font-weight: 900;
    color: #212529;
    line-height: 1.35;
    word-break: break-word;
}

@media(max-width:768px) {
    .premium-condition-card,
    .podium-prizes-card {
        padding: 1rem;
    }
}
</style>
<style>
    .group-panel-title {
        font-size: 2.4rem;
        font-weight: 800;
    }

    .group-panel-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .group-tabs {
        display: flex;
        gap: .75rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .group-tab-button {
        border: 1px solid #1e40af;
        background: #fff;
        color: #1e40af;
        border-radius: 999px;
        padding: .75rem 1.3rem;
        font-weight: 700;
        transition: all .22s ease;
    }

    .group-tab-button:hover,
    .group-tab-button.active {
        background: #1e40af;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
    }

    .panel-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 .5rem 1.2rem rgba(0, 0, 0, .06);
    }

    .panel-card-body {
        padding: 2rem;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .panel-header h4 {
        font-weight: 800;
        margin-bottom: .25rem;
    }

    .panel-header p {
        color: #6c757d;
        margin-bottom: 0;
    }

    .panel-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .panel-label {
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .panel-input {
        border-radius: 999px;
        padding: .85rem 1.1rem;
        border: 1px solid #dee2e6;
    }

    .panel-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30, 64, 175, .12);
    }

    .panel-button,
    .panel-copy-button {
        border: none;
        border-radius: 999px;
        padding: .85rem 1.25rem;
        background: #1e40af;
        color: #fff;
        font-weight: 700;
        transition: all .22s ease;
        box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
    }

    .panel-button:hover,
    .panel-copy-button:hover {
        background: #3157d5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
    }

    .panel-badge-success,
    .panel-badge-secondary {
        display: inline-block;
        padding: .35rem .75rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
    }

    .panel-badge-success {
        background: #198754;
        color: #fff;
    }

    .panel-badge-secondary {
        background: #6c757d;
        color: #fff;
    }

    .selected-league-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        border-radius: 1rem;
        padding: 1rem;
        background: #fff4ef;
        border-left: 4px solid #ff4500;
    }

    .selected-league-card img,
    .league-card img {
        width: 48px;
        height: 48px;
        object-fit: contain;
    }

    .league-card {
        height: 100%;
        cursor: pointer;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1rem;
        transition: all .2s ease;
        position: relative;
    }

    .league-card:hover {
        background: #f8f9fa;
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1.2rem rgba(0, 0, 0, .06);
    }

    .league-card.selected {
        border: 2px solid #ff4500;
        background: #fff4ef;
    }

    .selected-badge {
        display: inline-block;
        margin-top: 1rem;
        background: #ff4500;
        color: #fff;
        padding: .35rem .75rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
    }

    .league-placeholder {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #fff4ef;
        color: #ff4500;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .league-placeholder.small {
        width: 48px;
        height: 48px;
    }

    .panel-section-title {
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .user-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: .75rem;
    }

    @media(max-width: 768px) {
        .panel-card-body {
            padding: 1.4rem;
        }

        .user-row {
            align-items: flex-start;
            flex-direction: column;
        }

        .panel-copy-button {
            width: 100%;
            margin-top: .5rem;
        }
    }
</style>
