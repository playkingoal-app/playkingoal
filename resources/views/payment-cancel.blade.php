 <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="{!! asset('estilos.css') !!}">
    <link rel="stylesheet" href="{!! asset('style.css') !!}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow text-center" style="max-width: 500px; border-top: 5px solid #1e40af;">
        <div class="card-body">
            <i class="bi bi-x-circle-fill text-danger" style="font-size: 3rem;"></i>
            <h3 class="card-title mt-3" style="color: #1e40af;">Pago Cancelado</h3>
            <p class="card-text mt-2">No se ha completado la transacción.</p>
            <p class="text-muted" style="font-size: 0.9rem;">Si quieres intentarlo de nuevo, pulsa el botón de abajo.</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3" style="background-color: #1e40af; border-color: #1e40af;">
                Volver al inicio
            </a>
        </div>
    </div>
</div>
