<!-- Edit Modal -->
<div wire:ignore.self
     class="modal fade"
     id="updateDataModal"
     data-bs-backdrop="static"
     tabindex="-1"
     role="dialog"
     aria-labelledby="updateModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered"
         role="document">

        <div class="modal-content prediction-modal-content">

            <div class="modal-header prediction-modal-header">

                <div>

                    <div class="prediction-modal-accent"></div>

                    <h5 class="modal-title prediction-modal-title"
                        id="updateModalLabel">

                        {{ __('pronostics.modal.edit_title') }}

                    </h5>

                    <p class="prediction-modal-subtitle">
                        {{ __('pronostics.modal.edit_subtitle') }}
                    </p>

                </div>

                <button wire:click.prevent="cancel()"
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="{{ __('pronostics.modal.close') }}">
                </button>

            </div>

            <div class="modal-body prediction-modal-body">

                @if($partidoBloqueado)

                    <div class="prediction-locked-alert mb-3">
                        <i class="fa-solid fa-lock me-1"></i>
                        {{ __('pronostics.locked_match') }}
                    </div>

                @endif

                <div class="prediction-match-card">

                    <div class="prediction-team">

                        @if($localLogo)

                            <img src="{{ $localLogo }}"
                                 alt="{{ __('pronostics.modal.local_team') }}"
                                 class="prediction-team-logo">

                        @else

                            <div class="prediction-team-logo-placeholder">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                        @endif

                        <span>
                            {{ $localNombre ?? __('pronostics.modal.local_team') }}
                        </span>

                    </div>

                    <div class="prediction-vs">
                        VS
                    </div>

                    <div class="prediction-team">

                        @if($visitanteLogo)

                            <img src="{{ $visitanteLogo }}"
                                 alt="{{ __('pronostics.modal.away_team') }}"
                                 class="prediction-team-logo">

                        @else

                            <div class="prediction-team-logo-placeholder">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                        @endif

                        <span>
                            {{ $visitanteNombre ?? __('pronostics.modal.away_team') }}
                        </span>

                    </div>

                </div>

                <form>

                    <input type="hidden" wire:model="selected_id">

                    <div class="prediction-score-box">

                        <div class="prediction-score-item">

                            <label class="prediction-score-label">
                                {{ __('pronostics.modal.local_goals') }}
                            </label>

                            <input wire:model="golesLocal"
                                   type="number"
                                   min="0"
                                   class="form-control prediction-score-input"
                                   placeholder="0"
                                   @disabled($partidoBloqueado)>

                        </div>

                        <div class="prediction-score-separator">
                            -
                        </div>

                        <div class="prediction-score-item">

                            <label class="prediction-score-label">
                                {{ __('pronostics.modal.away_goals') }}
                            </label>

                            <input wire:model="golesVisitante"
                                   type="number"
                                   min="0"
                                   class="form-control prediction-score-input"
                                   placeholder="0"
                                   @disabled($partidoBloqueado)>

                        </div>

                    </div>

                    @error('golesLocal')
                        <span class="text-danger small d-block mt-2 text-center">{{ $message }}</span>
                    @enderror

                    @error('golesVisitante')
                        <span class="text-danger small d-block mt-2 text-center">{{ $message }}</span>
                    @enderror

                </form>

            </div>

            <div class="modal-footer prediction-modal-footer">

                <button type="button"
                        wire:click.prevent="cancel()"
                        class="prediction-secondary-btn"
                        data-bs-dismiss="modal">

                    {{ __('pronostics.modal.close') }}

                </button>

                <button type="button"
                        wire:click.prevent="pronosticar({{ $selected_id }})"
                        class="prediction-primary-btn"
                        @disabled($partidoBloqueado)>

                    {{ __('pronostics.modal.save_prediction') }}

                </button>

            </div>

        </div>

    </div>

</div>

