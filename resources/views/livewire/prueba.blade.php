<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Suscripciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .bg-main {
      background-color: #1e40af !important;
    }
    .text-main {
      color: #1e40af !important;
    }
    .card-sub {
      border-radius: 1.5rem;
      transition: all 0.3s ease;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .card-sub:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 12px 30px rgba(30, 64, 175, 0.4);
    }
    .btn-main {
      background-color: #1e40af;
      color: #fff;
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      transition: all 0.3s ease;
    }
    .btn-main:hover {
      background-color: #162f82;
      transform: scale(1.05);
    }
  </style>
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-main">Planes de Suscripción</h2>
      <p class="text-muted">Elige el plan que más se adapte a ti</p>
    </div>

    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card card-sub text-center h-100">
          <div class="card-body">
            <h5 class="fw-bold text-main">Básico</h5>
            <p class="fs-4 fw-bold">$4.99 / mes</p>
            <ul class="list-unstyled mb-4">
              <li>✔ Acceso limitado</li>
              <li>✔ 5 descargas</li>
              <li>✔ Soporte estándar</li>
            </ul>
            <button class="btn btn-main">Elegir</button>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card card-sub text-center h-100 border-2 border-main">
          <div class="card-body">
            <h5 class="fw-bold text-main">Premium</h5>
            <p class="fs-4 fw-bold">$9.99 / mes</p>
            <ul class="list-unstyled mb-4">
              <li>✔ Acceso ilimitado</li>
              <li>✔ Descargas ilimitadas</li>
              <li>✔ Soporte prioritario</li>
            </ul>
            <button class="btn btn-main">Elegir</button>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="card card-sub text-center h-100">
          <div class="card-body">
            <h5 class="fw-bold text-main">Empresarial</h5>
            <p class="fs-4 fw-bold">$29.99 / mes</p>
            <ul class="list-unstyled mb-4">
              <li>✔ Multiusuario</li>
              <li>✔ Reportes avanzados</li>
              <li>✔ Soporte dedicado</li>
            </ul>
            <button class="btn btn-main">Elegir</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
