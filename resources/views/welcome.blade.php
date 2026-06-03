<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ __('landing.pageTitle') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{!! asset('estilos.css') !!}">
    <link rel="stylesheet" href="{!! asset('style.css') !!}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @livewireStyles
</head>
<a href="https://wa.me/0000000000" target="_blank" class="whatsapp-float" aria-label="WhatsApp">

    <i class="bi bi-whatsapp"></i>

</a>

<body>

    @php
        $countryCode = session('country_code', 'US');

        $plans = \App\Models\Plan::with([
            'prices' => function ($query) use ($countryCode) {
                $query->where('country_code', $countryCode)->where('active', true);
            },
        ])->get();

        function landingPriceFormat($price)
        {
            if (!$price) {
                return null;
            }

            return $price->currency . ' ' . number_format($price->amount / 100, 2);
        }
    @endphp

    {{-- NAVBAR --}}
    <nav id="navbar" class="navbar navbar-expand-lg fixed-top landing-navbar">
        <div class="container">

            <a class="navbar-brand" href="#inicio">
                {{ __('landing.brand') }}
            </a>
{{-- SELECTOR MOVIL --}}
<div class="mobile-language-wrapper d-lg-none">

    <div class="language-dropdown2 mobile-language-clone">

       <div class="selected-lang" onclick="toggleLangDropdownMobile(event)">
            @if (app()->getLocale() === 'en')
                <img src="{{ asset('img/en.png') }}?v={{ time() }}" alt="EN">
            @elseif (app()->getLocale() === 'fr')
                <img src="{{ asset('img/fr.png') }}?v={{ time() }}" alt="FR">
            @else
                <img src="{{ asset('img/es.png') }}?v={{ time() }}" alt="ES">
            @endif
        </div>

        <div id="mobileLangDropdown" class="lang-options mobile-lang-options">
            <form action="{{ route('change.language') }}" method="POST">
                @csrf

                <button type="submit" name="locale" value="en">
                    <img src="{{ asset('img/en.png') }}" alt="en">
                    {{ __('landing.language_english') }}
                </button>

                <button type="submit" name="locale" value="fr">
                    <img src="{{ asset('img/fr.png') }}" alt="fr">
                    {{ __('landing.language_french') }}
                </button>

                <button type="submit" name="locale" value="es">
                    <img src="{{ asset('img/es.png') }}" alt="es">
                    {{ __('landing.language_spanish') }}
                </button>

            </form>
        </div>

    </div>

