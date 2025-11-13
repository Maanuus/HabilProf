<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
    <title>Login | HabilProf</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f5f7fb}
        .brand-dot{width:44px;height:44px;border-radius:50%;background:#0d6efd}
    </style>
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">
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
                            <form>
                                <div class="mb-3">
                                    <label for="rut" class="form-label fw-semibold">RUT</label>
                                    <input id="rut" 
                                        type="text" 
                                        class="form-control" 
                                        placeholder="Sin puntos ni dígito verificador">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                                    <input id="password" 
                                        type="password" 
                                        class="form-control" 
                                        placeholder="Contraseña">
                                </div>

                                <!-- redirige a la “home” real (welcome) -->
                                <a class="btn btn-primary w-100"
                                style="--bs-btn-bg:#dd120bff; --bs-btn-border-color:#0ea5e9;
                                --bs-btn-hover-bg:#cdcecf; --bs-btn-hover-border-color:#0284c7;
                                --bs-btn-color:#fff;"
                                style="--bs-btn-padding-y: 0.9rem;"
                                href="{{ route('home') }}">
                                Ingresa
                                </a>

                                <div class="mb-3">
                                    Si aún no tienes tu contraseña, haz click <a href="{{ route('register') }}" class="link-primary">aquí</a>.
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-3 text-muted small">
                        © {{ date('Y') }} HabilProf
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
