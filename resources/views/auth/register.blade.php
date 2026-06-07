<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <link rel="stylesheet" href="{{ asset('estilos.css') }}?v={{ time() }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&display=swap"
    rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .form-control.is-invalid,
    .form-select.is-invalid {
        background-image: none !important;
        padding-right: 1rem !important;
    }

    .password-input.is-invalid {
        padding-right: 45px !important;
    }

    .form-control,
    .form-select,
    input,
    textarea,
    select {
        font-family: 'Inter', sans-serif !important;
        text-transform: none !important;
    }

    body {
        background: #f8f9fa;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 3rem 0;
    }

    .register-card {
        position: relative;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1.3rem;
        box-shadow: 0 .7rem 1.8rem rgba(0, 0, 0, .08);
        overflow: hidden;
    }

    .register-card:hover {
        transform: translateY(-3px);
        transition: .25s ease;
        box-shadow: 0 1rem 2.4rem rgba(0, 0, 0, .10);
    }

    .register-top {
        position: relative;
        padding: 2rem 2rem 1rem;
    }

    .register-accent {
        width: 52px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .register-title {
        font-size: 2rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .4rem;
    }

    .register-subtitle {
        color: #6c757d;
        margin-bottom: 0;
    }

    .register-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff4ef;
        color: #ff6600;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .register-divider {
        height: 1px;
        background: #dee2e6;
        margin: 0 2rem;
    }

    .register-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 700;
        color: #212529;
        margin-bottom: .6rem;
    }

    .help-icon {
        color: #6c757d;
        margin-left: .2rem;
        cursor: pointer;
        touch-action: manipulation;
    }

    .help-icon:hover,
    .help-icon:focus,
    .help-icon:active {
        color: #1e40af;
    }

    .form-control,
    .form-select {
        border-radius: 1rem;
        border: 1px solid #dee2e6;
        min-height: 54px;
        padding: .85rem 1rem;
        transition: .2s ease;
        box-shadow: none !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 .2rem rgba(30, 64, 175, .12) !important;
    }

    .btn-register {
        border: none;
        border-radius: 999px;
        padding: .95rem 1rem;
        background: #1e40af !important;
        color: #fff;
        font-weight: 700;
        font-size: .95rem;
        transition: .22s ease;
        box-shadow: 0 10px 25px rgba(30, 64, 175, .18);
    }

    .btn-register:hover {
        background: #3157d5 !important;
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(30, 64, 175, .28);
    }

    .language-dropdown {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 999;
        transition: .25s ease;
    }

    .language-dropdown.hide-on-scroll {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        pointer-events: none;
    }

    .selected-lang {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 .4rem 1rem rgba(0, 0, 0, .08);
        transition: .2s ease;
    }

    .selected-lang:hover {
        transform: translateY(-2px);
    }

    .selected-lang img {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
    }

    .lang-options {
        display: none;
        position: absolute;
        top: 65px;
        right: 0;
        width: 220px;
        background: #fff;
        border-radius: 1rem;
        border: 1px solid #dee2e6;
        box-shadow: 0 .7rem 1.8rem rgba(0, 0, 0, .10);
        overflow: hidden;
    }

    .lang-options button {
        width: 100%;
        border: none;
        background: transparent;
        padding: .9rem 1rem;
        display: flex;
        align-items: center;
        gap: .8rem;
        transition: .2s ease;
        font-weight: 600;
    }

    .lang-options button:hover {
        background: #f8f9fa;
    }

    .lang-options img {
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }

    .register-input-icon {
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        color: #adb5bd;
    }

    .input-wrapper {
        position: relative;
    }

    .invalid-feedback {
        font-size: .85rem;
    }

    @media(max-width: 575px) {
        @media(max-width: 575px) {

            .register-wrapper {
                align-items: flex-start;
                padding: 6rem 0 3rem;
            }

            .language-dropdown {
                top: 18px;
                right: 18px;
            }

            .selected-lang {
                width: 44px;
                height: 44px;
            }

            .selected-lang img {
                width: 24px;
                height: 24px;
            }

            .register-card {
                border-radius: 1rem;
            }

            .register-top,
            .register-body {
                padding: 1.4rem;
            }

            .register-divider {
                margin: 0 1.4rem;
            }

            .register-title {
                font-size: 1.7rem;
            }
        }

        .password-toggle {
            cursor: pointer;
        }

        .password-toggle:hover {
            color: #1e40af;
        }
    }
</style>

