@extends('layouts.app')

@section('title', __('home.title'))

@section('content')

<div class="container py-5">

    {{-- HERO --}}
    <div class="home-hero mb-5">

        <div class="position-relative">

            <div class="home-accent orange"></div>

            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">

                <div>

                    <h1 class="home-title">
                        {{ __('home.hello') }} {{ $user->name }}
                    </h1>

                    <p class="home-subtitle">
                        {{ __('home.welcome') }}
                    </p>

                </div>


            </div>

        </div>

    </div>

    @if($inscripcionesPagadas->isNotEmpty())

        {{-- TORNEOS ACTIVOS --}}
        <div class="home-section-card mb-5">

            <div class="home-accent blue"></div>

            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">

                <div>

                    <h3 class="home-section-title">
                        {{ __('home.active_tournaments') }}
                    </h3>

                    <p class="home-section-description">
                        {{ __('home.active_tournaments_description') }}
                    </p>

                </div>

                <div class="home-section-icon">
                    <i class="fa-solid fa-trophy"></i>
                </div>

            </div>

            <div class="home-divider"></div>

            <div class="row g-4">

                @foreach($inscripcionesPagadas as $inscripcion)
@php

    $torneo = $inscripcion->torneo;

    $puntajeTorneo = \DB::table('pronosticos')
        ->join('partidos', 'pronosticos.partido', '=', 'partidos.id')
        ->where('pronosticos.jugador', $user->id)
        ->where('partidos.torneo_id', $torneo->id)
        ->sum('pronosticos.puntos');

    $ranking = \DB::table('pronosticos')
        ->join('partidos', 'pronosticos.partido', '=', 'partidos.id')
        ->select(
            'pronosticos.jugador',
            \DB::raw('SUM(pronosticos.puntos) as total')
        )
        ->where('partidos.torneo_id', $torneo->id)
        ->groupBy('pronosticos.jugador')
        ->orderByDesc('total')
        ->pluck('pronosticos.jugador')
        ->toArray();

    $posicion = array_search($user->id, $ranking) !== false
        ? array_search($user->id, $ranking) + 1
        : '—';

    $total = count($ranking);

@endphp

                    <div class="col-12 col-md-6 col-xl-4">

                        <div class="home-tournament-card h-100">

                            <div class="home-card-accent"></div>

                            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">

                                <div>

                                    <h5 class="home-card-title">
                                        {{ $torneo->nombre_torneo }}
                                    </h5>

                                    <p class="home-card-subtitle">
                                        {{ __('home.world_cup_pool') }}
                                    </p>

                                </div>

                                <div class="home-mini-icon">
                                    <i class="fa-solid fa-medal"></i>
                                </div>

                            </div>

                            <div class="home-info-grid">

                                <div class="home-info-item">

                                    <small>
                                        {{ __('home.points') }}
                                    </small>

                                    <strong>
                                        {{ $puntajeTorneo }}
                                    </strong>

                                </div>

                                <div class="home-info-item">

                                    <small>
                                        {{ __('home.position') }}
                                    </small>

                                    <strong>
                                        #{{ $posicion }}
                                    </strong>

                                </div>

                            </div>

                            <div class="home-meta mt-4">

                                <span>
                                    {{ __('home.participants') }}
                                </span>

                                <strong>
                                    {{ $total }}
                                </strong>

                            </div>

                            <div class="home-actions mt-4">

                                <a href="{{ url('predictions') }}"
                                   class="home-link-primary">

                                    {{ __('home.go_to_predictions') }}

                                    <i class="fa-solid fa-arrow-right"></i>

                                </a>

                                <a href="{{ url('standings') }}"
                                   class="home-link-secondary">

                                    {{ __('home.view_positions') }}

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- ACCIONES RAPIDAS --}}
        <div class="home-section-card">

            <div class="home-accent blue"></div>

            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">

                <div>

                    <h3 class="home-section-title">
                        {{ __('home.quick_actions') }}
                    </h3>

                    <p class="home-section-description">
                        {{ __('home.quick_actions_description') }}
                    </p>

                </div>

                <div class="home-section-icon">
                    <i class="fa-solid fa-bolt"></i>
                </div>

            </div>

            <div class="home-divider"></div>

            <div class="row g-4">

                <div class="col-md-4">

                    <a href="{{ url('predictions') }}"
                       class="home-action-card">

                        <div class="home-action-icon">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>

                        <h5>
                            {{ __('home.predictions') }}
                        </h5>

                        <p>
                            {{ __('home.predictions_description') }}
                        </p>

                    </a>

                </div>

                <div class="col-md-4">

                    <a href="{{ url('standings') }}"
                       class="home-action-card">

                        <div class="home-action-icon">
                            <i class="fa-solid fa-ranking-star"></i>
                        </div>

                        <h5>
                            {{ __('home.standings') }}
                        </h5>

                        <p>
                            {{ __('home.standings_description') }}
                        </p>

                    </a>

                </div>

                <div class="col-md-4">

                    <a href="{{ url('registrations') }}"
                       class="home-action-card">

                        <div class="home-action-icon">
                            <i class="fa-solid fa-ticket"></i>
                        </div>

                        <h5>
                            {{ __('home.my_registrations') }}
                        </h5>

                        <p>
                            {{ __('home.my_registrations_description') }}
                        </p>

                    </a>

                </div>

            </div>

        </div>

    @else

        {{-- USUARIO NUEVO --}}
        <div class="home-section-card">

            <div class="home-empty">

                <div class="home-empty-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>

                <h3>
                    {{ __('home.no_tournaments_title') }}
                </h3>

                <p>
                    {{ __('home.no_tournaments_description') }}
                </p>

                <a href="{{ url('registrations') }}"
                   class="home-link-primary mt-4 d-inline-flex">

                    {{ __('home.go_to_my_registrations') }}

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>

        </div>

    @endif

