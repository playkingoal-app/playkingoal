@section('title', __('matchdays.title'))

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">

        <h1 class="matchdays-main-title">
            <i class="bi bi-calendar-day" style="color:#ff6600"></i>
            {{ __('matchdays.list') }}
        </h1>

        <p class="matchdays-main-subtitle">
            {{ __('matchdays.subtitle') }}
        </p>

    </div>

    {{-- ALERTA --}}
    @if (session()->has('message'))

        <div wire:poll.4s
             class="alert alert-success rounded-4 shadow-sm text-center mb-4">

            {{ session('message') }}

        </div>

    @endif
 @include('livewire.jornadas.modals')
    {{-- CARD --}}
    <div class="matchdays-section-card">

       

        {{-- FILTROS --}}
        <div class="row g-4 align-items-end mb-4">

            <div class="col-lg-4">

                <label for="torneoSeleccionado"
                       class="form-label fw-semibold">

                    {{ __('pronostics.select_tournament') }}

                </label>

                <select wire:model="torneoSeleccionado"
                        id="torneoSeleccionado"
                        class="form-select matchdays-select">

                    <option value="">
                        {{ __('matchdays.all_tournaments') }}
                    </option>

                    @foreach ($torneos as $torneo)

                        <option value="{{ $torneo->id }}">
                            {{ $torneo->nombre_torneo }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-lg-4">

                <label class="form-label fw-semibold">
                    {{ __('matchdays.search') }}
                </label>

                <input wire:model="keyWord"
                       type="text"
                       class="form-control matchdays-input"
                       name="search"
                       id="search"
                       placeholder="{{ __('matchdays.search_placeholder') }}">

            </div>

            {{-- <div class="col-lg-4">

                <button class="matchdays-button w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#createDataModal">

                    <i class="fa fa-plus"></i>

                    {{ __('matchdays.add') }}

                </button>

            </div> --}}

        </div>

        {{-- TABLA --}}
        <div class="matchdays-table-wrapper">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>
                                {{ __('matchdays.description') }}
                            </th>

                            <th>
                                {{ __('matchdays.tournament') }}
                            </th>

                            <th>
                                {{ __('matchdays.exact_score_points') }}
                            </th>

                            <th>
                                {{ __('matchdays.winner_points') }}
                            </th>

                            <th class="text-center">
                                {{ __('matchdays.actions') }}
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($jornadas as $row)

                            <tr>

                                <td class="fw-semibold">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold text-dark">
                                    {{ $row->descripcion }}
                                </td>

                                <td>
                                    {{ $row->nombre_torneo }}
                                </td>

                                <td>

                                    <span class="matchdays-points-badge">

                                        {{ $row->valor_puntaje_me }}

                                    </span>

                                </td>

                                <td>

                                    <span class="matchdays-points-badge secondary">

                                        {{ $row->valor_puntaje_g }}

                                    </span>

                                </td>

                                <td class="text-center">

                                    <div class="dropdown">

                                        <button class="matchdays-options-button dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">

                                            {{ __('matchdays.options') }}

                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4">

                                            <li>

                                                <a data-bs-toggle="modal"
                                                   data-bs-target="#updateDataModal"
                                                   class="dropdown-item"
                                                   wire:click="edit({{ $row->id }})">

                                                    <i class="fa fa-edit me-2"></i>

                                                    {{ __('matchdays.edit') }}

                                                </a>

                                            </li>

                                            {{-- <li>

                                                <a type="button"
                                                   class="dropdown-item text-danger"
                                                   wire:click="$emit('eliminar', {{ $row->id }})">

                                                    <i class="fa fa-trash me-2"></i>

                                                    {{ __('matchdays.delete') }}

                                                </a>

                                            </li> --}}

                                        </ul>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td class="text-center text-muted py-5"
                                    colspan="100%">

                                    {{ __('matchdays.no_data') }}

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINACIÓN --}}
        <div class="d-flex justify-content-end mt-4">

            {{ $jornadas->links() }}

        </div>

    </div>

</div>

<style>

    .matchdays-main-title {
        font-size: 2.4rem;
        font-weight: 800;
        color: #212529;
    }

    .matchdays-main-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .matchdays-section-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1.2rem;
        padding: 1.8rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .22s ease;
    }

    .matchdays-section-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .matchdays-select,
    .matchdays-input {
        border-radius: 999px;
        min-height: 50px;
        border: 1px solid #dee2e6;
        box-shadow: 0 .35rem .9rem rgba(0,0,0,.04);
    }

    .matchdays-select:focus,
    .matchdays-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30,64,175,.12);
    }

    .matchdays-button {
        border: none;
        border-radius: 999px;
        min-height: 50px;
        background: #1e40af;
        color: #fff;
        font-weight: 700;
        transition: .22s ease;
        box-shadow: 0 8px 20px rgba(30,64,175,.18);
    }

    .matchdays-button:hover {
        background: #3157d5;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30,64,175,.28);
    }

    .matchdays-table-wrapper {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1rem;
        box-shadow: 0 .35rem .9rem rgba(0,0,0,.04);
    }

    .matchdays-table-wrapper table thead th {
        color: #212529;
        font-weight: 800;
        border-bottom: 1px solid #dee2e6;
        white-space: nowrap;
    }

    .matchdays-table-wrapper table tbody td {
        color: #495057;
        padding: 1rem .75rem;
    }

    .matchdays-points-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 48px;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: #eef4ff;
        color: #1e40af;
        border: 1px solid #d7e3ff;
        font-weight: 800;
        font-size: .82rem;
    }

    .matchdays-points-badge.secondary {
        background: #fff4ef;
        color: #ff6600;
        border: 1px solid #ffd4c2;
    }

    .matchdays-options-button {
        border: none;
        border-radius: 999px;
        padding: .5rem 1rem;
        background: #f8f9fa;
        color: #212529;
        font-weight: 700;
        transition: .2s ease;
    }

    .matchdays-options-button:hover {
        background: #eceef1;
    }

    @media(max-width: 575px) {

        .matchdays-main-title {
            font-size: 2rem;
        }

        .matchdays-section-card {
            padding: 1.3rem;
        }

        .matchdays-table-wrapper {
            padding: .7rem;
        }

    }

</style>

@push('custom-scripts')

<script>

    Livewire.on('eliminar', rId => {

        Swal.fire({

            title: '',
            text: "{{ __('matchdays.alerts.delete_confirm') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1e40af',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('matchdays.alerts.delete_yes') }}"

        }).then((result) => {

            if (result.isConfirmed) {

                @this.call('destroy', rId);

                Swal.fire(

                    "{{ __('matchdays.alerts.delete_success_title') }}",
                    "{{ __('matchdays.alerts.delete_success_text') }}",
                    'success'

                )

            }

        })

    });

</script>

@endpush