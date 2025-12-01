<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ProyectoAventones')</title>

    {{-- BOOTSTRAP 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
        }
        .auth-card {
            max-width: 420px;
            margin: 60px auto;
            background: white;
            border-radius: 16px;
            padding: 32px 28px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.10);
        }
        .brand-title {
            font-weight: 700;
            font-size: 1.7rem;
            text-align: center;
            margin-bottom: 15px;
            color: #4f46e5;
        }
        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            color: #6b7280;
        }
    </style>

</head>
<body>

    <div class="container">
        @yield('content')
    </div>

    {{-- BOOTSTRAP 5 JS (necesario para el modal y otros componentes) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+AMvyTG2kpI5hBYC0GmIJp1JwJ8ER"
            crossorigin="anonymous"></script>

</body>
</html>

