<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header text-center">
          <h4>Registro al Torneo</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <div class="mb-3">
              <label for="name" class="form-label">Nombre completo</label>
              <input id="name" type="text" 
                     class="form-control @error('name') is-invalid @enderror" 
                     name="name" value="{{ old('name') }}" required autofocus>
              @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input id="email" type="email" 
                     class="form-control @error('email') is-invalid @enderror" 
                     name="email" value="{{ old('email') }}" required>
              @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input id="password" type="password" 
                     class="form-control @error('password') is-invalid @enderror" 
                     name="password" required>
              @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Confirmar Password -->
            <div class="mb-3">
              <label for="password-confirm" class="form-label">Confirmar contraseña</label>
              <input id="password-confirm" type="password" 
                     class="form-control" 
                     name="password_confirmation" required>
            </div>

            <!-- Torneo -->
            <div class="mb-3">
              <label for="torneo" class="form-label">Selecciona el torneo</label>
              <select id="torneo" name="torneo" 
                      class="form-select @error('torneo') is-invalid @enderror" required>
                <option value="">-- Selecciona --</option>
                <option value="champions" {{ old('torneo')=='champions' ? 'selected' : '' }}>Champions League - $50</option>
                <option value="copa_mundial" {{ old('torneo')=='copa_mundial' ? 'selected' : '' }}>Copa Mundial - $80</option>
              </select>
              @error('torneo')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Botón -->
            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">Ir al Pago</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>