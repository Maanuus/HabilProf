<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">
    <title>UCSC - HabilProf</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .ucsc-header {
            background-color: #b30600ff;
            color: white;
        }
        .sync-status {
            font-size: 0.8rem;
        }
        .nav-link {
            color: #495057;
        }
        .nav-link:hover {
            background-color: #e9ecef;
        }
        .container-content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="ucsc-header py-2">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0">
                        <a href="{{ url('/home') }}">
                            <img src="{{ asset('images/ucsc_logo.png') }}" alt="Logo UCSC" width="180">
                        </a>
                    </h4>
                </div>
                <div class="col-auto">
                    <span class="me-3"><a href="{{ url('/home') }}" class="btn btn-sm btn-outline-light">
    Inicio
</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container-fluid container-content">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
