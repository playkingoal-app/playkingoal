<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('terms.title') }} | El Rey del Gol</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body style="background: #f8fafc;">

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mb-5">

        <div class="legal-icon mx-auto mb-4">
            <i class="bi bi-shield-check"></i>
        </div>

        <h1 class="legal-title">
            {{ __('terms.title') }}
        </h1>

        <p class="legal-subtitle">
            {{ __('terms.updated') }}
        </p>

    </div>

    {{-- CARD --}}
    <div class="legal-card">

        @for($i = 1; $i <= 10; $i++)

            <div class="legal-section">

                <div class="legal-accent mb-3"></div>

<h2 class="legal-section-title">
    {{ __('terms.section_'.$i.'_title') }}
</h2>

                <p class="legal-text">
                    {{ __('terms.section_'.$i.'_text') }}
                </p>

            </div>

        @endfor

    </div>

    {{-- FOOTER --}}
    <div class="text-center mt-5">

        <a href="{{ url('/') }}"
           class="legal-button">
            <i class="bi bi-house-door"></i>
            Inicio
        </a>

        <a href="{{ route('privacy') }}"
           class="legal-button secondary">
            <i class="bi bi-shield-lock"></i>
            {{ __('footer.privacy') }}
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

    .legal-section-top {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .legal-accent {
        width: 50px;
        height: 4px;
        border-radius: 999px;
        background: #1e40af;
        flex-shrink: 0;
    }

    .legal-section-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #212529;
    margin-bottom: 1rem;
    margin-top: .4rem;
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

</body>
</html>