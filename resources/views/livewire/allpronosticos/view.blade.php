@section('title', __('allpronostics.title'))

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
@endsection

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">

        <h1 class="allpronostics-main-title">
            <i class="bi bi-clipboard2-data-fill" style="color:#ff6600"></i>
            {{ __('allpronostics.title') }}
        </h1>

        <p class="allpronostics-main-subtitle">
            {{ __('allpronostics.select_tournament') }}
        </p>

    </div>

    {{-- MENSAJE --}}
    @if (session()->has('message'))

        <div wire:poll.4s
             class="alert alert-success rounded-4 shadow-sm text-center mb-4">

            {{ session('message') }}

        </div>

    @endif

    {{-- SIN TORNEOS --}}
    @if($torneos->isEmpty())

        <div class="allpronostics-section-card">

            <div class="allpronostics-empty">

                <i class="bi bi-inbox"></i>

                <h6 class="fw-bold mt-3 mb-1">
                    {{ __('allpronostics.no_tournaments') }}
                </h6>

            </div>

        </div>

    @else

        {{-- CONTENIDO --}}
        <div class="allpronostics-section-card">

            {{-- SELECT --}}
            <div class="row mb-4">

                <div class="col-lg-4">

                    <label class="form-label fw-semibold">
                        {{ __('allpronostics.select_tournament') }}
                    </label>

                    <select wire:model="selectedTorneo"
                            class="form-select allpronostics-select">

                        @foreach($torneos as $torneo)

                            <option value="{{ $torneo->id }}">
                                {{ $torneo->nombre_torneo }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            {{-- TABLA --}}
            <div class="allpronostics-table-wrapper">

                <div class="table-responsive">

                    <table id="allpronosticos"
                           class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>
                                    {{ __('allpronostics.user') }}
                                </th>

                                <th class="text-end">
                                    {{ __('allpronostics.local') }}
                                </th>

                                <th class="text-end"></th>

                                <th class="text-center"></th>

                                <th></th>

                                <th>
                                    {{ __('allpronostics.away') }}
                                </th>

                               

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($pronosticos as $row)

                                <tr>

                                    <td class="fw-semibold text-dark">
                                        {{ $row->user_name }}
                                    </td>

                                    <td class="text-end">
                                        {{ $row->local_name }}
                                    </td>

                                    <td class="text-end fw-bold">
                                        {{ $row->golesLocal }}
                                    </td>

                                    <td class="text-center text-muted">
                                        -
                                    </td>

                                    <td class="fw-bold">
                                        {{ $row->golesVisitante }}
                                    </td>

                                    <td>
                                        {{ $row->visitante_name }}
                                    </td>

                                </tr>
@endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif

</div>

<style>

    .allpronostics-main-title {
        font-size: 2.4rem;
        font-weight: 800;
        color: #212529;
    }

    .allpronostics-main-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .allpronostics-section-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1.2rem;
        padding: 1.8rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .22s ease;
    }

    .allpronostics-section-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .allpronostics-select {
        border-radius: 999px;
        min-height: 50px;
        border: 1px solid #dee2e6;
        box-shadow: 0 .35rem .9rem rgba(0,0,0,.04);
    }

    .allpronostics-select:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30,64,175,.12);
    }

    .allpronostics-table-wrapper {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1rem;
        box-shadow: 0 .35rem .9rem rgba(0,0,0,.04);
    }

    .allpronostics-table-wrapper table thead th {
        color: #212529;
        font-weight: 800;
        border-bottom: 1px solid #dee2e6;
        white-space: nowrap;
    }

    .allpronostics-table-wrapper table tbody td {
        color: #495057;
        padding: 1rem .75rem;
    }

    .allpronostics-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: #eef8f2;
        color: #198754;
        border: 1px solid #cfead9;
        font-weight: 800;
        font-size: .78rem;
        white-space: nowrap;
    }

    .allpronostics-empty {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #6c757d;
    }

    .allpronostics-empty i {
        font-size: 2.8rem;
        color: #adb5bd;
    }

    @media(max-width: 575px) {

        .allpronostics-main-title {
            font-size: 2rem;
        }

        .allpronostics-section-card {
            padding: 1.3rem;
        }

        .allpronostics-table-wrapper {
            padding: .7rem;
        }

    }

</style>

@push('custom-scripts')

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script>

    document.addEventListener('livewire:load', function () {

        initAllPronosticosTable();

        Livewire.hook('message.processed', () => {
            initAllPronosticosTable();
        });

    });

    function initAllPronosticosTable() {

        if ($.fn.DataTable.isDataTable('#allpronosticos')) {
            $('#allpronosticos').DataTable().destroy();
        }

        $('#allpronosticos').DataTable({

            language: {

                decimal: "",
                emptyTable: "{{ __('allpronostics.empty') }}",
                info: "{{ __('allpronostics.info') }}",
                infoEmpty: "{{ __('allpronostics.info_empty') }}",
                infoFiltered: "{{ __('allpronostics.info_filtered') }}",
                thousands: ",",
                lengthMenu: "{{ __('allpronostics.length_menu') }}",
                loadingRecords: "{{ __('allpronostics.loading') }}",
                processing: "{{ __('allpronostics.processing') }}",
                search: "{{ __('allpronostics.search') }}",
                zeroRecords: "{{ __('allpronostics.zero_records') }}"

            }

        });

    }

</script>

@endpush