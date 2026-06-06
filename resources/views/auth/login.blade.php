<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') |
        @endif
         {{ __('navbar.name') }}

    </title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{!! asset('estilos.css') !!}">

    @yield('css')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/js/app.js'])

    @livewireStyles

</head>

<body>

    {{-- SELECTOR IDIOMA --}}
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

                    {{ __('login.lang_en') }}

                </button>

                <button type="submit" name="locale" value="fr">

                    <img src="{{ asset('img/fr.png') }}" alt="fr">

                    {{ __('login.lang_fr') }}

                </button>

                <button type="submit" name="locale" value="es">

                    <img src="{{ asset('img/es.png') }}" alt="es">

                    {{ __('login.lang_es') }}

                </button>

            </form>

        </div>

    </div>

    <main class="login-wrapper">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-12 col-md-8 col-lg-10 col-xl-9">

                    <div class="login-card-custom">

                        {{-- PANEL VISUAL --}}
                        <div class="login-visual">

                            <div>

                                <div class="login-accent orange"></div>

                                <span class="login-badge">
                                 {{ __('login.brand') }}
                                </span>

                                <h1>
                                    {{ __('login.welcome') }}
                                </h1>

                                <p class="login-visual-subtitle">
                                   {{ __('login.brand_description') }}
                                </p>

                            </div>

                            <div class="login-visual-footer">

                                <h3>
                                    {{ __('login.compete_title') }}
                                </h3>

                                <p>
                                    {{ __('login.compete_text') }}
                                </p>

                            </div>

                        </div>

                        {{-- FORMULARIO --}}
                        <div class="login-form-side">

                            <div class="login-accent blue"></div>

                            <h2>
                                {{ __('login.title') }}
                            </h2>

                            <p class="login-form-subtitle">
                                {{ __('login.subtitle') }}
                            </p>

                            <form method="POST" action="{{ route('login') }}">

                                @csrf

                                <div class="form-floating mb-3">

                                    <input id="username"
                                           type="text"
                                           class="form-control @error('username') is-invalid @enderror"
                                           name="username"
                                           value="{{ old('email') }}"
                                           required
                                           autocomplete="email"
                                           autofocus
                                           placeholder="{{ __('login.username') }}">

                                    <label for="username">
                                        {{ __('login.username') }}
                                    </label>

                                    @error('username')

                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>

                                    @enderror

                                </div>

                                <div class="form-floating mb-4">

                                    <input id="password"
                                           type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           required
                                           autocomplete="current-password"
                                           placeholder="{{ __('login.password') }}">

                                    <label for="password">
                                        {{ __('login.password') }}
                                    </label>

                                    @error('password')

                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>

                                    @enderror

                                </div>

                                <button type="submit" class="login-button w-100">

                                    {{ __('login.submit') }}

                                </button>

                                <div class="text-center mt-4">

                                    <a href="{{ route('register') }}"
                                       class="login-register-link">

                                        {{ __('login.register') }}

                                    </a>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <style>

        body {
            background: #f8f9fa;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 3rem 0;
        }

        .login-card-custom {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 1rem 2.5rem rgba(0,0,0,.10);
        }

        .login-visual {
            position: relative;
            background: linear-gradient(135deg, #1e40af, #111827);
            color: #fff;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .login-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right,
                rgba(255,255,255,.08),
                transparent 35%);
        }

        .login-visual > * {
            position: relative;
            z-index: 1;
        }

        .login-accent {
            width: 52px;
            height: 4px;
            border-radius: 999px;
            margin-bottom: 1.4rem;
        }

        .login-accent.orange {
            background: #ff6600;
        }

        .login-accent.blue {
            background: #1e40af;
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .5rem .95rem;
            border-radius: 999px;
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.14);
            font-size: .82rem;
            font-weight: 700;
            margin-bottom: 1.4rem;
            backdrop-filter: blur(10px);
        }

        .login-visual h1 {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.05;
            margin-bottom: 1rem;
        }

        .login-visual-subtitle {
            color: rgba(255,255,255,.76);
            font-size: 1rem;
            max-width: 420px;
            margin-bottom: 0;
        }

        .login-visual-footer {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,.12);
        }

        .login-visual-footer h3 {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: .8rem;
            color: #fff;
        }

        .login-visual-footer p {
            color: rgba(255,255,255,.72);
            margin-bottom: 0;
            line-height: 1.7;
        }

        .login-form-side {
            padding: 3rem;
        }

        .login-form-side h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #212529;
            margin-bottom: .5rem;
        }

        .login-form-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 1rem;
            border: 1px solid #dee2e6;
            min-height: 58px;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 .2rem rgba(30,64,175,.12) !important;
        }

        .login-button {
            border: none;
            border-radius: 999px;
            padding: .9rem 1rem;
            background: #1e40af;
            color: #fff;
            font-weight: 800;
            transition: .22s ease;
            box-shadow: 0 8px 20px rgba(30,64,175,.18);
        }

        .login-button:hover {
            background: #3157d5;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(30,64,175,.28);
        }

        .login-register-link {
            color: #1e40af;
            font-weight: 800;
            text-decoration: none;
        }

        .login-register-link:hover {
            color: #3157d5;
        }

        @media(max-width: 991px) {

            .login-card-custom {
                grid-template-columns: 1fr;
            }

            .login-visual {
                padding: 2rem;
            }

            .login-form-side {
                padding: 2rem;
            }

        }

      @media(max-width: 575px) {

    body {
        background: #f8f9fa;
    }

    .login-wrapper {
        min-height: 100vh;
        padding: 5.5rem 1rem 2rem;
        align-items: flex-start;
    }

    .login-card-custom {
        display: block;
        border-radius: 1.2rem;
        box-shadow: 0 .7rem 1.8rem rgba(0,0,0,.08);
    }

    .login-visual {
        display: none;
    }

    .login-form-side {
        padding: 1.6rem;
    }

    .login-accent.blue {
        margin-left: auto;
        margin-right: auto;
    }

    .login-form-side h2 {
        text-align: center;
        font-size: 1.9rem;
        margin-bottom: .4rem;
    }

    .login-form-subtitle {
        text-align: center;
        font-size: .95rem;
        margin-bottom: 1.6rem;
    }

    .form-control {
        min-height: 54px;
        border-radius: .9rem;
    }

    .login-button {
        padding: .85rem 1rem;
    }

}

    </style>

</body>

<script>

    function toggleLangDropdown() {

        const dropdown = document.getElementById('langDropdown');

        dropdown.style.display =
            dropdown.style.display === 'block'
            ? 'none'
            : 'block';

    }

    document.addEventListener('click', function(event) {

        const dropdown = document.getElementById('langDropdown');

        const selector = document.querySelector('.language-dropdown');

        if (!selector.contains(event.target)) {
            dropdown.style.display = 'none';
        }

    });

</script>

</html>