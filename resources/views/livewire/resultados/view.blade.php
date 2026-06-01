@section('title', __('results.title'))

<div class="container py-5">

    @if ($torneosInscritos->isEmpty())

        <div class="results-empty-card">

            <div class="results-empty-icon">
                <i class="fa-solid fa-trophy"></i>
            </div>

            <h4 class="results-empty-title">
                {{ __('results.no_tournaments_title') }}
            </h4>

            <p class="results-empty-text">
                {{ __('results.no_tournaments_text') }}
            </p>

        </div>
    @else
        {{-- HEADER --}}
        <div class="text-center mb-5">

            <h1 class="results-title mt-3">

                <i class="fa-solid fa-chart-simple" style="color: #ff6600 !important"></i>

                {{ __('results.heading') }}

            </h1>

            <p class="results-subtitle">
                {{ __('results.subtitle') }}
            </p>

            @if ($torneo)
                <div class="results-tournament-badge mx-auto mt-3">
                    <i class="fa-solid fa-trophy me-1"></i>
                    {{ $torneo->nombre_torneo }}
                </div>
            @endif

        </div>

        {{-- FILTROS --}}
        <div class="results-card mb-4">

            <div class="results-card-body">

                <div class="row g-3">

                    {{-- TORNEOS --}}
                    <div class="col-md-4">

                        <label class="results-label">
                            {{ __('results.my_tournaments') }}
                        </label>

                        <select class="form-select results-input" wire:model="torneoSeleccionadoId">

                            @foreach ($torneosInscritos as $t)
                                <option value="{{ $t['id'] }}">
                                    {{ $t['nombre_torneo'] }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- BUSQUEDA --}}
                    <div class="col-md-4">

                        <label class="results-label">
                            {{ __('results.search_team') }}
                        </label>

                        <input type="text" class="form-control results-input"
                            wire:model.debounce.300ms="buscarEquipo"
                            placeholder="{{ __('results.search_placeholder') }}">

                    </div>

                    {{-- ESTADO --}}
                    <div class="col-md-3">

                        <label class="results-label">
                            {{ __('results.status') }}
                        </label>

                        <select class="form-select results-input" wire:model="estadoFiltro">

                            <option value="">
                                {{ __('results.all') }}
                            </option>

                            <option value="FT">
                                {{ __('results.finished') }}
                            </option>

                            <option value="LIVE">
                                {{ __('results.live') }}
                            </option>

                            <option value="PENDIENTE">
                                {{ __('results.pending') }}
                            </option>

                        </select>

                    </div>

                    {{-- LIMPIAR --}}
                    <div class="col-md-1 d-grid">

                        <button class="results-clear-button" wire:click="limpiarFiltros">

                            <i class="fa-solid fa-xmark"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>

        @php
            $porFecha = $partidosFiltrados->groupBy(fn($p) => \Carbon\Carbon::parse($p->fecha_hora)->format('d M Y'));
        @endphp

        {{-- RESULTADOS --}}
        <div class="results-card">

            <div class="results-card-body">

                @forelse($porFecha as $fecha => $partidosDia)
                    <div class="mb-5">

                        {{-- FECHA --}}
                        <div class="mb-3">

                            <div class="results-date-badge">

                                <i class="fa-solid fa-calendar-days me-1"></i>

                                {{ $fecha }}

                            </div>

                        </div>

                        {{-- PARTIDOS --}}
                        @foreach ($partidosDia as $p)
                            <div class="match-card">

                                {{-- TOP --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <small class="text-muted">

                                        <i class="fa-regular fa-clock me-1"></i>

                                        {{ \Carbon\Carbon::parse($p->fecha_hora)->format('H:i') }}

                                    </small>

                                    <span
                                        class="results-status-badge
                                        @if ($p->estado === 'FT') finished
                                        @elseif(in_array($p->estado, ['1H', '2H', 'HT', 'LIVE'])) live
                                        @else pending @endif
                                    ">

                                        {{ $p->estado }}

                                    </span>

                                </div>

                                {{-- MATCH --}}
                                <div class="row align-items-center text-center">

                                    {{-- LOCAL --}}
                                    <div class="col-5">

                                        <div class="team-side justify-content-start">

                                            @if ($p->equipoLocal && $p->equipoLocal->logo)
                                                <img src="{{ $p->equipoLocal->logo }}" class="team-logo">
                                            @else
                                                <div class="team-placeholder">
                                                    <i class="fa-solid fa-shield-halved"></i>
                                                </div>
                                            @endif

                                            <span class="team-name">
                                                {{ $p->equipoLocal->name ?? __('results.home') }}
                                            </span>

                                        </div>

                                    </div>

                                    {{-- SCORE --}}
                                    <div class="col-2">

                                        <div class="results-score-box">

                                            <span>
                                                {{ optional($p->resultado)->golesLocal ?? '-' }}
                                            </span>

                                            <small>:</small>

                                            <span>
                                                {{ optional($p->resultado)->golesVisitante ?? '-' }}
                                            </span>

                                        </div>

                                    </div>

                                    {{-- VISITANTE --}}
                                    <div class="col-5">

                                        <div class="team-side justify-content-end">

                                            <span class="team-name">
                                                {{ $p->equipoVisitante->name ?? __('results.away') }}
                                            </span>

                                            @if ($p->equipoVisitante && $p->equipoVisitante->logo)
                                                <img src="{{ $p->equipoVisitante->logo }}" class="team-logo">
                                            @else
                                                <div class="team-placeholder">
                                                    <i class="fa-solid fa-shield-halved"></i>
                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                @empty

                    <div class="results-empty-state">

                        <i class="fa-solid fa-magnifying-glass mb-3"></i>

                        <h4>
                            {{ __('results.no_results') }}
                        </h4>

                        <p>
                            {{ __('results.try_filters') }}
                        </p>

                    </div>
                @endforelse

            </div>

        </div>

    @endif

</div>

<style>
    .results-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 .5rem 1.2rem rgba(0, 0, 0, .06);
    }

    .results-card-body {
        padding: 2rem;
    }

    .results-title {
        font-size: 2.4rem;
        font-weight: 800;
    }

    .results-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .results-tournament-badge {
        width: fit-content;
        background: #fff4ef;
        color: #ff6600;
        border: 1px solid #ffd4c2;
        padding: .45rem .9rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .85rem;
    }

    .results-label {
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .results-input {
        border-radius: 999px;
        padding: .85rem 1.1rem;
        border: 1px solid #dee2e6;
    }

    .results-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30, 64, 175, .12);
    }

    .results-clear-button {
        border: none;
        border-radius: 999px;
        background: #f1f3f5;
        color: #6c757d;
        font-weight: 700;
        transition: .2s ease;
    }

    .results-clear-button:hover {
        background: #dee2e6;
    }

    .results-date-badge {
        width: fit-content;
        background: #1e40af;
        color: #fff;
        border-radius: 999px;
        padding: .45rem .9rem;
        font-weight: 700;
        font-size: .85rem;
    }

    .match-card {
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: .9rem;
        transition: all .22s ease;
        background: #fff;
    }

    .match-card:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .06);
    }

    .results-status-badge {
        padding: .35rem .7rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
        color: #fff;
    }

    .results-status-badge.finished {
        background: #198754;
    }

    .results-status-badge.live {
        background: #dc3545;
    }

    .results-status-badge.pending {
        background: #6c757d;
    }

    .team-side {
        display: flex;
        align-items: center;
        gap: .65rem;
    }

    .team-name {
        font-weight: 700;
        color: #212529;
    }

    .team-logo,
    .team-placeholder {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        flex-shrink: 0;
        border: 1px solid #dee2e6;
        box-shadow: 0 .25rem .6rem rgba(0, 0, 0, .06);
    }

    .team-logo {
        object-fit: contain;
        background: #fff;
    }

    .team-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff4ef;
        color: #ff6600;
    }

    .results-score-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .6rem;
        background: #fff4ef;
        color: #ff4500;
        border-radius: 999px;
        padding: .45rem .9rem;
        min-width: 88px;
        font-weight: 800;
        font-size: 1.1rem;
    }

    .results-score-box small {
        color: #6c757d;
        font-weight: 800;
    }

    .results-empty-card,
    .results-empty-state {
        background: #fff;
        border: 1px dashed #dee2e6;
        border-radius: 1rem;
        padding: 3rem 1.5rem;
        text-align: center;
        color: #6c757d;
    }

    .results-empty-icon,
    .results-empty-state i {
        font-size: 3rem;
        color: #ff6600;
    }

    .results-empty-title,
    .results-empty-state h4 {
        font-weight: 800;
        color: #212529;
    }

    @media(max-width: 768px) {

        .results-card-body {
            padding: 1.2rem;
        }

        .results-title {
            font-size: 1.8rem;
        }

        .team-side {
            flex-direction: column;
            gap: .35rem;
        }

        .team-name {
            font-size: .78rem;
        }

        .results-score-box {
            min-width: 72px;
            font-size: .95rem;
        }

    }
</style>
