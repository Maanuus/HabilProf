<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Register | HabilProf</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">
  <style>body{background:#f5f7fb}</style>
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-7 col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4">
                                <div><img src="{{ asset('images/ucsc_logo_color.png') }}" alt="Logo" width=200></div>
                                <h1 class="h5 mt-3 mb-0">Portal de Ingreso</h1>
                                <div class="text-muted small">HabilProf</div>
                            </div>

                            @if ($errors->any())
                            <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                            @endif

                            <form method="POST" action="{{ route('register.post') }}">
                            @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nombre</label>
                                    <input name="name" type="text" class="form-control" placeholder="Primer nombre y dos apellidos" value="{{ old('name') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">RUT</label>
                                    <input name="rut" type="text" class="form-control" placeholder="Ej: 12.345.678-K" value="{{ old('rut') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">¿Qué tipo de valor desempeña</label>
                                    <select name="tipo_HabilProf" id="tipo_HabilProf" class="form-select" required>
                                        <option value="" disabled selected>Seleccione un tipo</option>
                                        <option value="Pring">Proyecto Ingeniería</option>
                                        <option value="Prinv">Proyecto Investigación</option>
                                        <option value="PrTut">Práctica Tutelada</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Contraseña</label>
                                    <input name="password" type="password" class="form-control" placeholder="Mínimo 8 carácteres" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Confirme contraseña</label>
                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Mínimo 8 carácteres" required>
                                </div>
                                <button class="btn btn-primary w-100"
                                style="--bs-btn-bg:#dd120bff; --bs-btn-border-color:#0ea5e9;
                                --bs-btn-hover-bg:#cdcecf; --bs-btn-hover-border-color:#0284c7;
                                --bs-btn-color:#fff;"
                                style="--bs-btn-padding-y: 0.9rem;">Crear cuenta</button>

                                <div class="mt-3">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>.</div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-3 text-muted small">© {{ date('Y') }} HabilProf</div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
