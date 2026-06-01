@section('title', __('regulations.title'))

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">
        <h1 class="regulations-title mt-3">
            <i class="fa-solid fa-handshake-angle" style="color: #ff6600 !important"></i>
            {{ __('regulations.title') }}
        </h1>

        <p class="regulations-subtitle">
            {{ __('regulations.subtitle') }}
        </p>
    </div>

    {{-- RESUMEN --}}
    <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">
        <div class="regulations-status-badge warning">
            <i class="bi bi-list-check"></i>
            <span>{{ __('regulations.how_it_works') }}</span>
        </div>

        <div class="regulations-status-badge success">
            <i class="bi bi-award"></i>
            <span>{{ __('regulations.points_title') }}</span>
        </div>

        <div class="regulations-status-badge info">
            <i class="bi bi-shield-check"></i>
            <span>{{ __('regulations.organization_title') }}</span>
        </div>
    </div>

    {{-- REGLAS --}}
    <div class="regulation-section-card mb-5">
        <div class="regulation-top">
            <div class="regulation-accent"></div>

            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h3 class="regulation-name">
                        {{ __('regulations.how_it_works') }}
                    </h3>

                    <p class="regulation-description">
                        {{ __('regulations.how_it_works_subtitle') }}
                    </p>
                </div>

                <div class="regulation-icon warning">
                    <i class="bi bi-clipboard-check"></i>
                </div>
            </div>
        </div>

        <div class="regulation-divider"></div>

        <div class="row g-4">
            @for ($i = 1; $i <= 4; $i++)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="regulation-card h-100">
                        <div class="regulation-accent"></div>

                        <div class="regulation-mini-icon warning">
                            @if($i == 1)
                                <i class="fa-solid fa-pen-to-square"></i>
                            @elseif($i == 2)
                                <i class="fa-solid fa-clock"></i>
                            @elseif($i == 3)
                                <i class="fa-solid fa-bullseye"></i>
                            @else
                                <i class="fa-solid fa-ranking-star"></i>
                            @endif
                        </div>

                        <h6 class="regulation-card-title">
                            {{ __('regulations.step_'.$i.'_title') }}
                        </h6>

                        <p class="regulation-card-text">
                            {{ __('regulations.rule_'.$i) }}
                        </p>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    {{-- SISTEMA DE PUNTOS --}}
    <div class="regulation-section-card mb-5">
        <div class="regulation-top">
            <div class="regulation-accent"></div>

            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h3 class="regulation-name">
                        {{ __('regulations.points_title') }}
                    </h3>

                    <p class="regulation-description">
                        {{ __('regulations.points_subtitle') }}
                    </p>
                </div>

                <div class="regulation-icon success">
                    <i class="bi bi-trophy"></i>
                </div>
            </div>
        </div>

        <div class="regulation-divider"></div>

        <div class="regulation-alert-info mb-4">
            <i class="bi bi-info-circle"></i>
            <span>{{ __('regulations.points_note') }}</span>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="regulation-card h-100">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div class="regulation-mini-icon success">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>

                        <span class="regulation-point-badge">
                            {{ __('regulations.points_type_main') }}
                        </span>
                    </div>

                    <h5 class="regulation-card-title">
                        {{ __('regulations.exact_score_title') }}
                    </h5>

                    <p class="regulation-card-text">
                        {{ __('regulations.exact_score_description') }}
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="regulation-card h-100">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div class="regulation-mini-icon success">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <span class="regulation-point-badge">
                            {{ __('regulations.points_type_partial') }}
                        </span>
                    </div>

                    <h5 class="regulation-card-title">
                        {{ __('regulations.correct_winner_title') }}
                    </h5>

                    <p class="regulation-card-text">
                        {{ __('regulations.correct_winner_description') }}
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="regulation-card h-100">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div class="regulation-mini-icon success">
                            <i class="fa-solid fa-sliders"></i>
                        </div>

                        <span class="regulation-point-badge">
                            {{ __('regulations.points_type_custom') }}
                        </span>
                    </div>

                    <h5 class="regulation-card-title">
                        {{ __('regulations.custom_points_title') }}
                    </h5>

                    <p class="regulation-card-text">
                        {{ __('regulations.custom_points_description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- EJEMPLOS --}}
    <div class="regulation-section-card mb-5">
        <div class="regulation-top">
            <div class="regulation-accent"></div>

            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h3 class="regulation-name">
                        {{ __('regulations.examples_title') }}
                    </h3>

                    <p class="regulation-description">
                        {{ __('regulations.examples_subtitle') }}
                    </p>
                </div>

                <div class="regulation-icon warning">
                    <i class="bi bi-ui-checks-grid"></i>
                </div>
            </div>
        </div>

        <div class="regulation-divider"></div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="regulation-example-box h-100">
                    <h6 class="fw-bold text-success">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        {{ __('regulations.perfect_hit_title') }}
                    </h6>

                    <div class="my-3">
                        {{ __('regulations.your_prediction') }}
                        <span class="regulation-score-box ms-2">2 - 1</span>
                    </div>

                    <div class="mb-3">
                        {{ __('regulations.real_result') }}
                        <span class="regulation-score-box ms-2">2 - 1</span>
                    </div>

                    <p class="text-muted small mb-0">
                        {{ __('regulations.perfect_hit_description') }}
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="regulation-example-box h-100">
                    <h6 class="fw-bold text-primary">
                        <i class="fa-solid fa-thumbs-up me-1"></i>
                        {{ __('regulations.correct_winner_example_title') }}
                    </h6>

                    <div class="my-3">
                        {{ __('regulations.your_prediction') }}
                        <span class="regulation-score-box ms-2">2 - 1</span>
                    </div>

                    <div class="mb-3">
                        {{ __('regulations.real_result') }}
                        <span class="regulation-score-box ms-2">3 - 1</span>
                    </div>

                    <p class="text-muted small mb-0">
                        {{ __('regulations.correct_winner_example_description') }}
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="regulation-example-box h-100">
                    <h6 class="fw-bold text-danger">
                        <i class="fa-solid fa-circle-xmark me-1"></i>
                        {{ __('regulations.no_hit_title') }}
                    </h6>

                    <div class="my-3">
                        {{ __('regulations.your_prediction') }}
                        <span class="regulation-score-box ms-2">1 - 2</span>
                    </div>

                    <div class="mb-3">
                        {{ __('regulations.real_result') }}
                        <span class="regulation-score-box ms-2">2 - 1</span>
                    </div>

                    <p class="text-muted small mb-0">
                        {{ __('regulations.no_hit_description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ORGANIZACIÓN Y PREMIOS --}}
    <div class="regulation-section-card">
        <div class="regulation-top">
            <div class="regulation-accent"></div>

            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h3 class="regulation-name">
                        {{ __('regulations.organization_title') }}
                    </h3>

                    <p class="regulation-description">
                        {{ __('regulations.organization_subtitle') }}
                    </p>
                </div>

                <div class="regulation-icon info">
                    <i class="bi bi-shield-check"></i>
                </div>
            </div>
        </div>

        <div class="regulation-divider"></div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="regulation-info-box h-100">
                    <div class="regulation-mini-icon info">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>

                    <h5 class="regulation-card-title">
                        {{ __('regulations.organizer_role_title') }}
                    </h5>

                    <p class="regulation-card-text">
                        {{ __('regulations.organizer_role_text') }}
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="regulation-info-box h-100">
                    <div class="regulation-mini-icon info">
                        <i class="fa-solid fa-gift"></i>
                    </div>

                    <h5 class="regulation-card-title">
                        {{ __('regulations.prizes_title') }}
                    </h5>

                    <p class="regulation-card-text">
                        {{ __('regulations.prizes_text') }}
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="regulation-info-box h-100">
                    <div class="regulation-mini-icon info">
                        <i class="fa-solid fa-handshake"></i>
                    </div>

                    <h5 class="regulation-card-title">
                        {{ __('regulations.external_agreements_title') }}
                    </h5>

                    <p class="regulation-card-text">
                        {{ __('regulations.external_agreements_text') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .regulations-title {
        font-size: 2.4rem;
        font-weight: 800;
    }

    .regulations-subtitle {
        max-width: 720px;
        margin: 0 auto;
        color: #6c757d;
        font-size: 1rem;
    }

    .regulations-status-badge {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .65rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .9rem;
        border: 1px solid transparent;
    }

    .regulations-status-badge.warning {
        background: #fff4ef;
        color: #ff4500;
        border-color: #ffd4c2;
    }

    .regulations-status-badge.success {
        background: #eef8f2;
        color: #198754;
        border-color: #cfead9;
    }

    .regulations-status-badge.info {
        background: #eef4ff;
        color: #1e40af;
        border-color: #c7d8ff;
    }

    .regulation-section-card,
    .regulation-card,
    .regulation-info-box {
        position: relative;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
        transition: .2s ease;
    }

    .regulation-section-card {
        padding: 1.8rem;
    }

    .regulation-card,
    .regulation-info-box {
        padding: 1.5rem;
    }

    .regulation-card:hover,
    .regulation-info-box:hover,
    .regulation-section-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .9rem 2rem rgba(0,0,0,.10);
    }

    .regulation-accent {
        width: 46px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        margin-bottom: 1rem;
    }

    .regulation-name {
        font-size: 1.6rem;
        font-weight: 800;
        color: #212529;
        margin-bottom: .5rem;
    }

    .regulation-description {
        color: #6c757d;
        font-size: .95rem;
        margin-bottom: 0;
    }

    .regulation-icon,
    .regulation-mini-icon {
        width: 48px;
        height: 48px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .regulation-mini-icon {
        margin-bottom: 1rem;
    }

    .regulation-icon.warning,
    .regulation-mini-icon.warning {
        background: #fff4ef;
        color: #ff4500;
    }

    .regulation-icon.success,
    .regulation-mini-icon.success {
        background: #eef8f2;
        color: #198754;
    }

    .regulation-icon.info,
    .regulation-mini-icon.info {
        background: #eef4ff;
        color: #1e40af;
    }

    .regulation-divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.4rem 0;
    }

    .regulation-card-title {
        font-weight: 800;
        color: #212529;
        margin-bottom: .6rem;
    }

    .regulation-card-text {
        color: #6c757d;
        font-size: .92rem;
        margin-bottom: 0;
    }

    .regulation-point-badge {
        background: #fff4ef;
        color: #ff4500;
        border: 1px solid #ffd4c2;
        border-radius: 999px;
        padding: .45rem .8rem;
        font-weight: 700;
        font-size: .78rem;
        white-space: nowrap;
    }

    .regulation-alert-info {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        background: #eef4ff;
        color: #1e40af;
        border: 1px solid #c7d8ff;
        border-radius: 1rem;
        padding: 1rem 1.2rem;
        font-weight: 600;
        font-size: .95rem;
    }

    .regulation-example-box {
        background: #fff;
        border: 1px solid #dee2e6;
        border-left: 5px solid #1e40af;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.06);
    }

    .regulation-score-box {
        background: #fff;
        border-radius: 999px;
        padding: .45rem .85rem;
        font-weight: 800;
        display: inline-block;
        min-width: 72px;
        text-align: center;
        border: 1px solid #dee2e6;
        box-shadow: 0 .35rem .9rem rgba(0,0,0,.06);
    }

    @media(max-width: 575px) {
        .regulations-title {
            font-size: 2rem;
        }

        .regulation-section-card {
            padding: 1.3rem;
        }

        .regulation-name {
            font-size: 1.35rem;
        }
    }
</style>