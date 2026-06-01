{{-- @section('title', __('tournaments.title'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card shadow p-3 mb-5 bg-body rounded">
				<div class="">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4>
                                <i class="fa-solid fa-trophy" style="color: #ff6600 !important"></i>
							    {{ __('tournaments.title') }}
                            </h4>
						</div>

						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                            {{ session('message') }}
                        </div>
						@endif

						<div>
							<input wire:model='keyWord' type="text" class="form-control"
                                   name="search" id="search"
                                   placeholder="{{ __('tournaments.search_placeholder') }}">
						</div>

						<div class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createDataModal">
						    <i class="bi-plus-lg"></i> {{ __('tournaments.add_tournament') }}
						</div>
					</div>
				</div>

				<br>

				<div class="card-body shadow p-3 mb-5 bg-body rounded">
					@include('livewire.torneos.modals')

				    <div class="table-responsive">
					    <table class="table table-bordered table-sm">
						    <thead class="thead">
							    <tr> 
								    <td>#</td> 
								    <th>{{ __('tournaments.name') }}</th>
								    <th>{{ __('tournaments.price') }}</th>
								    <th>{{ __('tournaments.start_date') }}</th>
								    <th>{{ __('tournaments.end_date') }}</th>
								    <th>{{ __('tournaments.active') }}</th>
								    <td>{{ __('tournaments.actions') }}</td>
							    </tr>
						    </thead>

						    <tbody>
							    @forelse($torneos as $row)
							    <tr>
								    <td>{{ $loop->iteration }}</td> 
								    <td>{{ $row->nombre_torneo }}</td>
								    <td>{{ $row->precio }}</td>
								    <td>{{ $row->fecha_inicio }}</td>
								    <td>{{ $row->fecha_fin }}</td>

								    @if ($row->activo == 1)
								        <td>{{ __('tournaments.yes') }}</td>
								    @else
								        <td>{{ __('tournaments.no') }}</td>
								    @endif

								    <td width="90">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-secondary dropdown-toggle" href="#"
                                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ __('tournaments.options') }}
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                       class="dropdown-item"
                                                       wire:click="edit({{ $row->id }})">
                                                        <i class="fa fa-edit"></i> {{ __('tournaments.edit') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a type="button" class="dropdown-item"
                                                       wire:click="$emit('eliminar' , {{ $row->id }})">
                                                        <i class="fa fa-trash"></i> {{ __('tournaments.delete') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
							    </tr>
							    @empty
							    <tr>
								    <td class="text-center" colspan="100%">
                                        {{ __('tournaments.no_data') }}
                                    </td>
							    </tr>
							    @endforelse
						    </tbody>
					    </table>						
					    <div class="float-end">{{ $torneos->links() }}</div>
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
        text: "{{ __('tournaments.alerts.delete_confirm') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "{{ __('tournaments.alerts.delete_yes') }}"
    }).then((result) => {
        if (result.isConfirmed) {
            @this.call('destroy', rId);
            Swal.fire(
                "{{ __('tournaments.alerts.delete_success_title') }}",
                "{{ __('tournaments.alerts.delete_success_text') }}",
                'success'
            )
        }
    })
});
</script>
@endpush --}}
@section('title', __('tournaments.title'))
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg p-3 mb-5 bg-body border-0 rounded-4 mb-4">


                <!-- Header: Título, mensaje, buscador y botón -->
                <div
                    style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap:10px;">
                    <div class="float-left">
                        <h4>
                            <i class="fa-solid fa-trophy" style="color: #ff6600 !important"></i>
                            {{ __('tournaments.title') }}
                        </h4>
                    </div>

                    @if (session()->has('message'))
                        <div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0; margin-bottom:0;">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div>
                        <input wire:model='keyWord' type="text" class="form-control" name="search" id="search"
                            placeholder="{{ __('tournaments.search_placeholder') }}">
                    </div>

                    <div class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createDataModal">
                        <i class="bi-plus-lg"></i> {{ __('tournaments.add_tournament') }}
                    </div>
                </div>

                <br>

                <div class="card-body shadow p-3 mb-5 bg-body rounded">
                    @include('livewire.torneos.modals')

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead">
                                <tr>
                                    <td>#</td>
                                    <th>{{ __('tournaments.league') }}</th>
                                    <th>{{ __('tournaments.name') }}</th>
                                    <th>{{ __('tournaments.price') }}</th>
                                    <th>{{ __('tournaments.start_date') }}</th>
                                    <th>{{ __('tournaments.end_date') }}</th>
                                    <th>{{ __('tournaments.active') }}</th>
                                    <td>{{ __('tournaments.actions') }}</td>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($torneos as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <!-- Liga API con logo -->
                                        <td>
                                            @if ($row->apiLeague)
                                                <img src="{{ $row->apiLeague->logo }}" alt="Logo" width="32"
                                                    class="me-1">
                                                {{ $row->apiLeague->name }}
                                            @else
                                                —
                                            @endif
                                        </td>

                                        <td>{{ $row->nombre_torneo }}</td>
                                        <td>{{ $row->precio }}</td>
                                        <td>{{ $row->fecha_inicio }}</td>
                                        <td>{{ $row->fecha_fin }}</td>

                                        @if ($row->activo == 1)
                                            <td>{{ __('tournaments.yes') }}</td>
                                        @else
                                            <td>{{ __('tournaments.no') }}</td>
                                        @endif

                                        <td width="90">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-secondary dropdown-toggle" href="#"
                                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ __('tournaments.options') }}
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                            class="dropdown-item"
                                                            wire:click="edit({{ $row->id }})">
                                                            <i class="fa fa-edit"></i> {{ __('tournaments.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a type="button" class="dropdown-item"
                                                            wire:click="$emit('eliminar' , {{ $row->id }})">
                                                            <i class="fa fa-trash"></i> {{ __('tournaments.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            {{ __('tournaments.no_data') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-end">{{ $torneos->links() }}</div>
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
                text: "{{ __('tournaments.alerts.delete_confirm') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('tournaments.alerts.delete_yes') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', rId);
                    Swal.fire(
                        "{{ __('tournaments.alerts.delete_success_title') }}",
                        "{{ __('tournaments.alerts.delete_success_text') }}",
                        'success'
                    )
                }
            })
        });
    </script>
@endpush