<style>

    .prediction-modal-content{
        border:none;
        border-radius:1.5rem;
        overflow:hidden;
        box-shadow:0 1rem 2.5rem rgba(0,0,0,.16);
    }

    .prediction-modal-header{
        padding:1.6rem 1.6rem 1.2rem;
        border-bottom:1px solid #dee2e6;
        align-items:flex-start;
    }

    .prediction-modal-accent{
        width:48px;
        height:4px;
        border-radius:999px;
        background:#1e40af;
        margin-bottom:1rem;
    }

    .prediction-modal-title{
        font-size:1.45rem;
        font-weight:800;
        color:#212529;
        margin-bottom:.3rem;
    }

    .prediction-modal-subtitle{
        color:#6c757d;
        margin-bottom:0;
        font-size:.92rem;
    }

    .prediction-modal-body{
        padding:1.6rem;
    }

    .prediction-locked-alert {
        background: #f1f3f5;
        color: #6c757d;
        border: 1px solid #dee2e6;
        border-radius: 999px;
        padding: .65rem 1rem;
        font-weight: 800;
        font-size: .85rem;
        text-align: center;
    }

    .prediction-match-card{
        background:#f8f9fa;
        border:1px solid #dee2e6;
        border-radius:1.2rem;
        padding:1.3rem;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:1rem;
        margin-bottom:1.5rem;
    }

    .prediction-team{
        display:flex;
        align-items:center;
        gap:.8rem;
        font-weight:700;
        color:#212529;
        text-align:center;
    }

    .prediction-team-logo,
    .prediction-team-logo-placeholder{
        width:54px;
        height:54px;
        border-radius:50%;
        border:3px solid #fff;
        box-shadow:0 .35rem .9rem rgba(0,0,0,.08);
        background:#fff;
    }

    .prediction-team-logo{
        object-fit:cover;
    }

    .prediction-team-logo-placeholder{
        display:flex;
        align-items:center;
        justify-content:center;
        color:#ff6600;
        background:#fff4ef;
    }

    .prediction-vs{
        font-size:1.1rem;
        font-weight:800;
        color:#1e40af;
    }

    .prediction-score-box{
        display:flex;
        align-items:flex-end;
        justify-content:center;
        gap:1rem;
    }

    .prediction-score-item{
        flex:1;
    }

    .prediction-score-label{
        font-weight:700;
        margin-bottom:.5rem;
        display:block;
        text-align:center;
    }

    .prediction-score-input{
        border-radius:1rem;
        min-height:64px;
        text-align:center;
        font-size:1.6rem;
        font-weight:800;
        border:1px solid #dee2e6;
    }

    .prediction-score-input:focus{
        border-color:#1e40af;
        box-shadow:0 0 0 .2rem rgba(30,64,175,.12);
    }

    .prediction-score-input:disabled {
        background: #f1f3f5;
        color: #6c757d;
        cursor: not-allowed;
    }

    .prediction-score-separator{
        font-size:2rem;
        font-weight:800;
        color:#1e40af;
        padding-bottom:.6rem;
    }

    .prediction-modal-footer{
        border-top:1px solid #dee2e6;
        padding:1.2rem 1.6rem;
        gap:.7rem;
    }

    .prediction-primary-btn,
    .prediction-secondary-btn{
        border:none;
        border-radius:999px;
        min-height:46px;
        padding:.7rem 1.2rem;
        font-weight:800;
        transition:.22s ease;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:.45rem;
    }

    .prediction-primary-btn{
        background:#1e40af;
        color:#fff;
        box-shadow:0 8px 20px rgba(30,64,175,.18);
    }

    .prediction-primary-btn:hover{
        background:#3157d5;
        color:#fff;
        transform:translateY(-2px);
        box-shadow:0 12px 28px rgba(30,64,175,.28);
    }

    .prediction-primary-btn:disabled {
        background: #adb5bd;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    .prediction-secondary-btn{
        background:#f8f9fa;
        color:#495057;
        border:1px solid #dee2e6;
    }

    .prediction-secondary-btn:hover{
        background:#eceef1;
    }

    @media(max-width:575px){

        .prediction-match-card{
            flex-direction:column;
        }

        .prediction-score-box{
            gap:.7rem;
        }

        .prediction-score-input{
            min-height:58px;
            font-size:1.35rem;
        }

        .prediction-modal-footer{
            flex-direction:column-reverse;
        }

        .prediction-primary-btn,
        .prediction-secondary-btn{
            width:100%;
        }
    }

</style>
<script>

    window.addEventListener('closePronosticModal', () => {

        const modalElement = document.getElementById('updateDataModal');

        if(modalElement){

            const modal =
                bootstrap.Modal.getInstance(modalElement);

            modal.hide();
        }


    });

</script>