<div class="language-dropdown">

    <div class="selected-lang" onclick="toggleLangDropdown()">

        @if (app()->getLocale() === 'en')
            <img src="{{ asset('img/en.png') }}?v={{ time() }}" alt="EN">
        @elseif (app()->getLocale() === 'fr')
            <img src="{{ asset('img/fr.png') }}?v={{ time() }}" alt="FR">
        @else
            <img src="{{ asset('img/es.png') }}?v={{ time() }}" alt="ES">
        @endif

    </div>

    <div id="langDropdown" class="lang-options">

        <form action="{{ route('change.language') }}" method="POST">

            @csrf

            <button type="submit" name="locale" value="en">
                <img src="{{ asset('img/en.png') }}" alt="en">
                {{ __('navbar.language_english') }}
            </button>

            <button type="submit" name="locale" value="fr">
                <img src="{{ asset('img/fr.png') }}" alt="fr">
                {{ __('navbar.language_french') }}
            </button>

            <button type="submit" name="locale" value="es">
                <img src="{{ asset('img/es.png') }}" alt="es">
                {{ __('navbar.language_spanish') }}
            </button>

        </form>

    </div>

</div>

<div class="register-wrapper">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-7 col-xl-6">

                <div class="register-card">

                    {{-- HEADER --}}
                    <div class="register-top">

                        <div class="register-accent"></div>

                        <div class="d-flex justify-content-between align-items-start gap-3">

                            <div>

                                <h1 class="register-title">
                                    {{ __('register.create_account') }}
                                </h1>

                                <p class="register-subtitle">
                                    {{ __('register.fill_details') }}
                                </p>

                            </div>

                            <div class="register-icon">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>

                        </div>

                    </div>

                    <div class="register-divider"></div>

                    {{-- FORM --}}
                    <div class="register-body">

                        <form method="POST" action="{{ route('register') }}">

                            @csrf

                            {{-- NOMBRE --}}
                            <div class="mb-4">

                                <label for="name" class="form-label">

                                    {{ __('register.full_name') }}

                                    <i class="bi bi-info-circle help-icon" tabindex="0" role="button"
                                        data-bs-toggle="tooltip" title="{{ __('register.full_name_tooltip') }}"></i>

                                </label>

                                <div class="input-wrapper">

                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autofocus>

                                    <i class="fa-solid fa-user register-input-icon"></i>

                                </div>

                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- USERNAME --}}
                            <div class="mb-4">

                                <label for="username" class="form-label">

                                    {{ __('register.username') }}

                                    <i class="bi bi-info-circle help-icon" data-bs-toggle="tooltip"
                                        title="{{ __('register.username_tooltip') }}"></i>

                                </label>

                                <div class="input-wrapper">

                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required>

                                    <i class="fa-solid fa-at register-input-icon"></i>

                                </div>

                                @error('username')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- PAIS --}}
                            <div class="mb-4">

                                <label for="country_id" class="form-label">

                                    {{ __('register.country') }}

                                    <i class="bi bi-info-circle help-icon" data-bs-toggle="tooltip"
                                        title="{{ __('register.country_tooltip') }}"></i>

                                </label>

                                <select id="country_id" class="form-select @error('country_id') is-invalid @enderror"
                                    name="country_id" required>

                                    <option value="">
                                        {{ __('register.country_selected') }}
                                    </option>

                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : '' }}>

                                            {{ $country->name }}

                                        </option>
                                    @endforeach

                                </select>

                                @error('country_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- EMAIL --}}
                            <div class="mb-4">

                                <label for="email" class="form-label">

                                    {{ __('register.email') }}

                                    <i class="bi bi-info-circle help-icon" data-bs-toggle="tooltip"
                                        title="{{ __('register.email_tooltip') }}"></i>

                                </label>

                                <div class="input-wrapper">

                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required>

                                    <i class="fa-solid fa-envelope register-input-icon"></i>

                                </div>

                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>
{{-- TELEFONO --}}
<div class="row">

    {{-- INDICATIVO --}}
    <div class="col-md-5 mb-4">

        <label for="phone_country_code_id" class="form-label">

            {{ __('register.phone_country') }}

            <i class="bi bi-info-circle help-icon"
                data-bs-toggle="tooltip"
                title="{{ __('register.phone_country_tooltip') }}"></i>

        </label>

        <select id="phone_country_code_id"
            class="form-select @error('phone_country_code_id') is-invalid @enderror"
            name="phone_country_code_id">

            <option value="">
                {{ __('register.select_country_code') }}
            </option>

            @foreach ($phoneCountryCodes as $countryCode)

                <option value="{{ $countryCode->id }}"
                    {{ old('phone_country_code_id') == $countryCode->id ? 'selected' : '' }}>

                    {{ $countryCode->country }}
                    ({{ $countryCode->dial_code }})

                </option>

            @endforeach

        </select>

        @error('phone_country_code_id')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

    </div>

    {{-- NUMERO --}}
    <div class="col-md-7 mb-4">

        <label for="phone" class="form-label">

            {{ __('register.phone') }}

            <i class="bi bi-info-circle help-icon"
                data-bs-toggle="tooltip"
                title="{{ __('register.phone_tooltip') }}"></i>

        </label>

        <div class="input-wrapper">

            <input id="phone"
                type="text"
                class="form-control @error('phone') is-invalid @enderror"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="3001234567">

            <i class="fa-solid fa-phone register-input-icon"></i>

        </div>

        @error('phone')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>
                            <div class="row">

                                {{-- PASSWORD --}}
                                <div class="col-md-6 mb-4">

                                    <label for="password" class="form-label">

                                        {{ __('register.password') }}

                                        <i class="bi bi-info-circle help-icon" data-bs-toggle="tooltip"
                                            title="{{ __('register.password_tooltip') }}"></i>

                                    </label>

                                    <div class="input-wrapper">

                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password" required>
                                        <i class="fa-regular fa-eye register-input-icon password-toggle"
                                            onclick="togglePassword('password', this)"></i>

                                    </div>

                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                </div>

                                {{-- CONFIRMAR --}}
                                <div class="col-md-6 mb-4">

                                    <label for="password-confirm" class="form-label">

                                        {{ __('register.confirm') }}

                                        <i class="bi bi-info-circle help-icon" data-bs-toggle="tooltip"
                                            title="{{ __('register.confirm_tooltip') }}"></i>

                                    </label>

                                    <div class="input-wrapper">

                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required>
                                        <i class="fa-regular fa-eye register-input-icon password-toggle"
                                            onclick="togglePassword('password-confirm', this)"></i>
                                    </div>

                                </div>

                            </div>

                            {{-- CODIGO --}}
                            <div class="mb-4">

                                <label for="cod_invitacion" class="form-label">

                                    {{ __('register.invite_code') }}

                                    <i class="bi bi-info-circle help-icon" data-bs-toggle="tooltip"
                                        title="{{ __('register.invite_code_tooltip') }}"></i>

                                </label>

                                <div class="input-wrapper">

                                    <input id="cod_invitacion" type="text"
                                        class="form-control @error('cod_invitacion') is-invalid @enderror"
                                        name="cod_invitacion" value="{{ old('cod_invitacion', request('cod')) }}"
                                        {{ request('cod') ? 'readonly' : '' }}>

                                    <i class="fa-solid fa-gift register-input-icon"></i>

                                </div>

                                @error('cod_invitacion')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                            <input type="hidden" name="torneoId" value="{{ $torneoId }}">

                            {{-- BOTON --}}
                            <div class="d-grid mt-4">

                                <button type="submit" class="btn-register">

                                    <i class="fa-solid fa-user-plus me-1"></i>

                                    {{ __('register.register') }}

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
    .tooltip {
    --bs-tooltip-bg: #ffffff;
    --bs-tooltip-color: #1f2937;
    --bs-tooltip-border-radius: 14px;
    --bs-tooltip-padding-x: 14px;
    --bs-tooltip-padding-y: 10px;
    --bs-tooltip-font-size: 0.82rem;
    --bs-tooltip-opacity: 1;
    filter: drop-shadow(0 10px 24px rgba(30,64,175,.18));
}

.tooltip .tooltip-inner {
    border: 1px solid rgba(30,64,175,.18);
    font-weight: 500;
    line-height: 1.35;
    letter-spacing: .01em;
}

.tooltip.bs-tooltip-top .tooltip-arrow::before {
    border-top-color: #ffffff;
}

.help-icon {
    color: #1e40af;
    font-size: .9rem;
    margin-left: .25rem;
    cursor: pointer;
    transition: .2s ease;
}

.help-icon:hover,
.help-icon:focus,
.help-icon:active {
    color: #ff6600;
    transform: scale(1.08);
}
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleLangDropdown() {

        const dropdown = document.getElementById('langDropdown');

        dropdown.style.display =
            dropdown.style.display === 'block' ?
            'none' :
            'block';

    }

    document.addEventListener('click', function(event) {

        const dropdown = document.getElementById('langDropdown');
        const selector = document.querySelector('.language-dropdown');

        if (selector && !selector.contains(event.target)) {
            dropdown.style.display = 'none';
        }

    });
</script>

<script>
    const languageDropdown = document.querySelector('.language-dropdown');

    function updateLanguageDropdown() {

        if (!languageDropdown) {
            return;
        }

        if (window.scrollY >= 40) {
            languageDropdown.classList.add('hide-on-scroll');
        } else {
            languageDropdown.classList.remove('hide-on-scroll');
        }

    }

    window.addEventListener('load', updateLanguageDropdown);
    window.addEventListener('scroll', updateLanguageDropdown);
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const isMobile = window.matchMedia('(hover: none), (pointer: coarse)').matches;

    tooltipTriggerList.forEach(el => {

        new bootstrap.Tooltip(el, {
            trigger: isMobile ? 'manual' : 'hover focus',
            placement: 'top'
        });

        if (isMobile) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                tooltipTriggerList.forEach(otherEl => {
                    if (otherEl !== el) {
                        bootstrap.Tooltip.getInstance(otherEl)?.hide();
                    }
                });

                bootstrap.Tooltip.getInstance(el)?.toggle();
            });
        }

    });

    if (isMobile) {
        document.addEventListener('click', function () {
            tooltipTriggerList.forEach(el => {
                bootstrap.Tooltip.getInstance(el)?.hide();
            });
        });
    }

});
</script>
<script>
    function togglePassword(inputId, icon) {

        const input = document.getElementById(inputId);

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');

        }

    }
</script>
