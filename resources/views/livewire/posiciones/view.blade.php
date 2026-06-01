@section('title', __('standings.title'))

<div class="container py-5">

    <div class="standings-card">

        {{-- HEADER --}}
        <div class="text-center mb-5 pt-4 px-4">

            <h1 class="standings-title mt-3">
                <i class="fa-solid fa-ranking-star"
                   style="color: #ff6600 !important"></i>

                {{ __('standings.heading') }}
            </h1>

            <p class="standings-subtitle">
                {{ __('standings.subtitle') }}
            </p>

            @if (session()->has('message'))
                <div wire:poll.4s class="standings-success-message mx-auto mt-3">
                    <i class="fa-solid fa-circle-check me-1"></i>
                    {{ session('message') }}
                </div>
            @endif

        </div>

        <div class="standings-divider"></div>

        {{-- FILTER --}}
        <div class="standings-body">

            <div class="standings-filter-card mb-4">

                <label for="torneo" class="standings-label">
                    {{ __('standings.select_tournament') }}
                </label>

                <select
                    id="torneo"
                    wire:model="torneo_id"
                    class="form-select standings-input"
                >
                    <option value="">
                        {{ __('standings.select_option') }}
                    </option>

                    @foreach ($torneos as $torneo)
                        <option value="{{ $torneo->id }}">
                            {{ $torneo->nombre_torneo }}
                        </option>
                    @endforeach
                </select>

                <small class="text-muted d-block mt-2">
                    <i class="fa-solid fa-circle-info me-1"></i>
                    {{ __('standings.select_help') }}
                </small>

            </div>

            @include('livewire.jugadores.modals')

            {{-- TABLE --}}
            <div class="table-responsive">

                 <table class="table align-middle standings-table">

                    <thead>
                        <tr>
                            <th>{{ __('standings.position') }}</th>
                            <th>{{ __('standings.name') }}</th>
                            <th class="text-center">{{ __('standings.points') }}</th>
                            <th class="text-center">

    <div class="stat-header" data-bs-toggle="tooltip"
         title="{{ __('standings.exacts_tooltip') }}">

        <i class="fa-solid fa-bullseye text-success"></i>

        <span>
            {{ __('standings.exacts') }}
        </span>

    </div>

</th>

<th class="text-center">

    <div class="stat-header" data-bs-toggle="tooltip"
         title="{{ __('standings.winners_tooltip') }}">

        <i class="fa-solid fa-trophy text-warning"></i>

        <span>
            {{ __('standings.winners') }}
        </span>

    </div>

</th>

<th class="text-center">

    <div class="stat-header" data-bs-toggle="tooltip"
         title="{{ __('standings.goals_tooltip') }}">

        <i class="fa-solid fa-futbol text-primary"></i>

        <span>
            {{ __('standings.goals') }}
        </span>

    </div>

</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($posiciones as $row)
                            <tr>
                                <td>
                                    <div class="position-badge
                                        @if($loop->iteration == 1) first-place
                                        @elseif($loop->iteration == 2) second-place
                                        @elseif($loop->iteration == 3) third-place
                                        @endif
                                    ">
                                        {{ $loop->iteration }}
                                    </div>
                                </td>

                                <td>
                                    <div class="player-box">

    <div class="country-flag">
        <img 
            src="https://flagcdn.com/w40/{{ strtolower(\App\Models\Country::find($row->country_id)?->code) }}.png"
            alt="flag"
        >
    </div>

    <span class="player-name">
        {{ $row->name }}
    </span>

</div>
                                </td>

                                <td class="text-center">
                                    <div class="points-box">
                                        {{ $row->total }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="tie-box exact-box">
                                        {{ $row->exactos }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="tie-box winner-box">
                                        {{ $row->ganadores }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="tie-box goals-box">
                                        {{ $row->goles_acertados }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="standings-empty-state">
                                        <i class="fa-solid fa-ranking-star mb-3"></i>

                                        <h4>{{ __('standings.empty_title') }}</h4>

                                        <p>{{ __('standings.empty_text') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<style>
    .country-flag {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #fff;
    box-shadow:
        0 4px 10px rgba(0,0,0,.12),
        0 0 0 2px rgba(255,255,255,.6);
    flex-shrink: 0;
    background: #fff;
}

.country-flag img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
    .standings-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
    }

    .standings-title {
        font-size: 2.4rem;
        font-weight: 800;
    }

    .standings-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .standings-success-message {
        background: #198754;
        color: #fff;
        border-radius: 999px;
        padding: .55rem 1rem;
        font-weight: 700;
        font-size: .85rem;
        width: fit-content;
    }

    .standings-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .standings-body {
        padding: 0 2rem 2rem;
    }

    .standings-filter-card {
        background: #f8f9fa;
        border-radius: 1rem;
        padding: 1rem;
    }

    .standings-label {
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .standings-input {
        border-radius: 999px;
        padding: .85rem 1.1rem;
        border: 1px solid #dee2e6;
    }

    .standings-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30,64,175,.12);
    }

    .standings-table {
        margin-bottom: 0;
    }

    .standings-table thead th {
        color: #6c757d;
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: 1px solid #dee2e6;
    }

    .standings-table tbody tr {
        transition: all .2s ease;
    }

    .standings-table tbody tr:hover {
        background: #f8f9fa;
    }

    .position-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #f1f3f5;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

   .first-place {
    background: linear-gradient(135deg, #FFD700, #ffb700);
    color: #fff;
    border: none;
    box-shadow: 0 4px 12px rgba(255,215,0,.45);
}

.second-place {
    background: linear-gradient(135deg, #d9d9d9, #9f9f9f);
    color: #fff;
    border: none;
    box-shadow: 0 4px 12px rgba(192,192,192,.45);
}

.third-place {
    background: linear-gradient(135deg, #cd7f32, #a85a14);
    color: #fff;
    border: none;
    box-shadow: 0 4px 12px rgba(205,127,50,.45);
}

    .player-box {
        display: flex;
        align-items: center;
        gap: .65rem;
    }

    .player-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #1e40af;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        flex-shrink: 0;
    }

    .player-name {
        font-weight: 700;
        color: #212529;
    }

    .points-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 70px;
        border-radius: 999px;
        padding: .45rem .9rem;
        background: #fff4ef;
        color: #ff4500;
        font-weight: 800;
    }

    .standings-empty-state {
        text-align: center;
        border: 1px dashed #dee2e6;
        border-radius: 1rem;
        padding: 3rem 1.5rem;
        color: #6c757d;
    }

    .standings-empty-state i {
        font-size: 3rem;
        color: #ff6600;
    }

    .standings-empty-state h4 {
        color: #212529;
        font-weight: 800;
    }
.stat-header{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:.4rem;
    font-weight:700;
}
    @media(max-width: 768px) {
        .standings-body {
            padding: 0 1rem 1.5rem;
        }

        .standings-title {
            font-size: 1.8rem;
        }

        .player-name {
            font-size: .85rem;
        }
    }
</style>
<script>
    document.addEventListener("livewire:load", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>