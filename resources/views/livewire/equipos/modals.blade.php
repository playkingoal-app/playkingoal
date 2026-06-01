<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear Nuevo Equipo</h5>
                <button wire:click.prevent="cancel()" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="nombre_equipo">Nombre del equipo: </label>
                        <input wire:model="nombre_equipo" type="text" class="form-control" id="nombre_equipo">
                        @error('nombre_equipo')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="escudo"> Escudo: </label>
                        <input wire:model="escudo" type="file" class="form-control" id="escudo">
                        @error('escudo')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div wire:loading wire:target="escudo" class="mt-2">
                        <div class="d-flex align-items-center text-muted small">
                            <div class="spinner-grow spinner-grow-sm text-primary me-2" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <span>Subiendo imagen...</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary"
                    wire:loading.attr="disabled">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div wire:ignore.self class="modal fade" id="updateDataModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Equipos</h5>
                <button wire:click.prevent="cancel()" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="nombre_equipo"></label>
                        <input wire:model="nombre_equipo" type="text" class="form-control" id="nombre_equipo"
                            placeholder="Nombre Equipo">
                        @error('nombre_equipo')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="escudo"> Escudo: </label>
                        <input wire:model="escudo" type="file" class="form-control" id="escudo">
                        @error('escudo')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
