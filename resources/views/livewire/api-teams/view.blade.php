 @section('title', __('teams.title'))
 <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
<div class="card shadow p-3 mb-5 bg-body rounded">
    <div class="row align-items-center mb-3">
        <div class="col-12 col-md-4 text-start mb-2 mb-md-0">
            <h4 class="mb-0">
                <i class="fa-solid fa-shield-halved" style="color: #ff6600 !important"></i> 
                Equipos
            </h4>
        </div>

        <div class="col-12 col-md-4 mb-2 mb-md-0 d-flex justify-content-center">
       

            <input wire:model.debounce.500ms="keyWord" type="text" class="form-control" placeholder="Buscar equipo"
                   style="max-width: 250px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle shadow-sm border rounded-3 overflow-hidden">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th>#</th>
                    <th>Equipo</th>
              
                </tr>
            </thead>

            <tbody>
                @forelse($equipos as $row)
                    <tr class="text-center text-md-start">
                        <td>{{ $loop->iteration }}</td>
                        <td class="d-flex align-items-center gap-3">
                            <img src="{{ $row->logo }}" alt="Escudo"
                                 class="rounded-circle border shadow-sm"
                                 style="width: 45px; height: 45px; object-fit: cover;">
                            <span class="fw-semibold text-dark">{{ $row->name }}</span>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="fa fa-info-circle me-2"></i> No hay equipos
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-3">
            {{ $equipos->links() }}
        </div>
    </div>
</div>
</div>
</div>
</div>