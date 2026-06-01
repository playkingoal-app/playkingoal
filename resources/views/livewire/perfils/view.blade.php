<div>

@section('title', __('profile.title'))

{{-- Bootstrap Icons --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container py-5">

    @include('livewire.perfils.modals')

    {{-- HEADER --}}
    <div class="text-center mb-5">

        <h1 class="profile-title mt-3">
            <i class="fa-solid fa-user" style="color: #ff6600 !important"></i>
            {{ __('profile.my_profile') }}
        </h1>

        <p class="profile-subtitle">
            {{ __('profile.title') }}
        </p>

    </div>
 {{-- ALERTA --}}
    @if (session('message'))
        <div class="alert alert-success rounded-4 shadow-sm text-center mb-5">
            {{ session('message') }}
        </div>
    @endif
    {{-- RESUMEN --}}
    <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">

        <div class="profile-status-badge success">
            <i class="bi bi-person-check"></i>
            <span>{{ Auth::user()->username }}</span>
        </div>

        <div class="profile-status-badge warning">
            <i class="bi bi-people"></i>
            <span>
                {{ $invitados->count() }}
                {{ __('profile.invited_people') }}
            </span>
        </div>

    </div>

    <div class="row justify-content-center g-4">

        {{-- PERFIL --}}
        <div class="col-12 col-lg-8">

            <div class="profile-section-card">

                <div class="profile-top">

                    <div class="profile-accent"></div>

                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">

                        <div>

                            <h3 class="profile-name">
                                {{ __('profile.my_profile') }}
                            </h3>

                            <p class="profile-description">
                                {{ __('profile.title') }}
                            </p>

                        </div>

                  <button type="button"
        class="profile-button primary"
        wire:click="editProfile"
        data-bs-toggle="modal"
        data-bs-target="#updateProfileModal">

    <i class="fa fa-edit"></i>
    {{ __('profile.edit') }}

</button>

                    </div>

                </div>

                <div class="profile-divider"></div>

                {{-- FOTO --}}
                <div class="text-center mb-5">

                    <img
                        src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                        class="profile-avatar shadow-sm"
                    >

                    <h4 class="mt-4 fw-bold">
                        {{ Auth::user()->username }}
                    </h4>

                    <p class="text-muted mb-0">
                        {{ Auth::user()->email }}
                    </p>

                </div>

                {{-- DATOS --}}
                <div class="row g-4">

                    <div class="col-md-6">

                        <div class="profile-info-card h-100">

                            <div class="profile-mini-icon success">
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <small class="text-muted d-block mb-1">
                                {{ __('profile.full_name') }}
                            </small>

                            <div class="fw-bold">
                                {{ Auth::user()->name }}
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="profile-info-card h-100">

                            <div class="profile-mini-icon warning">
                                <i class="fa-solid fa-envelope"></i>
                            </div>

                            <small class="text-muted d-block mb-1">
                                {{ __('profile.email') }}
                            </small>

                            <div class="fw-bold">
                                {{ Auth::user()->email }}
                            </div>

                        </div>

                    </div>

                  

                    <div class="col-md-6">

                        <div class="profile-info-card h-100">

                            <div class="profile-mini-icon warning">
                                <i class="fa-solid fa-earth-americas"></i>
                            </div>

                            <small class="text-muted d-block mb-1">
                                {{ __('profile.country') }}
                            </small>

                            <div class="fw-bold">
                                {{ $country_name }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- INVITACIONES --}}
        <div class="col-12 col-lg-4">

            {{-- CODIGO --}}
            <div class="profile-section-card mb-4">

                <div class="profile-top">

                    <div class="profile-accent"></div>

                    <div class="d-flex justify-content-between align-items-start gap-3">

                        <div>

                            <h3 class="profile-name">
                                {{ __('profile.invitation_code') }}
                            </h3>

                            <p class="profile-description">
                                {{ __('profile.your_code') }}
                            </p>

                        </div>

                        <div class="profile-icon warning">
                            <i class="fa-solid fa-gift"></i>
                        </div>

                    </div>

                </div>

                <div class="profile-divider"></div>

                <div class="profile-code-box mb-4">

                    <div>

                        <small class="text-muted d-block">
                            {{ __('profile.your_code') }}
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ Auth::user()->cod_invitacion }}
                        </h4>

                    </div>

                    <button class="profile-button secondary"
                            onclick="copiarCodigo()">

                        <i class="fa-regular fa-copy"></i>

                    </button>

                </div>

                <div>

                    <small class="text-muted d-block mb-2">
                        {{ __('profile.invitation_link') }}
                    </small>

                    <div class="input-group">

                        <input type="text"
                               class="form-control profile-input"
                               value="{{ route('register', ['cod' => Auth::user()->cod_invitacion]) }}"
                               readonly>

                        <button class="profile-button primary rounded-start-0"
                                onclick="copiarEnlace()">

                            <i class="fa fa-link"></i>

                        </button>

                    </div>

                </div>

            </div>

            {{-- INVITADOS --}}
            <div class="profile-section-card">

                <div class="profile-top">

                    <div class="profile-accent"></div>

                    <div class="d-flex justify-content-between align-items-start gap-3">

                        <div>

                            <h3 class="profile-name">
                                {{ __('profile.invited_people') }}
                            </h3>

                            <p class="profile-description">
                                {{ __('profile.invited_summary', ['count' => $invitados->count()]) }}
                            </p>

                        </div>

                        <div class="profile-icon success">
                            <i class="fa-solid fa-users"></i>
                        </div>

                    </div>

                </div>

                <div class="profile-divider"></div>

                @forelse ($invitados as $inv)

                    <div class="profile-invited-item">

                        <div>

                            <div class="fw-semibold text-dark">
                                {{ $inv->name }}
                            </div>

                            <small class="text-muted">
                                {{ __('profile.registered') }}
                            </small>

                        </div>

                        <span class="profile-badge">
                            <i class="bi bi-check-circle-fill"></i>
                        </span>

                    </div>

                @empty

                    <div class="profile-empty">

                        <i class="bi bi-people"></i>

                        <h6 class="fw-bold mt-3 mb-1">
                            {{ __('profile.invited_people') }}
                        </h6>

                        <p class="text-muted mb-0">
                            No has invitado a nadie aún.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