</div>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="bi bi-chevron-down text-white fs-3"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

                <ul class="navbar-nav align-items-lg-center text-end gap-lg-3">

                    <li class="nav-item">
                        <a class="nav-link" href="#inicio">{{ __('landing.home') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#como-funciona">{{ __('landing.how_it_works') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#grupo-oficial">{{ __('landing.official_group') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#planes">{{ __('landing.plans') }}</a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#contacto">{{ __('landing.contact') }}</a>
                    </li> --}}

                    <li class="nav-item mt-3 mt-lg-0">
                        <a href="{{ url('/login') }}" class="landing-login-link">
                            {{ __('landing.sign_in') }}
                        </a>
                    </li>

                    <li class="nav-item mt-3 mt-lg-0">
                        <a href="{{ url('/register') }}" class="landing-button">
                            {{ __('landing.register') }}
                        </a>
                    </li>

                    {{-- TRADUCTOR --}}
                    <li class="nav-item d-flex justify-content-end align-items-center ms-lg-2 mt-3 mt-lg-0">
                       <div class="language-dropdown2 desktop-language-selector">

                       <div class="selected-lang" onclick="toggleLangDropdown(event)">
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
                                        {{ __('landing.language_english') }}
                                    </button>

                                    <button type="submit" name="locale" value="fr">
                                        <img src="{{ asset('img/fr.png') }}" alt="fr">
                                        {{ __('landing.language_french') }}
                                    </button>

                                    <button type="submit" name="locale" value="es">
                                        <img src="{{ asset('img/es.png') }}" alt="es">
                                        {{ __('landing.language_spanish') }}
                                    </button>

                                </form>
                            </div>

                        </div>
                    </li>

                </ul>

            </div>
        </div>
    </nav>

    {{-- HERO DESKTOP --}}
    <section id="inicio" class="landing-hero-desktop d-lg-flex">

       <video class="landing-video hero-desktop-video" autoplay muted loop playsinline>
            <source src="{{ asset('video/fondo.mp4') }}" type="video/mp4">
        </video>

        <div class="landing-hero-overlay"></div>

        <div class="container position-relative">

            <div class="landing-hero-content">

                <div class="landing-accent orange"></div>



                <h1>
                    {{ __('landing.hero_title') }} <span class="hero-brand-highlight">{{ __('landing.brand') }}</span>
                </h1>

                <p>
                    {{ __('landing.hero_subtitle') }}
                </p>

                <div class="d-flex gap-3 flex-wrap mt-4">

                    <a href="{{ url('/register') }}" class="landing-button">
                        {{ __('landing.register') }}
                    </a>

                    <a href="#grupo-oficial" class="landing-outline-button">
                        {{ __('landing.join_sponsored_group') }}
                    </a>

                </div>

            </div>

        </div>

    </section>

    {{-- HERO MOBILE --}}
    {{-- 
    <section class="landing-hero-mobile d-lg-none">

        <div class="container">

            <div class="landing-mobile-content text-center">

                <div class="landing-accent orange mx-auto"></div>

                <span class="landing-badge mx-auto">
                    {{ __('landing.brand') }}
                </span>

                <h1>
                    {{ __('landing.mobile_title') }}
                </h1>

                <p>
                    {{ __('landing.mobile_subtitle') }}
                </p>

                <div class="mobile-highlight-card mt-4">

                    <div class="mobile-highlight-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>

                    <h5>
                        {{ __('landing.mobile_card_title') }}
                    </h5>

                    <p>
                        {{ __('landing.mobile_card_text') }}
                    </p>

                </div>

                <div class="d-grid gap-3 mt-4">

                    <a href="{{ url('/register') }}" class="landing-button">
                        {{ __('landing.register') }}
                    </a>

                    <a href="{{ url('/login') }}" class="landing-outline-button">
                        {{ __('landing.sign_in') }}
                    </a>

                </div>

            </div>

        </div>

    </section> --}}

    {{-- COMO FUNCIONA --}}
    <section id="como-funciona" class="landing-section">

        <div class="container">

            <div class="text-center mb-5">
                <h2 class="landing-section-title">
                    {{ __('landing.how_it_works_title') }}
                </h2>

                <p class="landing-section-subtitle">
                    {{ __('landing.how_it_works_text') }}
                </p>
            </div>

            <div class="row g-4">

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="landing-card h-100">
                        <div class="landing-card-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h5>{{ __('landing.step_1_title') }}</h5>
                        <p>{{ __('landing.step_1_text') }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="landing-card h-100">
                        <div class="landing-card-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h5>{{ __('landing.step_2_title') }}</h5>
                        <p>{{ __('landing.step_2_text') }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="landing-card h-100">
                        <div class="landing-card-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h5>{{ __('landing.step_3_title') }}</h5>
                        <p>{{ __('landing.step_3_text') }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="landing-card h-100">
                        <div class="landing-card-icon">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                        <h5>{{ __('landing.step_4_title') }}</h5>
                        <p>{{ __('landing.step_4_text') }}</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

   {{-- GRUPO PATROCINADO --}}
<section id="grupo-oficial" class="landing-section bg-light">

    <div class="container">

        <div class="sponsor-showcase-card">

            <div class="row align-items-center g-5 sponsor-mobile-flow">

                <div class="col-lg-7">

                    <div class="landing-accent blue"></div>

                    <span class="official-badge">
                        {{ __('landing.sponsored_group_badge') }}
                    </span>

                    <h2>
                        {{ __('landing.sponsored_group_title') }}
                    </h2>

                    <p class="sponsor-main-text">
                        {{ __('landing.sponsored_group_text') }}
                    </p>

                    <div class="sponsor-country-strip">
                        <div class="country-avatars">

    <img src="https://flagcdn.com/w80/co.png" alt="Colombia">
    <img src="https://flagcdn.com/w80/fr.png" alt="France">
    <img src="https://flagcdn.com/w80/ar.png" alt="Argentina">
    <img src="https://flagcdn.com/w80/br.png" alt="Brazil">
    <img src="https://flagcdn.com/w80/es.png" alt="Spain">

</div>

    <strong>
        {{ __('landing.sponsored_group_country_question') }}
    </strong>
                    </div>

                    <div class="official-features">

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            {{ __('landing.sponsored_group_feature_1') }}
                        </div>

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            {{ __('landing.sponsored_group_feature_2') }}
                        </div>

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            {{ __('landing.sponsored_group_feature_3') }}
                        </div>

                    </div>
<div class="mobile-sponsor-box d-lg-none">

    <div class="mobile-sponsor-divider"></div>

    <span class="mobile-sponsor-badge">
        {{ __('landing.sponsored_group_ticket_label') }}
    </span>

    <h4>
        {{ __('landing.sponsored_group_cta_title') }}
    </h4>

    <p>
        {{ __('landing.sponsored_group_cta_text') }}
    </p>

    <a href="{{ url('/register') }}"
       class="landing-button w-100">
        {{ __('landing.join_sponsored_group') }}
    </a>

</div>
                </div>

                <div class="col-lg-5 desktop-sponsor-card">

                   <div class="sponsor-invite-card">

    <div class="invite-card-header">

        <div>
            <span>{{ __('landing.sponsored_group_ticket_label') }}</span>
            <h4>{{ __('landing.sponsored_group_cta_title') }}</h4>
        </div>

        <div class="invite-card-icon">
            <i class="bi bi-trophy-fill"></i>
        </div>

    </div>

    <p class="invite-card-text">
        {{ __('landing.sponsored_group_cta_text') }}
    </p>

    <div class="invite-card-match">

        <div>
            <small>{{ __('landing.main_tournament') }}</small>
            <strong>{{ __('landing.world_cup') }}</strong>
        </div>

        <span class="invite-vs">2026</span>

    </div>

    <div class="invite-card-benefits">

        <div>
            <i class="bi bi-check-circle-fill"></i>
            {{ __('landing.invite_benefit_1') }}
        </div>

        <div>
            <i class="bi bi-check-circle-fill"></i>
            {{ __('landing.invite_benefit_2') }}
        </div>

    </div>

    <a href="{{ url('/register') }}" class="landing-button w-100">
        {{ __('landing.join_sponsored_group') }}
    </a>

    <div class="invite-card-note">
        <i class="bi bi-info-circle-fill"></i>
        {{ __('landing.sponsored_group_note') }}
    </div>

</div>

                </div>

            </div>

        </div>

    </div>

</section>

    {{-- CREAR GRUPO PRIVADO --}}
    <section class="landing-section">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="landing-section-title">
                    {{ __('landing.private_group_title') }}
                </h2>

                <p class="landing-section-subtitle">
                    {{ __('landing.private_group_text') }}
                </p>

            </div>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="landing-card h-100">
                        <div class="landing-card-icon blue">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <h5>{{ __('landing.custom_rules_title') }}</h5>
                        <p>{{ __('landing.custom_rules_text') }}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="landing-card h-100">
                        <div class="landing-card-icon blue">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h5>{{ __('landing.private_access_title') }}</h5>
                        <p>{{ __('landing.private_access_text') }}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="landing-card h-100">
                        <div class="landing-card-icon blue">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h5>{{ __('landing.auto_ranking_title') }}</h5>
                        <p>{{ __('landing.auto_ranking_text') }}</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

    {{-- PLANES --}}
    <section id="planes" class="landing-section bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="landing-section-title">
                    {{ __('landing.plans_title') }}
                </h2>

                <p class="landing-section-subtitle">
                    {{ __('landing.plans_subtitle') }}
                </p>

            </div>

            <div class="row g-4 justify-content-center">

                @foreach ($plans as $plan)
                    @php
                        $price = $plan->prices->first();
                        $formattedPrice = landingPriceFormat($price);
                        $isRecommended = $plan->nombre === 'professional';
                    @endphp

                    <div class="col-12 col-md-6 col-xl-4">

                        <div class="plan-card h-100 {{ $isRecommended ? 'featured' : '' }}">

                            @if ($isRecommended)
                            @endif

                            <div class="plan-accent"></div>

                            <div class="d-flex justify-content-between align-items-start gap-3 plan-header">

                                <div class="plan-title-wrap">
                                    <h3 class="plan-name">
                                        {{ __('landing.plans_items.' . $plan->nombre . '.name') }}
                                    </h3>

                                    <p class="plan-description">
                                        {{ __('landing.plans_items.' . $plan->nombre . '.description') }}
                                    </p>
                                </div>

                                <div class="plan-icon {{ $isRecommended ? 'success' : 'warning' }}">
                                    @if ($plan->nombre === 'amateur')
                                        <i class="bi bi-person-fill"></i>
                                    @elseif($plan->nombre === 'professional')
                                        <i class="bi bi-briefcase-fill"></i>
                                    @else
                                        <i class="bi bi-stars"></i>
                                    @endif
                                </div>

                            </div>

                            <div class="plan-divider"></div>

                            <div class="plan-price-box">

                                <div class="plan-price">
                                    {{ $formattedPrice ?? __('landing.price_not_available') }}
                                </div>

                                <small>
                                    {{ __('landing.plan_payment_note') }}
                                </small>

                            </div>

                            <div class="d-flex flex-column gap-3 my-4">

                                <div class="plan-feature">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>{{ __('landing.worldcup_access') }}</span>
                                </div>

                                <div class="plan-feature">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>{{ __('landing.max_users', ['count' => $plan->max_usuarios_por_grupo]) }}</span>
                                </div>

                                <div class="plan-feature">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>{{ __('landing.plans_items.' . $plan->nombre . '.note') }}</span>
                                </div>

                            </div>

                            <a href="{{ url('/register') }}" class="plan-button">
                                {{ __('landing.buy_plan') }}
                            </a>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </section>

    {{-- FAQ --}}
    <section id="faq" class="landing-section">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="landing-section-title">
                    {{ __('landing.faq_title') }}
                </h2>

                <p class="landing-section-subtitle">
                    {{ __('landing.faq_subtitle') }}
                </p>

            </div>

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <div class="accordion landing-accordion" id="faqBox">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#q1">
                                    {{ __('landing.faq_1_question') }}
                                </button>
                            </h2>

                            <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#faqBox">
                                <div class="accordion-body">
                                    {{ __('landing.faq_1_answer') }}
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#q2">
                                    {{ __('landing.faq_2_question') }}
                                </button>
                            </h2>

                            <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqBox">
                                <div class="accordion-body">
                                    {{ __('landing.faq_2_answer') }}
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#q3">
                                    {{ __('landing.faq_3_question') }}
                                </button>
                            </h2>

                            <div id="q3" class="accordion-collapse collapse" data-bs-parent="#faqBox">
                                <div class="accordion-body">
                                    {{ __('landing.faq_3_answer') }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- FOOTER --}}
    <footer class="landing-footer">

        <div class="container text-center">

            <h5>
                {{ __('landing.brand') }}
            </h5>

            <p>
                © {{ date('Y') }} {{ __('landing.footer_rights') }}
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">

                <a href="{{ route('terms') }}" class="hover:text-indigo-600 transition">
                    {{ __('landing.terms') }}
                </a>

              <a href="{{ route('privacy') }}" class="hover:text-indigo-600 transition">
                    {{ __('landing.privacy') }}
                </a>

            </div>

        </div>

    </footer>

    <style>
        html,
        body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8f9fa;
        }

        img,
        video {
            max-width: 100%;
        }

        .container {
            max-width: 1240px;
        }

        .landing-navbar {
            background: rgba(17, 24, 39, .82);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            padding: .9rem 0;
        }

        .landing-navbar.black {
            background: rgba(17, 24, 39, .96);
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: 800;
            font-size: 1.35rem;
            white-space: normal;
        }

        .navbar-nav {
            gap: .35rem !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, .78) !important;
            font-weight: 700;
            font-size: clamp(.78rem, .82vw, .95rem);
            padding: .45rem .55rem !important;
            white-space: nowrap;
            border-radius: .7rem;
            transition: .2s ease;
        }

        .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .07);
        }

        .landing-button,
        .landing-login-link,
        .landing-outline-button,
        .plan-button {
            border-radius: 999px;
            padding: .75rem 1.2rem;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .22s ease;
            text-align: center;
            max-width: 100%;
        }

        .landing-button,
        .plan-button {
            background: #1e40af;
            color: #fff;
            border: none;
            box-shadow: 0 8px 20px rgba(30, 64, 175, .18);
        }

        .landing-button:hover,
        .plan-button:hover {
            background: #3157d5;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(30, 64, 175, .28);
        }

        .landing-login-link,
        .landing-outline-button {
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .18);
        }

        .landing-login-link:hover,
        .landing-outline-button:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff;
        }

        .landing-hero-desktop {
            position: relative;
            height: 100vh;
            align-items: center;
            overflow: hidden;
            color: #fff;
        }

        .landing-video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .landing-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(17, 24, 39, .88), rgba(30, 64, 175, .72));
        }

        .landing-hero-content {
            max-width: 760px;
            background: transparent;
            border: none;
            padding: 0;
            box-shadow: none;
        }

        .landing-accent {
            width: 52px;
            height: 4px;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        .landing-accent.orange {
            background: #ff6600;
        }

        .landing-accent.blue {
            background: #1e40af;
        }

        .landing-badge {
            display: inline-flex;
            width: fit-content;
            max-width: 100%;
            padding: .55rem 1rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .14);
            font-weight: 800;
            color: #fff;
            margin-bottom: 1.5rem;
            word-break: break-word;
        }

        .landing-hero-content h1 {
            font-size: clamp(2.8rem, 5vw, 4rem);
            line-height: 1.05;
            font-weight: 800;
            margin-bottom: 1.4rem;
            max-width: 760px;
        }

        .landing-hero-content p {
            color: rgba(255, 255, 255, .82);
            font-size: 1.08rem;
            margin-bottom: 0;
            max-width: 650px;
        }

        .landing-hero-mobile {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #1e40af, #111827);
            padding: 6rem 0 3rem;
            color: #fff;
            overflow: hidden;
        }

        .landing-mobile-content {
            width: 100%;
            max-width: 100%;
            padding: 0 .25rem;
        }

        .landing-mobile-content h1 {
            font-size: 2rem;
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .landing-mobile-content p {
            color: rgba(255, 255, 255, .76);
        }

        .mobile-highlight-card {
            width: 100%;
            max-width: 100%;
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 1.2rem;
            padding: 1.3rem;
        }

        .mobile-highlight-icon {
            width: 52px;
            height: 52px;
            border-radius: 1rem;
            background: rgba(255, 255, 255, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin: 0 auto 1rem;
        }

        .landing-section {
            padding: 5rem 0;
        }

        .landing-section-title {
            font-size: 2.4rem;
            font-weight: 800;
            color: #212529;
        }

        .landing-section-subtitle {
            color: #6c757d;
            max-width: 720px;
            margin: 0 auto;
        }

        .landing-card,
        .official-group-card,
        .plan-card,
        .contact-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 1.2rem;
            padding: 1.8rem;
            box-shadow: 0 .5rem 1.2rem rgba(0, 0, 0, .06);
            transition: .22s ease;
            width: 100%;
            max-width: 100%;
        }

        .landing-card:hover,
        .official-group-card:hover,
        .plan-card:hover,
        .contact-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 .9rem 2rem rgba(0, 0, 0, .10);
        }

        .landing-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            background: #fff4ef;
            color: #ff6600;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.2rem;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .landing-card-icon.blue {
            background: #eef4ff;
            color: #1e40af;
        }

        .landing-card h5 {
            font-weight: 800;
            color: #212529;
            margin-bottom: .7rem;
        }

        .landing-card p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .official-group-card h2 {
            font-weight: 800;
            font-size: 2.2rem;
            color: #212529;
        }

        .official-group-card p {
            color: #6c757d;
        }

        .official-badge {
            display: inline-flex;
            max-width: 100%;
            padding: .45rem .85rem;
            border-radius: 999px;
            background: #fff4ef;
            color: #ff6600;
            border: 1px solid #ffd4c2;
            font-weight: 800;
            font-size: .85rem;
            margin-bottom: 1rem;
            word-break: break-word;
        }

        .official-features {
            display: flex;
            flex-direction: column;
            gap: .8rem;
            margin-top: 1.5rem;
        }

        .official-features div {
            display: flex;
            align-items: flex-start;
            gap: .7rem;
            font-weight: 600;
            color: #495057;
        }

        .official-features i {
            color: #1e40af;
            flex-shrink: 0;
            margin-top: .15rem;
        }

        .plan-card {
            position: relative;
            height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .plan-card.featured {
            border: 2px solid #1e40af;
        }

        .plan-recommended {
            position: static;
            align-self: flex-start;
            background: #fff4ef;
            color: #ff6600;
            border: 1px solid #ffd4c2;
            border-radius: 999px;
            padding: .45rem .85rem;
            font-weight: 800;
            font-size: .78rem;
            margin-bottom: 1rem;
            max-width: 100%;
            white-space: normal;
        }

        .plan-accent {
            width: 46px;
            height: 4px;
            border-radius: 999px;
            background: #1e40af;
            margin-bottom: 1rem;
            flex-shrink: 0;
        }

        .plan-header {
            min-width: 0;
        }

        .plan-title-wrap {
            min-width: 0;
            flex: 1;
        }

        .plan-name {
            font-size: 1.45rem;
            font-weight: 800;
            color: #212529;
            margin-bottom: .45rem;
            word-break: break-word;
        }

        .plan-description {
            color: #6c757d;
            margin-bottom: 0;
            overflow-wrap: anywhere;
        }

        .plan-icon {
            width: 48px;
            height: 48px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
        }

        .plan-icon.warning {
            background: #fff4ef;
            color: #ff6600;
        }

        .plan-icon.success {
            background: #eef8f2;
            color: #198754;
        }

        .plan-divider {
            height: 1px;
            background: #dee2e6;
            margin: 1.4rem 0;
            flex-shrink: 0;
        }

        .plan-price-box {
            width: 100%;
            max-width: 100%;
            min-width: 0;
        }

        .plan-price {
            font-size: clamp(1.6rem, 5vw, 2.1rem);
            font-weight: 800;
            color: #1e40af;
            line-height: 1.15;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .plan-price-box small {
            display: block;
            color: #6c757d;
            margin-top: .4rem;
        }

        .plan-feature {
            display: flex;
            align-items: flex-start;
            gap: .7rem;
            font-weight: 600;
            color: #495057;
            min-width: 0;
        }

        .plan-feature i {
            color: #1e40af;
            flex-shrink: 0;
            margin-top: .15rem;
        }

        .plan-feature span {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .plan-button {
            width: 100%;
            margin-top: auto;
        }

        .landing-accordion .accordion-item {
            border: 1px solid #dee2e6;
            border-radius: 1rem;
            overflow: hidden;
            margin-bottom: 1rem;
            box-shadow: 0 .35rem .9rem rgba(0, 0, 0, .04);
        }

        .landing-accordion .accordion-button {
            font-weight: 800;
            box-shadow: none;
        }

        .landing-accordion .accordion-button:not(.collapsed) {
            background: #eef4ff;
            color: #1e40af;
        }

        .landing-input {
            border-radius: 1rem;
            border: 1px solid #dee2e6;
            min-height: 50px;
            box-shadow: none;
        }

        .landing-input:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 .2rem rgba(30, 64, 175, .12);
        }

        .landing-footer {
            background: #111827;
            color: rgba(255, 255, 255, .72);
            padding: 2.5rem 0;
        }

        .landing-footer h5 {
            color: #fff;
            font-weight: 800;
        }

        .landing-footer a {
            color: rgba(255, 255, 255, .76);
            text-decoration: none;
            font-weight: 700;
        }

        .landing-footer a:hover {
            color: #fff;
        }

        .hero-brand-highlight {
            color: #ff6600;
            display: inline-block;
            position: relative;
            text-shadow: 0 0 18px rgba(255, 102, 0, .35);
        }

        .hero-brand-highlight::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: .12em;
            width: 100%;
            height: .22em;
            background: rgba(255, 102, 0, .18);
            border-radius: 999px;
            z-index: -1;
        }
.sponsor-showcase-card {
    position: relative;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 1.6rem;
    padding: 2.4rem;
    box-shadow: 0 .8rem 2rem rgba(0,0,0,.07);
    overflow: hidden;
}


.sponsor-invite-card {
    position: relative;
    z-index: 2;
    background:
        linear-gradient(#ffffff, #ffffff) padding-box,
        linear-gradient(135deg, rgba(30,64,175,.35), rgba(255,102,0,.35)) border-box;
    border: 1px solid transparent;
    border-radius: 1.5rem;
    padding: 1.6rem;
    box-shadow: 0 1rem 2rem rgba(0,0,0,.08);
}

.invite-card-header {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.invite-card-header span {
    display: inline-flex;
    font-size: .75rem;
    font-weight: 800;
    color: #ff6600;
    background: #fff4ef;
    border: 1px solid #ffd4c2;
    border-radius: 999px;
    padding: .35rem .7rem;
    margin-bottom: .75rem;
}

.invite-card-header h4 {
    font-weight: 800;
    color: #212529;
    margin: 0;
    line-height: 1.15;
}

.invite-card-icon {
    width: 58px;
    height: 58px;
    border-radius: 1rem;
    background: #eef4ff;
    color: #1e40af;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.invite-card-text {
    color: #6c757d;
    margin-bottom: 1.2rem;
}

.invite-card-match {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 1.1rem;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.invite-card-match small {
    display: block;
    color: #6c757d;
    font-size: .78rem;
    font-weight: 700;
}

.invite-card-match strong {
    color: #212529;
    font-weight: 800;
}

.invite-vs {
    background: #1e40af;
    color: #fff;
    border-radius: 999px;
    padding: .45rem .75rem;
    font-weight: 800;
    font-size: .85rem;
}

.invite-card-benefits {
    display: flex;
    flex-direction: column;
    gap: .65rem;
    margin-bottom: 1.2rem;
}

.invite-card-benefits div {
    display: flex;
    gap: .55rem;
    color: #495057;
    font-weight: 700;
    font-size: .93rem;
}

.invite-card-benefits i {
    color: #1e40af;
    flex-shrink: 0;
    margin-top: .12rem;
}

.invite-card-note {
    display: flex;
    gap: .55rem;
    margin-top: 1rem;
    color: #6c757d;
    font-size: .82rem;
    font-weight: 600;
}

.invite-card-note i {
    color: #ff6600;
    margin-top: .12rem;
    flex-shrink: 0;
} 

.sponsor-showcase-card h2 {
    font-weight: 800;
    font-size: 2.35rem;
    color: #212529;
    margin-bottom: 1rem;
}

.sponsor-main-text {
    color: #6c757d;
    font-size: 1.02rem;
    max-width: 660px;
}

.sponsor-country-strip {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .55rem;
    margin-top: 1.4rem;
    padding: .9rem 1rem;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 1rem;
}

.sponsor-country-strip span {
    font-size: 1.35rem;
}

.sponsor-country-strip strong {
    color: #1e40af;
    font-weight: 800;
    margin-left: .35rem;
}

.sponsor-ticket-card {
    position: relative;
    z-index: 2;
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 1.4rem;
    overflow: hidden;
    box-shadow: 0 1rem 2rem rgba(0,0,0,.08);
}

.sponsor-ticket-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #111827;
    color: #fff;
    padding: .9rem 1.2rem;
    font-weight: 800;
    font-size: .85rem;
    letter-spacing: .04em;
    text-transform: uppercase;
}

.sponsor-ticket-top i {
    color: #ff6600;
}

.sponsor-ticket-body {
    padding: 1.8rem;
    text-align: center;
}

.sponsor-trophy {
    width: 64px;
    height: 64px;
    border-radius: 1.1rem;
    background: #fff4ef;
    color: #ff6600;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    margin: 0 auto 1rem;
}

.sponsor-ticket-body h4 {
    font-weight: 800;
    color: #212529;
    margin-bottom: .7rem;
}

.sponsor-ticket-body p {
    color: #6c757d;
    margin-bottom: 1.4rem;
}

.sponsor-ticket-footer {
    display: flex;
    align-items: flex-start;
    gap: .55rem;
    background: #f8f9fa;
    border-top: 1px dashed #dee2e6;
    padding: 1rem 1.2rem;
    color: #6c757d;
    font-size: .88rem;
    font-weight: 600;
}

.sponsor-ticket-footer i {
    color: #1e40af;
    margin-top: .15rem;
}
.country-avatars {
    display: flex;
    align-items: center;
}

.country-avatars img {
    width: 42px;
    height: 42px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 .35rem .8rem rgba(0,0,0,.12);
    margin-left: -10px;
    background: #fff;
    transition: .22s ease;
}

.country-avatars img:first-child {
    margin-left: 0;
}

.country-avatars img:hover {
    transform: translateY(-3px) scale(1.06);
    z-index: 2;
}
        @media(max-width: 991px) {
            .navbar-collapse {
                width: 100%;
                max-width: 100%;
                background: rgba(17, 24, 39, .96);
                margin-top: 1rem;
                padding: 1rem;
                border-radius: 1rem;
            }

            .navbar-nav,
            .nav-item {
                width: 100%;
            }

            .landing-navbar .landing-button,
            .landing-navbar .landing-login-link {
                width: 100%;
            }

            .language-dropdown2 {
                max-width: 100%;
            }
        }

        @media(max-width: 575px) {
            .landing-section {
                padding: 4rem 0;
            }

            .landing-section-title {
                font-size: 2rem;
            }

            .official-group-card h2 {
                font-size: 1.8rem;
            }

            .plan-card,
            .landing-card,
            .official-group-card,
            .contact-card {
                padding: 1.35rem;
            }

            .plan-header {
                gap: .8rem !important;
            }

            .plan-icon {
                width: 44px;
                height: 44px;
            }

            .landing-badge {
                justify-content: center;
                text-align: center;
            }
        }

        .hero-stats {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .hero-stat-card {
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 1rem;
            padding: 1rem 1.2rem;
            min-width: 140px;
            backdrop-filter: blur(8px);
        }

        .hero-stat-card strong {
            display: block;
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .hero-stat-card span {
            color: rgba(255, 255, 255, .72);
            font-size: .85rem;
            font-weight: 600;
        }

        .hero-mobile-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .hero-mobile-stat {
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 1rem;
            padding: 1rem;
        }

        .hero-mobile-stat strong {
            display: block;
            font-size: 1.4rem;
            color: #fff;
            font-weight: 800;
        }

        .hero-mobile-stat span {
            color: rgba(255, 255, 255, .72);
            font-size: .82rem;
            font-weight: 600;
        }

        .worldcup-countdown-section {
            background: #f8f9fa;
            padding: 4rem 0 0;
        }

        .worldcup-countdown-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 .5rem 1.2rem rgba(0, 0, 0, .06);
        }

        .countdown-badge {
            display: inline-flex;
            padding: .45rem .85rem;
            border-radius: 999px;
            background: #fff4ef;
            color: #ff6600;
            border: 1px solid #ffd4c2;
            font-weight: 800;
            font-size: .85rem;
            margin-bottom: 1rem;
        }

        .worldcup-countdown-card h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #212529;
        }

        .worldcup-countdown-card p {
            color: #6c757d;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .countdown-item {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 1rem;
            padding: 1.2rem;
            text-align: center;
        }

        .countdown-item strong {
            display: block;
            font-size: 2rem;
            font-weight: 800;
            color: #1e40af;
            line-height: 1;
        }

        .countdown-item span {
            display: block;
            margin-top: .5rem;
            color: #6c757d;
            font-size: .85rem;
            font-weight: 700;
        }

        .whatsapp-float {
            position: fixed;
            right: 24px;
            bottom: 24px;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #25D366 !important;
            color: #FFFFFF !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.9rem;
            text-decoration: none;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(37, 211, 102, .35);
            transition: .22s ease;
        }

        .whatsapp-float i {
            color: #FFFFFF !important;
        }

        .whatsapp-float:hover {
            background: #1DA851 !important;
            color: #FFFFFF !important;
            transform: translateY(-4px);
        }

        .whatsapp-float:hover i {
            color: #FFFFFF !important;
        }

        @media(max-width: 575px) {

            .countdown-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .countdown-item strong {
                font-size: 1.6rem;
            }

            .hero-stat-card {
                width: 100%;
            }

            .whatsapp-float {
                width: 54px;
                height: 54px;
                font-size: 1.6rem;
                right: 18px;
                bottom: 18px;
            }
        }
       .mobile-sponsor-box{
    margin-top:1.7rem;
    padding-top:1.5rem;
}

.mobile-sponsor-divider{
    width:100%;
    height:1px;
    background:linear-gradient(
        to right,
        transparent,
        #dee2e6,
        transparent
    );
    margin-bottom:1.5rem;
}

.mobile-sponsor-badge{
    display:inline-flex;
    background:#fff4ef;
    color:#ff6600;
    border:1px solid #ffd7c3;
    padding:.45rem .85rem;
    border-radius:999px;
    font-size:.78rem;
    font-weight:800;
    margin-bottom:1rem;
}

.mobile-sponsor-box h4{
    font-size:1.3rem;
    font-weight:800;
    margin-bottom:.8rem;
    color:#111827;
}

.mobile-sponsor-box p{
    color:#6b7280;
    margin-bottom:1.2rem;
    line-height:1.5;
}
@media(max-width: 991px) {

    .landing-hero-desktop {
        min-height: 100vh;
        padding: 7rem 0 3rem;
        align-items: center;
    }

    .landing-hero-content {
        max-width: 100%;
        text-align: center;
    }

    .landing-hero-content .landing-accent {
        margin-left: auto;
        margin-right: auto;
    }

    .landing-badge {
        margin-left: auto;
        margin-right: auto;
        justify-content: center;
    }

    .landing-hero-content h1 {
        font-size: 2.35rem;
        line-height: 1.08;
    }

    .landing-hero-content p {
        font-size: .98rem;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .landing-hero-content .d-flex {
        justify-content: center;
    }

    .landing-hero-content .landing-button,
    .landing-hero-content .landing-outline-button {
        width: 100%;
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .75rem;
        margin-top: 1.5rem;
    }

    .hero-stat-card {
        min-width: 0;
        padding: .85rem .6rem;
        text-align: center;
    }

    .hero-stat-card strong {
        font-size: 1.25rem;
    }

    .hero-stat-card span {
        font-size: .72rem;
    }
}

@media(max-width: 575px) {

    .landing-hero-content h1 {
        font-size: 2rem;
    }

    .hero-stats {
        grid-template-columns: 1fr;
    }

}
@media(max-width: 991px){

    /* HERO */
    .landing-hero-desktop{

        min-height:100vh;
        padding:7rem 0 4rem;

        background:
        linear-gradient(
            135deg,
            #111827,
            #1e40af
        );

        display:flex;
        align-items:center;
        justify-content:center;
        text-align:center;
    }

    /* QUITAR VIDEO */
    .landing-video{
        display:none;
    }

    /* OVERLAY */
    .landing-hero-overlay{
        background:
        linear-gradient(
            135deg,
            rgba(17,24,39,.96),
            rgba(30,64,175,.92)
        );
    }

    /* CONTENIDO */
    .landing-hero-content{

        max-width:100%;
        margin:0 auto;

        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
    }

    .landing-accent{
        margin:0 auto 1rem !important;
    }

    .landing-badge{
        margin-bottom:1rem;
    }

    .landing-hero-content h1{

        font-size:2.3rem;
        line-height:1.05;

        text-align:center;

        margin-bottom:1.2rem;
    }

    .landing-hero-content p{

        text-align:center;

        max-width:95%;

        margin-left:auto;
        margin-right:auto;
    }

    /* BOTONES */
    .landing-hero-content .d-flex{

        justify-content:center;
        align-items:center;
        flex-wrap:wrap;

        gap:.8rem !important;

        margin-top:1.7rem;
    }

    .landing-button,
    .landing-outline-button{

        width:auto !important;

        display:inline-flex;
        align-items:center;
        justify-content:center;

        padding:.9rem 1.2rem;

        font-size:.92rem;
    }

    /* STATS */
    .hero-stats{

        width:100%;

        display:grid;

        grid-template-columns:repeat(3,1fr);

        gap:.8rem;

        margin-top:2rem;
    }

    .hero-stat-card{

        min-width:0;

        padding:.9rem .7rem;

        text-align:center;
    }

    .hero-stat-card strong{
        font-size:1.2rem;
    }

    .hero-stat-card span{
        font-size:.72rem;
    }

}

@media(max-width:575px){

    .landing-hero-content h1{
        font-size:2rem;
    }

    .landing-hero-content p{
        font-size:.95rem;
    }

    .hero-stats{
        grid-template-columns:1fr;
    }

}

@media(max-width: 575px) {

    .landing-hero-content h1 {
        font-size: 2rem;
    }

    .landing-hero-content p {
        font-size: .95rem;
    }

    .hero-stats {
        gap: .7rem;
    }

    .hero-stat-card {
        padding: .8rem;
        min-width: 95px;
    }

    .hero-stat-card strong {
        font-size: 1.2rem;
    }

}
@media(max-width:991px){

    .desktop-sponsor-card{
        display:none;
    }

} 


.mobile-language-wrapper{
    display:flex;
    align-items:center;

    margin-left:auto;
    margin-right:.55rem;

    position:relative;
}

.mobile-language-clone .selected-lang{

    width:38px;
    height:38px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    background:transparent;

    border:1px solid rgba(255,255,255,.14);

    padding:0;

    cursor:pointer;
}

.mobile-language-clone .selected-lang img{

    width:22px;
    height:22px;

    border-radius:50%;
    object-fit:cover;
}

.mobile-lang-options{

    position:absolute;

    top:115%;
    right:0;

    min-width:170px;

    background:#111827;

    border-radius:1rem;

    overflow:hidden;

    border:1px solid rgba(255,255,255,.08);

    box-shadow:
    0 1rem 2rem rgba(0,0,0,.22);

    display:none;

    z-index:9999;
}

.mobile-lang-options button{

    width:100%;

    background:none;
    border:none;

    color:white;

    display:flex;
    align-items:center;
    gap:.7rem;

    padding:.85rem 1rem;

    font-weight:600;
}

.mobile-lang-options button:hover{
    background:rgba(255,255,255,.06);
}

.mobile-lang-options img{

    width:20px;
    height:20px;

    border-radius:50%;
}

@media(min-width:992px){

    .mobile-language-wrapper{
        display:none;
    }

}

@media(max-width: 991px) {
    .desktop-language-selector {
        display: none !important;
    }
}


    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts

    <script>

    const navbar = document.getElementById('navbar');

    function updateNavbar() {

        if (window.scrollY >= 80) {
            navbar.classList.add('black');
        } else {
            navbar.classList.remove('black');
        }

    }

    // AL CARGAR
    window.addEventListener('load', updateNavbar);

    // AL HACER SCROLL
    window.addEventListener('scroll', updateNavbar);

    function toggleLangDropdown() {

        const dropdown = document.getElementById('langDropdown');

        dropdown.style.display =
            dropdown.style.display === 'block'
            ? 'none'
            : 'block';

    }

    document.addEventListener('click', function(event) {

        const dropdown = document.getElementById('langDropdown');

        const selector =
            document.querySelector('.language-dropdown2');

        if (selector && !selector.contains(event.target)) {
            dropdown.style.display = 'none';
        }

    });

</script>
<script>
function toggleLangDropdown(event) {
    event.stopPropagation();

    const dropdown = document.getElementById('langDropdown');

    dropdown.style.display =
        dropdown.style.display === 'block' ? 'none' : 'block';
}

function toggleLangDropdownMobile(event) {
    event.stopPropagation();

    const dropdown = document.getElementById('mobileLangDropdown');

    dropdown.style.display =
        dropdown.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function () {
    const desktop = document.getElementById('langDropdown');
    const mobile = document.getElementById('mobileLangDropdown');

    if (desktop) desktop.style.display = 'none';
    if (mobile) mobile.style.display = 'none';
});
</script>
</body>

</html>
