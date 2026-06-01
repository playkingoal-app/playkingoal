<!-- Add Modal -->
<div wire:ignore.self
     class="modal fade"
     id="createDataModal"
     data-bs-backdrop="static"
     tabindex="-1"
     role="dialog"
     aria-labelledby="createDataModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content matchday-modal-content">

            <div class="modal-header matchday-modal-header">

                <div>
                    <div class="matchday-modal-accent"></div>

                    <h5 class="modal-title matchday-modal-title" id="createDataModalLabel">
                        {{ __('matchdays.modal.create_title') }}
                    </h5>

                    <p class="matchday-modal-subtitle">
                        {{ __('matchdays.modal.create_subtitle') }}
                    </p>
                </div>

                <button wire:click.prevent="cancel()"
                        type="button"
                        class="btn-close matchday-modal-close"
                        data-bs-dismiss="modal"
                        aria-label="{{ __('matchdays.modal.close') }}">
                </button>

            </div>

            <div class="modal-body matchday-modal-body">

                <form>

                    <div class="mb-3">

                        <label for="torneo_id" class="form-label fw-semibold">
                            {{ __('matchdays.modal.tournament') }}
                        </label>

                        <select wire:model="torneo_id"
                                class="form-select matchday-modal-input"
                                id="torneo_id">

                            <option value="">
                                {{ __('matchdays.modal.select_tournament') }}
                            </option>

                            @foreach ($torneos as $row)

                                <option value="{{ $row->id }}">
                                    {{ $row->nombre_torneo }}
                                </option>

                            @endforeach

                        </select>

                        @error('torneo_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label for="descripcion" class="form-label fw-semibold">
                            {{ __('matchdays.modal.description') }}
                        </label>

                        <input wire:model="descripcion"
                               type="text"
                               class="form-control matchday-modal-input"
                               id="descripcion"
                               placeholder="{{ __('matchdays.modal.description_placeholder') }}">

                        @error('descripcion')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label for="valor_puntaje_me" class="form-label fw-semibold">
                                {{ __('matchdays.modal.exact_score_points') }}
                            </label>

                            <input wire:model="valor_puntaje_me"
                                   type="number"
                                   min="0"
                                   class="form-control matchday-modal-input"
                                   id="valor_puntaje_me"
                                   placeholder="{{ __('matchdays.modal.exact_score_placeholder') }}">

                            @error('valor_puntaje_me')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="col-md-6">

                            <label for="valor_puntaje_g" class="form-label fw-semibold">
                                {{ __('matchdays.modal.winner_points') }}
                            </label>

                            <input wire:model="valor_puntaje_g"
                                   type="number"
                                   min="0"
                                   class="form-control matchday-modal-input"
                                   id="valor_puntaje_g"
                                   placeholder="{{ __('matchdays.modal.winner_placeholder') }}">

                            @error('valor_puntaje_g')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer matchday-modal-footer">

                <button type="button"
                        class="matchday-modal-secondary"
                        data-bs-dismiss="modal">

                    {{ __('matchdays.modal.close') }}

                </button>

                <button type="button"
                        wire:click.prevent="store()"
                        class="matchday-modal-primary">

                    <i class="bi bi-check2-circle"></i>
                    {{ __('matchdays.modal.save') }}

                </button>

            </div>

        </div>

    </div>

</div>


<!-- Edit Modal -->
<div wire:ignore.self
     class="modal fade"
     id="updateDataModal"
     data-bs-backdrop="static"
     tabindex="-1"
     role="dialog"
     aria-labelledby="updateModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content matchday-modal-content">

            <div class="modal-header matchday-modal-header">

                <div>
                    <div class="matchday-modal-accent"></div>

                    <h5 class="modal-title matchday-modal-title" id="updateModalLabel">
                        {{ __('matchdays.modal.edit_title') }}
                    </h5>

                    <p class="matchday-modal-subtitle">
                        {{ __('matchdays.modal.edit_subtitle') }}
                    </p>
                </div>

                <button wire:click.prevent="cancel()"
                        type="button"
                        class="btn-close matchday-modal-close"
                        data-bs-dismiss="modal"
                        aria-label="{{ __('matchdays.modal.close') }}">
                </button>

            </div>

            <div class="modal-body matchday-modal-body">

                <form>

                    <input type="hidden" wire:model="selected_id">

                    <div class="mb-3">

                        <label for="descripcion_update" class="form-label fw-semibold">
                            {{ __('matchdays.modal.description') }}
                        </label>

                        <input wire:model="descripcion"
                               type="text"
                               class="form-control matchday-modal-input"
                               id="descripcion_update"
                               placeholder="{{ __('matchdays.modal.description_placeholder') }}"    readonly>

                        @error('descripcion')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label for="valor_puntaje_me_update" class="form-label fw-semibold">
                                {{ __('matchdays.modal.exact_score_points') }}
                            </label>

                            <input wire:model="valor_puntaje_me"
                                   type="number"
                                   min="0"
                                   class="form-control matchday-modal-input"
                                   id="valor_puntaje_me_update"
                                   placeholder="{{ __('matchdays.modal.exact_score_placeholder') }}">

                            @error('valor_puntaje_me')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="col-md-6">

                            <label for="valor_puntaje_g_update" class="form-label fw-semibold">
                                {{ __('matchdays.modal.winner_points') }}
                            </label>

                            <input wire:model="valor_puntaje_g"
                                   type="number"
                                   min="0"
                                   class="form-control matchday-modal-input"
                                   id="valor_puntaje_g_update"
                                   placeholder="{{ __('matchdays.modal.winner_placeholder') }}">

                            @error('valor_puntaje_g')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer matchday-modal-footer">

                <button type="button"
                        wire:click.prevent="cancel()"
                        class="matchday-modal-secondary"
                        data-bs-dismiss="modal">

                    {{ __('matchdays.modal.close') }}

                </button>

                <button type="button"
                        wire:click.prevent="update()"
                        class="matchday-modal-primary">

                    <i class="bi bi-check2-circle"></i>
                    {{ __('matchdays.modal.save') }}

                </button>

            </div>

        </div>

    </div>

</div>

<style>
    .matchday-modal-content {
        border: none;
        border-radius: 1.4rem;
        overflow: hidden;
        box-shadow: 0 1rem 2.5rem rgba(0,0,0,.16);
    }

    .matchday-modal-header {
        border-bottom: 1px solid #dee2e6;
        padding: 1.6rem 1.6rem 1.2rem;
        align-items: flex-start;
    }

    .matchday-modal-accent {
        width: 46px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .matchday-modal-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .35rem;
    }

    .matchday-modal-subtitle {
        color: #6c757d;
        margin-bottom: 0;
        font-size: .92rem;
    }

    .matchday-modal-close {
        box-shadow: none !important;
    }

    .matchday-modal-body {
        padding: 1.6rem;
    }

    .matchday-modal-input {
        border-radius: 999px;
        min-height: 50px;
        border: 1px solid #dee2e6;
        box-shadow: 0 .35rem .9rem rgba(0,0,0,.04);
        padding-left: 1.1rem;
    }

    .matchday-modal-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30,64,175,.12);
    }

    .matchday-modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 1.2rem 1.6rem;
        gap: .7rem;
    }

    .matchday-modal-primary,
    .matchday-modal-secondary {
        border: none;
        border-radius: 999px;
        min-height: 46px;
        padding: .7rem 1.2rem;
        font-weight: 800;
        transition: .22s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
    }

    .matchday-modal-primary {
        background: #1e40af;
        color: #fff;
        box-shadow: 0 8px 20px rgba(30,64,175,.18);
    }

    .matchday-modal-primary:hover {
        background: #3157d5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30,64,175,.28);
    }

    .matchday-modal-secondary {
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    .matchday-modal-secondary:hover {
        background: #eceef1;
    }

    @media(max-width: 575px) {
        .matchday-modal-header,
        .matchday-modal-body,
        .matchday-modal-footer {
            padding-left: 1.2rem;
            padding-right: 1.2rem;
        }

        .matchday-modal-footer {
            flex-direction: column-reverse;
        }

        .matchday-modal-primary,
        .matchday-modal-secondary {
            width: 100%;
        }
    }
</style>