<style>

    .profile-title {
        font-size: 2.4rem;
        font-weight: 800;
    }

    .profile-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .profile-status-badge {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .65rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .9rem;
        border: 1px solid transparent;
    }

    .profile-status-badge.warning {
        background: #fff4ef;
        color: #ff4500;
        border-color: #ffd4c2;
    }

    .profile-status-badge.success {
        background: #eef8f2;
        color: #198754;
        border-color: #cfead9;
    }

    .profile-section-card,
    .profile-info-card {
        position: relative;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .2s ease;
    }

    .profile-section-card {
        padding: 1.8rem;
    }

    .profile-info-card {
        padding: 1.3rem;
        height: 100%;
    }

    .profile-section-card:hover,
    .profile-info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .profile-accent {
        width: 46px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .profile-name {
        font-size: 1.6rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .profile-description {
        color: #6c757d;
        font-size: .95rem;
        margin-bottom: 0;
    }

    .profile-icon,
    .profile-mini-icon {
        width: 48px;
        height: 48px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .profile-icon.warning,
    .profile-mini-icon.warning {
        background: #fff4ef;
        color: #ff4500;
    }

    .profile-icon.success,
    .profile-mini-icon.success {
        background: #eef8f2;
        color: #ff6600;
    }

    .profile-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.12);
    }

    .profile-button {
        border: none;
        border-radius: 999px;
        padding: .6rem 1rem;
        font-weight: 700;
        font-size: .85rem;
        transition: .22s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
    }

    .profile-button.primary {
        background: #1e40af;
        color: #fff;
        box-shadow: 0 8px 20px rgba(30,64,175,.18);
    }

    .profile-button.primary:hover {
        background: #3157d5;
        color: #fff;
        transform: translateY(-2px);
    }

    .profile-button.secondary {
        background: #fff4ef;
        color: #ff6600;
        border: 1px solid #ffd4c2;
    }

    .profile-button.secondary:hover {
        background: #ffe7dc;
    }

    .profile-code-box {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .profile-input {
        border-radius: 999px 0 0 999px;
        border: 1px solid #dee2e6;
        padding-left: 1rem;
    }

    .profile-invited-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f5;
    }

    .profile-invited-item:last-child {
        border-bottom: none;
    }

    .profile-badge {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #eef8f2;
        color: #ff6600;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-empty {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #6c757d;
    }

    .profile-empty i {
        font-size: 2.8rem;
        color: #adb5bd;
    }

    @media(max-width: 575px) {

        .profile-title {
            font-size: 2rem;
        }

        .profile-section-card {
            padding: 1.3rem;
        }

        .profile-name {
            font-size: 1.35rem;
        }

        .profile-button {
            width: 100%;
        }

    }

</style>

<script>

    function copiarCodigo() {

        const codigo = "{{ Auth::user()->cod_invitacion }}";

        navigator.clipboard.writeText(codigo);

        alert("{{ __('profile.code_copied') }}");
    }

    function copiarEnlace() {

        const enlace = "{{ route('register', ['cod' => Auth::user()->cod_invitacion]) }}";

        navigator.clipboard.writeText(enlace);

        alert("{{ __('profile.link_copied') }}");
    }

</script>
<script>
    document.addEventListener('livewire:load', function () {

        Livewire.on('openUpdateProfileModal', function () {
            let modal = new bootstrap.Modal(document.getElementById('updateDataModal'));
            modal.show();
        });

        Livewire.on('closeUpdateProfileModal', function () {
            let modalElement = document.getElementById('updateDataModal');
            let modal = bootstrap.Modal.getInstance(modalElement);

            if (modal) {
                modal.hide();
            }
        });

    });
</script>
<script>
    window.addEventListener('closeModal', event => {
        const modalElement = document.getElementById('updateProfileModal');

        const modal = bootstrap.Modal.getInstance(modalElement)
            || new bootstrap.Modal(modalElement);

        modal.hide();
    });
</script>
</div>