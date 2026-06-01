@section('title', __('groups.title'))

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">
        <h1 class="groups-title mt-3">
            <i class="fa-solid fa-users" style="color: #ff6600 !important"></i>
            {{ __('groups.heading') }}
        </h1>

        <p class="groups-subtitle">
            {{ __('groups.subtitle') }}
        </p>
    </div>

    @if(session()->has('error'))
        <div class="alert alert-danger rounded-4 shadow-sm text-center mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success rounded-4 shadow-sm text-center mb-4">
            {{ session('success') }}
        </div>
    @endif

    @php
        $maxGroups = auth()->user()->suscripcionActiva->plan->max_grupos ?? 0;
        $maxUsers = auth()->user()->suscripcionActiva->plan->max_usuarios_por_grupo ?? null;
    @endphp

    {{-- CREAR GRUPO --}}
    <div class="group-create-card mb-5">
        <div class="row align-items-center g-3">
            <div class="col-12 col-lg-8">
                <label class="group-label mb-2">
                    {{ __('groups.create_label') }}
                </label>

                <input
                    type="text"
                    class="form-control group-input"
                    placeholder="{{ __('groups.name_placeholder') }}"
                    wire:model.defer="nombre"
                >

                <small class="text-muted d-block mt-2">
                    <i class="fa-solid fa-circle-info me-1"></i>
                    {{ __('groups.max_groups', ['count' => $maxGroups]) }}
                </small>
            </div>

            <div class="col-12 col-lg-4 text-lg-end">
                <button class="group-button" wire:click="crearGrupo" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="crearGrupo">
                        <i class="fa-solid fa-plus me-2"></i>
                        {{ __('groups.create_button') }}
                    </span>

                    <span wire:loading wire:target="crearGrupo">
                        <i class="fa-solid fa-spinner fa-spin me-2"></i>
                        {{ __('groups.creating') }}
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- LISTA DE GRUPOS --}}
    <div class="row justify-content-center g-4">

        @forelse($grupos as $grupo)

            @php
                $usersCount = $grupo->usuarios->count();
                $isAdmin = $grupo->propietario_id === auth()->id();
            @endphp

            <div class="col-12 col-md-6 col-lg-4">
                <div class="group-card">

                    @if($isAdmin)
                        <div class="group-badge">
                            <i class="fa-solid fa-crown me-1"></i>
                            {{ __('groups.admin') }}
                        </div>
                    @endif

                    <div class="group-icon">
                        <i class="fa-solid fa-people-group"></i>
                    </div>

                    <h4 class="group-name">
                        {{ $grupo->nombre }}
                    </h4>

                    <p class="group-users">
                        <i class="fa-solid fa-user-group me-1"></i>

                        @if($maxUsers)
                            {{ __('groups.users_count', [
                                'count' => $usersCount,
                                'max' => $maxUsers
                            ]) }}
                        @else
                            {{ __('groups.users_unlimited', [
                                'count' => $usersCount
                            ]) }}
                        @endif
                    </p>

                    <div class="group-divider"></div>

                    <a href="{{ route('groups.panel', $grupo) }}" class="group-enter-button">
                        {{ __('groups.enter') }}
                        <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>

                </div>
            </div>

        @empty

            <div class="col-12">
                <div class="group-empty">
                    <i class="fa-regular fa-folder-open mb-3"></i>
                    <h4>{{ __('groups.empty_title') }}</h4>
                    <p>{{ __('groups.empty_text') }}</p>
                </div>
            </div>

        @endforelse

    </div>

</div>

<style>
    .groups-title {
        font-size: 2.4rem;
        font-weight: 800;
    }

    .groups-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .group-create-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
    }

    .group-label {
        font-weight: 800;
        color: #212529;
    }

    .group-input {
        border-radius: 999px;
        padding: .85rem 1.1rem;
        border: 1px solid #dee2e6;
    }

    .group-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30, 64, 175, .12);
    }

    .group-button,
    .group-enter-button {
        border: none;
        border-radius: 999px;
        padding: .85rem 1.25rem;
        background: #1e40af;
        color: #fff;
        font-weight: 700;
        text-decoration: none;
        display: inline-block;
        transition: all .22s ease;
        box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
    }

    .group-button:hover,
    .group-enter-button:hover {
        background: #3157d5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
    }

    .group-card {
        position: relative;
        height: 100%;
        padding: 1.8rem;
        border-radius: 1rem;
        background: #fff;
        border: 1px solid #dee2e6;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .2s ease;
        text-align: center;
    }

    .group-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .group-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: #ff4500;
        color: #fff;
        padding: .35rem .75rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
    }

    .group-icon {
        width: 96px;
        height: 96px;
        margin: 0 auto 1.2rem;
        border-radius: 50%;
        background: #fff4ef;
        color: #ff4500;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        box-shadow: 0 8px 20px rgba(255, 69, 0, .12);
    }

    .group-name {
        font-size: 1.35rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .group-users {
        color: #6c757d;
        font-size: .95rem;
        margin-bottom: 0;
    }

    .group-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .group-empty {
        text-align: center;
        background: #fff;
        border: 1px dashed #dee2e6;
        border-radius: 1rem;
        padding: 3rem 1.5rem;
        color: #6c757d;
    }

    .group-empty i {
        font-size: 3rem;
        color: #ff4500;
    }

    .group-empty h4 {
        font-weight: 800;
        color: #212529;
    }

    @media(max-width: 991px) {
        .group-badge {
            position: static;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .group-button {
            width: 100%;
            text-align: center;
        }
    }
</style>