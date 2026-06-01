@section('title', __('pronostics.title'))

<div class="container py-5">

    <div class="pronostics-card">

        {{-- HEADER CENTRADO --}}
        <div class="text-center mb-5 pt-4 px-4">

            <h1 class="pronostics-title mt-3">
                <i class="fa-solid fa-circle-nodes" style="color: #ff6600 !important"></i>

                {{ __('pronostics.my_pronostics') }}
            </h1>

            <p class="pronostics-subtitle">
                {{ __('pronostics.subtitle') }}
            </p>

            @if (session()->has('message'))
                <div wire:poll.4s class="pronostics-success-message mx-auto mt-3">
                    <i class="fa-solid fa-circle-check me-1"></i>
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div wire:poll.4s class="pronostics-error-message mx-auto mt-3">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                    {{ session('error') }}
                </div>
            @endif

        </div>

        <div class="pronostics-divider"></div>

        <div class="pronostics-body">

            @include('livewire.pronosticos.modals')

            {{-- FILTRO --}}
            <div class="pronostics-filter-card mb-4">

                <label for="torneoSeleccionado" class="pronostics-label">
                    {{ __('pronostics.select_tournament') }}
                </label>

                <select wire:model="torneoSeleccionado" id="torneoSeleccionado" class="form-select pronostics-input">
                    <option value="">
                        {{ __('pronostics.select_option') }}
                    </option>

                    @foreach ($torneos as $torneo)
                        <option value="{{ $torneo->id }}">
                            {{ $torneo->nombre_torneo }}
                        </option>
                    @endforeach
                </select>

                <small class="text-muted d-block mt-2">
                    <i class="fa-solid fa-circle-info me-1"></i>
                    {{ __('pronostics.select_tournament_help') }}
                </small>

            </div>

            {{-- SI HAY TORNEO --}}
            @if ($torneoSeleccionado)

                <div wire:poll.10s class="accordion pronostics-accordion mb-3" id="accordionJornadas">

                    @forelse ($jornadas as $row)
                        <div class="accordion-item pronostics-round-card">

                            <h2 class="accordion-header" id="heading-{{ $row->id }}">

                                <button
                                    class="accordion-button pronostics-round-button {{ $jornada == $row->id ? '' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $row->id }}"
                                    aria-expanded="{{ $jornada == $row->id ? 'true' : 'false' }}"
                                    wire:click="toggleJornada({{ $row->id }})">
                                    <i class="fa-solid fa-calendar-days me-2"></i>
                                    {{ $row->descripcion }}
                                </button>

                            </h2>

                            <div id="collapse-{{ $row->id }}"
                                class="accordion-collapse collapse {{ $jornada == $row->id ? 'show' : '' }}"
                                data-bs-parent="#accordionJornadas">

                                <div class="accordion-body pronostics-round-body">

                                    <div class="table-responsive">

                                        <table class="table align-middle text-center pronostics-table">

                                            <thead>
                                                <tr>
                                                    <th>{{ __('pronostics.home') }}</th>
                                                    <th>{{ __('pronostics.score') }}</th>
                                                    <th>{{ __('pronostics.away') }}</th>
                                                    <th>{{ __('pronostics.action') }}</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @forelse($pronosticosJornada as $rowP)
                                                    @php
                                                        $bloqueado =
                                                            now()->timestamp >=
                                                                \Carbon\Carbon::parse($rowP->fecha_hora)->timestamp ||
                                                            $rowP->estado !== 'NS';
                                                    @endphp

                                                    <tr>

                                                        {{-- LOCAL --}}
                                                        <td>
                                                            <div class="team-box justify-content-end">

                                                                <span class="team-name">
                                                                    {{ $rowP->local_nombre ?? __('pronostics.home') }}
                                                                </span>

                                                                @if ($rowP->local_logo)
                                                                    <img src="{{ $rowP->local_logo }}"
                                                                        alt="{{ __('pronostics.home_shield') }}"
                                                                        class="team-logo">
                                                                @else
                                                                    <div class="team-logo-placeholder">
                                                                        <i class="fa-solid fa-shield-halved"></i>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                        </td>

                                                        {{-- SCORE --}}
                                                        <td>
                                                            <div class="score-box">
                                                                <span>{{ $rowP->golesLocal ?? '-' }}</span>
                                                                <small>-</small>
                                                                <span>{{ $rowP->golesVisitante ?? '-' }}</span>
                                                            </div>

                                                            @if ($bloqueado)
                                                                <div class="mt-2">
                                                                    <span class="pronostics-small-locked">
                                                                        <i class="fa-solid fa-lock me-1"></i>
                                                                        {{ __('pronostics.locked') }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </td>

                                                        {{-- VISITANTE --}}
                                                        <td>
                                                            <div class="team-box">

                                                                @if ($rowP->visitante_logo)
                                                                    <img src="{{ $rowP->visitante_logo }}"
                                                                        alt="{{ __('pronostics.away_shield') }}"
                                                                        class="team-logo">
                                                                @else
                                                                    <div class="team-logo-placeholder">
                                                                        <i class="fa-solid fa-shield-halved"></i>
                                                                    </div>
                                                                @endif

                                                                <span class="team-name">
                                                                    {{ $rowP->visitante_nombre ?? __('pronostics.away') }}
                                                                </span>

                                                            </div>
                                                        </td>

                                                        {{-- ACCION --}}
                                                        <td>

                                                            @if (!$bloqueado)
                                                                <button type="button" class="pronostics-button"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#updateDataModal"
                                                                    wire:click="edit({{ $rowP->id }})">
                                                                    <i class="fa-solid fa-pen-to-square me-1"></i>
                                                                    {{ __('pronostics.forecast') }}
                                                                </button>
                                                            @else
                                                                <span class="pronostics-badge-muted">
                                                                    <i class="fa-solid fa-lock me-1"></i>
                                                                    {{ __('pronostics.locked') }}
                                                                </span>
                                                            @endif

                                                        </td>

                                                    </tr>

                                                @empty

                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-4">

                                                            @if (!$jornada)
                                                                <strong>
                                                                    {{ __('pronostics.select_round') }}
                                                                </strong>
                                                            @else
                                                                {{ __('pronostics.no_forecasts') }}
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforelse

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="alert alert-warning text-center rounded-4">
                            {{ __('pronostics.no_rounds') }}
                        </div>
                    @endforelse

                </div>
            @else
                <div class="pronostics-empty-state">

                    <i class="fa-solid fa-trophy mb-3"></i>

                    <h4>
                        {{ __('pronostics.select_tournament_title') }}
                    </h4>

                    <p>
                        {{ __('pronostics.select_tournament_info') }}
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

<style>
    .pronostics-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 .5rem 1.2rem rgba(0, 0, 0, .06);
    }

    .pronostics-title {
        font-size: 2.4rem;
        font-weight: 800;
    }

    .pronostics-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .pronostics-success-message {
        background: #198754;
        color: #fff;
        border-radius: 999px;
        padding: .55rem 1rem;
        font-weight: 700;
        font-size: .85rem;
        width: fit-content;
    }

    .pronostics-error-message {
        background: #dc3545;
        color: #fff;
        border-radius: 999px;
        padding: .55rem 1rem;
        font-weight: 700;
        font-size: .85rem;
        width: fit-content;
    }

    .pronostics-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .pronostics-body {
        padding: 0 2rem 2rem;
    }

    .pronostics-filter-card {
        background: #f8f9fa;
        border-radius: 1rem;
        padding: 1rem;
    }

    .pronostics-label {
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .pronostics-input {
        border-radius: 999px;
        padding: .85rem 1.1rem;
        border: 1px solid #dee2e6;
    }

    .pronostics-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30, 64, 175, .12);
    }

    .pronostics-round-card {
        border: 1px solid #dee2e6 !important;
        border-radius: 1rem !important;
        overflow: hidden;
        margin-bottom: .9rem;
        box-shadow: 0 .35rem .9rem rgba(0, 0, 0, .04);
    }

    .pronostics-round-button {
        background: #fff;
        color: #212529;
        font-weight: 800;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .pronostics-round-button:not(.collapsed) {
        background: #1e40af !important;
        color: #fff !important;
    }

    .pronostics-round-button:focus {
        box-shadow: none !important;
    }

    .pronostics-round-body {
        background: #fff;
    }

    .pronostics-table thead th {
        color: #6c757d;
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: 1px solid #dee2e6;
    }

    .pronostics-table tbody tr:hover {
        background: #f8f9fa;
    }

    .team-box {
        display: flex;
        align-items: center;
        gap: .6rem;
    }

    .team-name {
        font-weight: 700;
        color: #212529;
    }

    .team-logo,
    .team-logo-placeholder {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1px solid #dee2e6;
        box-shadow: 0 .25rem .6rem rgba(0, 0, 0, .06);
    }

    .team-logo {
        object-fit: cover;
        background: #fff;
    }

    .team-logo-placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff4ef;
        color: #ff6600;
    }

    .score-box {
        display: inline-flex;
        align-items: center;
        gap: .65rem;
        background: #fff4ef;
        color: #ff4500;
        border-radius: 999px;
        padding: .45rem .9rem;
        font-weight: 800;
        min-width: 88px;
        justify-content: center;
    }

    .score-box small {
        color: #6c757d;
        font-weight: 800;
    }

    .pronostics-button {
        border: none;
        border-radius: 999px;
        padding: .55rem .9rem;
        background: #1e40af;
        color: #fff;
        font-weight: 700;
        transition: all .22s ease;
        box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
    }

    .pronostics-button:hover {
        background: #3157d5;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
    }

    .pronostics-badge-muted {
        display: inline-block;
        border-radius: 999px;
        background: #f1f3f5;
        color: #6c757d;
        padding: .45rem .8rem;
        font-size: .78rem;
        font-weight: 700;
    }

    .pronostics-small-locked {
        display: inline-block;
        border-radius: 999px;
        background: #f1f3f5;
        color: #6c757d;
        padding: .25rem .55rem;
        font-size: .68rem;
        font-weight: 800;
    }

    .pronostics-empty-state {
        text-align: center;
        border: 1px dashed #dee2e6;
        border-radius: 1rem;
        padding: 3rem 1.5rem;
        color: #6c757d;
    }

    .pronostics-empty-state i {
        font-size: 3rem;
        color: #ff6600;
    }

    .pronostics-empty-state h4 {
        color: #212529;
        font-weight: 800;
    }

    @media(max-width: 768px) {

        .pronostics-body {
            padding-left: 1.2rem;
            padding-right: 1.2rem;
        }

        .pronostics-title {
            font-size: 1.8rem;
        }

        .team-box {
            justify-content: center !important;
            flex-direction: column;
            gap: .35rem;
        }

        .team-name {
            font-size: .8rem;
        }

        .pronostics-button {
            padding: .5rem .75rem;
            font-size: .82rem;
        }
    }
</style>
