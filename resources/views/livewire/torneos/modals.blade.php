<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear Nuevo Torneo</h5>
                <button wire:click.prevent="cancel()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="form-group">
                        <label for="nombre_torneo">Nombre del torneo</label>
                        <input wire:model="nombre_torneo" type="text" class="form-control" id="nombre_torneo" placeholder="Nombre Torneo">@error('nombre_torneo') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="api_league_id">Liga</label>
                        <select wire:model="api_league_id" class="form-control" id="api_league_id">
                            <option value="">Selecciona una liga</option>
                            @foreach(\App\Models\ApiLeague::all() as $league)
                                <option value="{{ $league->id }}">{{ $league->name }}</option>
                            @endforeach
                        </select>
                        @error('api_league_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input wire:model="precio" type="text" class="form-control" id="precio" placeholder="Precio">@error('precio') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha inicial</label>
                        <input wire:model="fecha_inicio" type="date" class="form-control" id="fecha_inicio" placeholder="Fecha Inicio">@error('fecha_inicio') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin">Fecha final</label>
                        <input wire:model="fecha_fin" type="date" class="form-control" id="fecha_fin" placeholder="Fecha Fin">@error('fecha_fin') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div wire:ignore.self class="modal fade" id="updateDataModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Torneo</h5>
                <button wire:click.prevent="cancel()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="nombre_torneo">Nombre del torneo</label>
                        <input wire:model="nombre_torneo" type="text" class="form-control" id="nombre_torneo" placeholder="Nombre Torneo">@error('nombre_torneo') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="api_league_id">Liga</label>
                        <select wire:model="api_league_id" class="form-control" id="api_league_id">
                            <option value="">Selecciona una liga</option>
                            @foreach(\App\Models\ApiLeague::all() as $league)
                                <option value="{{ $league->id }}">{{ $league->name }}</option>
                            @endforeach
                        </select>
                        @error('api_league_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input wire:model="precio" type="text" class="form-control" id="precio" placeholder="Precio">@error('precio') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha inicial</label>
                        <input wire:model="fecha_inicio" type="date" class="form-control" id="fecha_inicio" placeholder="Fecha Inicio">@error('fecha_inicio') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin">Fecha final</label>
                        <input wire:model="fecha_fin" type="date" class="form-control" id="fecha_fin" placeholder="Fecha Fin">@error('fecha_fin') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="activo">Estado</label>
                        <input wire:model="activo" type="text" class="form-control" id="activo" placeholder="Activo">@error('activo') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary">Guardar</button>
            </div>
       </div>
    </div>
</div>
