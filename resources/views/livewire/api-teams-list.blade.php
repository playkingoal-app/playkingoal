@section('title', __('teams.title'))
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow p-3 mb-5 bg-body rounded">

                <!-- Header con título y buscador -->
                <div class="row align-items-center mb-3">
                    <div class="col-12 col-md-4 text-start mb-2 mb-md-0">
                        <h4 class="mb-0">
                            <i class="fa-solid fa-shield-halved" style="color: #ff6600 !important"></i> 
                            {{ __('teams.list_teams') }}
                        </h4>
                    </div>

                    <div class="col-12 col-md-4 mb-2 mb-md-0 d-flex justify-content-center">
                        <input wire:model='keyWord' type="text" class="form-control" placeholder="{{ __('teams.search_placeholder') }}"
                               style="max-width: 250px;">
                    </div>
                </div>

                <!-- Mensaje de sesión -->
                @if (session()->has('message'))
                    <div wire:poll.4s class="btn btn-sm btn-success mb-3">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Card body con tabla -->
                <div class="card-body shadow p-3 mb-5 bg-body rounded">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle shadow-sm border rounded-3 overflow-hidden">
                            <thead class="table-light text-center align-middle">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>{{ __('teams.title') }}</th>
                                    <th style="width: 120px;">{{ __('teams.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($apiTeams as $row)
                                    <tr class="text-center text-md-start">
                                        <td class="fw-semibold">{{ $loop->iteration }}</td>
                                        <td class="d-flex align-items-center gap-3">
                                            <img src="{{ $row->logo }}" alt="Escudo"
                                                 class="rounded-circle border shadow-sm"
                                                 style="width: 45px; height: 45px; object-fit: cover;">
                                            <span class="fw-semibold text-dark">{{ $row->name }}</span>
                                        </td>

                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm border dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                           wire:click="edit({{ $row->id }})">
                                                            <i class="fa fa-edit text-warning"></i> {{ __('teams.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger d-flex align-items-center gap-2"
                                                           wire:click="$emit('eliminar', {{ $row->id }})">
                                                            <i class="fa fa-trash"></i> {{ __('teams.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fa fa-info-circle me-2"></i> {{ __('teams.no_teams') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-3">
                            {{ $apiTeams->links() }}
                        </div>
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
            text: "{{ __('teams.alerts.delete_confirm') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('teams.alerts.delete_yes') }}"
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroy', rId);
                Swal.fire(
                    "{{ __('teams.alerts.delete_success_title') }}",
                    "{{ __('teams.alerts.delete_success_text') }}",
                    'success'
                )
            }
        })
    });
</script>
@endpush
