<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('privacy.title') }} |{{ __('navbar.name') }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body style="background: #f8fafc;">

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

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">

        <div class="legal-icon mx-auto mb-4 success">
            <i class="bi bi-shield-lock"></i>
        </div>

        <h1 class="legal-title">
            {{ __('privacy.title') }}
        </h1>

        <p class="legal-subtitle">
            {{ __('privacy.updated') }}
        </p>

    </div>

    {{-- CARD --}}
 {{-- CARD --}}
<div class="legal-card">

    @for($i = 1; $i <= 12; $i++)

        <div class="legal-section">

            <div class="legal-accent mb-3"></div>

            <h2 class="legal-section-title">
                {{ __('privacy.section_'.$i.'_title') }}
            </h2>

            <p class="legal-text">
                {{ __('privacy.section_'.$i.'_text') }}
            </p>

        </div>

    @endfor

</div>

    {{-- FOOTER --}}
    <div class="text-center mt-5">

       <a href="{{ url('/') }}" class="legal-button">
    <i class="bi bi-house-door"></i>
    {{ __('privacy.back_home') }}
</a>

        <a href="{{ route('terms') }}"
           class="legal-button secondary">
            <i class="bi bi-shield-check"></i>
            {{ __('footer.terms') }}
        </a>

    </div>

</div>

<style>

    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .legal-icon {
        width: 90px;
        height: 90px;
        border-radius: 2rem;
        background: #eef4ff;
        color: #1e40af;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.6rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
    }

    .legal-icon.success {
        background: #eef8f2;
        color: #ff6600;
    }

    .legal-title {
        font-size: 2.6rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .8rem;
    }

    .legal-subtitle {
        color: #6c757d;
        font-size: 1rem;
    }

    .legal-card {
        background: #fff;
        border-radius: 1.5rem;
        border: 1px solid #dee2e6;
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.06);
        overflow: hidden;
    }

    .legal-section {
        padding: 2rem;
        border-bottom: 1px solid #f1f3f5;
    }

    .legal-section:last-child {
        border-bottom: none;
    }

    .legal-accent {
        width: 55px;
        height: 5px;
        border-radius: 999px;
        background: #ff6600;
    }

    .legal-section-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: 1rem;
    }

    .legal-text {
        color: #6c757d;
        line-height: 1.9;
        font-size: 1rem;
        margin: 0;
    }

    .legal-button {
        display: inline-flex;
        align-items: center;
        gap: .6rem;
        text-decoration: none;
        border: none;
        border-radius: 999px;
        padding: .85rem 1.4rem;
        background: #1e40af;
        color: #fff;
        font-weight: 700;
        transition: .22s ease;
        box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
        margin: .3rem;
    }

    .legal-button:hover {
        background: #3157d5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
    }

    .legal-button.secondary {
        background: #fff4ef;
        color: #ff6600;
        box-shadow: none;
        border: 1px solid #ffd4c2;
    }

    .legal-button.secondary:hover {
        background: #ff6600;
        color: #fff;
    }

    @media(max-width: 768px) {

        .legal-title {
            font-size: 2rem;
        }

        .legal-section {
            padding: 1.5rem;
        }

        .legal-section-title {
            font-size: 1.15rem;
        }

        .legal-text {
            font-size: .95rem;
        }

    }

</style>
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

</body>
</html>