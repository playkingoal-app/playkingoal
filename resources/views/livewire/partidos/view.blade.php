@section('title', __('matches.title'))
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card shadow-lg p-3 mb-5 bg-body border-0 rounded-4 mb-4">
                <div class="">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <h4>
                                <i class="fa-solid fa-futbol" style="color: #ff6600 !important"></i>
                                {{ __('matches.list') }}
                            </h4>
                        </div>

                        @if (session()->has('message'))
                            <div wire:poll.4s class="btn btn-sm btn-success"
                                style="margin-top:0px; margin-bottom:0px;">
                                {{ session('message') }}
                            </div>
                        @endif

                        {{-- <div class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createDataModal">
                            <i class="fa fa-plus"></i> {{ __('matches.add') }}
                        </div> --}}
                    </div>
                </div>

                <br>

                <div class="card-body shadow p-3 mb-5 bg-body rounded">
                    @include('livewire.partidos.modals')

                    <div class="mb-3">
                        <label for="torneoSelect" class="form-label">
                            {{ __('matches.select_tournament') }}
                        </label>
                        <select wire:model="torneo_id" id="torneoSelect" class="form-select">
                            <option value="">
                                {{ __('matches.all_tournaments') }}
                            </option>
                            @foreach ($torneos as $torneo)
                                <option value="{{ $torneo->id }}">{{ $torneo->nombre_torneo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead">
                                <tr>
                                    <td>#</td>
                                    <th style="text-align: right;">
                                        {{ __('matches.home_team') }}
                                    </th>
                                    <th style="text-align: center;"></th>
                                    <th>
                                        {{ __('matches.away_team') }}
                                    </th>
                                    {{-- <td>
                                        {{ __('matches.actions') }}
                                    </td> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($partidos as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        @php
                                            $local = DB::table('equipos')
                                                ->where('id', $row->idEquipoLocal)
                                                ->pluck('name')
                                                ->first();
                                            $escudo_local = DB::table('equipos')
                                                ->where('id', $row->idEquipoLocal)
                                                ->pluck('logo')
                                                ->first();
                                        @endphp

                                        <td style="text-align: right; padding-right:10px">
                                            {{ $local }}
                                            <img src="{{  $escudo_local }}" class="escudo">
                                        </td>

                                        @php
                                            $visita = DB::table('equipos')
                                                ->where('id', $row->idEquipoVisitante)
                                                ->pluck('name')
                                                ->first();
                                            $escudo_visita = DB::table('equipos')
                                                ->where('id', $row->idEquipoVisitante)
                                                ->pluck('logo')
                                                ->first();
                                        @endphp

                                        <td style="text-align:center;">
                                            {{ __('matches.vs') }}
                                        </td>

                                        <td>
                                            <img src="{{ $escudo_visita }}" class="escudo">
                                            {{ $visita }}
                                        </td>

                                        {{-- <td width="90">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-secondary dropdown-toggle"
                                                   href="#"
                                                   role="button"
                                                   data-bs-toggle="dropdown"
                                                   aria-expanded="false">
                                                    {{ __('matches.options') }}
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a data-bs-toggle="modal"
                                                           data-bs-target="#updateDataModal"
                                                           class="dropdown-item"
                                                           wire:click="edit({{ $row->id }})">
                                                            <i class="fa fa-edit"></i>
                                                            {{ __('matches.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a type="button"
                                                           class="dropdown-item"
                                                           wire:click="$emit('eliminar' , {{ $row->id }})">
                                                            <i class="fa fa-trash"></i>
                                                            {{ __('matches.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            {{ __('matches.no_data') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="float-end">{{ $partidos->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
<script>
Livewire.on('eliminar', rId => {
    Swal.fire({
        title: '',
        text: "{{ __('matches.alerts.delete_confirm') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "{{ __('matches.alerts.delete_yes') }}"
    }).then((result) => {
        if (result.isConfirmed) {
            @this.call('destroy', rId);
            Swal.fire(
                "{{ __('matches.alerts.delete_success_title') }}",
                "{{ __('matches.alerts.delete_success_text') }}",
                'success'
            )
        }
    })
});
</script>
@endpush