</div>

<style>

    .home-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #1e40af, #111827);
        border-radius: 1.5rem;
        padding: 3rem;
        color: #fff;
        box-shadow: 0 1rem 2.5rem rgba(0,0,0,.12);
    }

    .home-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at top right,
            rgba(255,255,255,.08),
            transparent 35%);
    }

    .home-section-card,
    .home-tournament-card,
    .home-action-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1.2rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .22s ease;
    }

    .home-section-card {
        padding: 1.8rem;
    }

    .home-tournament-card,
    .home-action-card {
        padding: 1.5rem;
    }

    .home-section-card:hover,
    .home-tournament-card:hover,
    .home-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .home-accent {
        width: 52px;
        height: 4px;
        border-radius: 999px;
        margin-bottom: 1rem;
    }

    .home-accent.blue {
        background: #1e40af;
    }

    .home-accent.orange {
        background: #ff6600;
    }

    .home-card-accent {
        width: 42px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .home-title {
        font-size: 2.4rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: .5rem;
    }

    .home-subtitle {
        color: rgba(255,255,255,.75);
        margin-bottom: 0;
    }

    .home-hero-icon {
        width: 58px;
        height: 58px;
        border-radius: 1rem;
        background: rgba(255,255,255,.12);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
    }

    .home-section-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .4rem;
    }

    .home-section-description,
    .home-card-subtitle,
    .home-action-card p,
    .home-empty p {
        color: #6c757d;
        margin-bottom: 0;
    }

    .home-section-icon,
    .home-mini-icon,
    .home-action-icon,
    .home-empty-icon {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        background: #fff4ef;
        color: #ff6600;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .home-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.5rem 0;
    }

    .home-card-title,
    .home-action-card h5 {
        font-weight: 800;
        color: #212529;
        margin-bottom: .35rem;
    }

    .home-info-grid {
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 1rem;
    }

    .home-info-item {
        background: #f8f9fa;
        border-radius: 1rem;
        padding: 1rem;
    }

    .home-info-item small {
        display: block;
        color: #6c757d;
        margin-bottom: .35rem;
    }

    .home-info-item strong {
        color: #212529;
        font-size: 1.25rem;
    }

    .home-meta {
        display: flex;
        justify-content: space-between;
        color: #6c757d;
        font-size: .9rem;
    }

    .home-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .home-link-primary {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        color: #1e40af;
        font-weight: 800;
        text-decoration: none;
    }

    .home-link-primary:hover {
        color: #3157d5;
    }

    .home-link-secondary {
        color: #6c757d;
        font-weight: 700;
        text-decoration: none;
        font-size: .9rem;
    }

    .home-link-secondary:hover {
        color: #212529;
    }

    .home-action-card {
        display: block;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    .home-action-icon {
        margin-bottom: 1rem;
    }

    .home-empty {
        text-align: center;
        padding: 3rem 1rem;
        max-width: 620px;
        margin: 0 auto;
    }

    .home-empty-icon {
        margin: 0 auto 1.3rem;
    }

    .home-empty h3 {
        font-weight: 800;
        color: #212529;
        margin-bottom: .8rem;
    }

    @media(max-width: 768px) {

        .home-hero {
            padding: 2rem;
        }

        .home-title {
            font-size: 2rem;
        }

        .home-section-card {
            padding: 1.4rem;
        }

        .home-actions {
            align-items: flex-start;
            flex-direction: column;
        }

    }

</style>

@endsection