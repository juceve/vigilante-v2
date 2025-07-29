<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido | Seguridad Privada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0d1b2a;
            color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-image {
            background-image: url('{{ asset('images/security.avif') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* 🔥 Esto mantiene la imagen fija */
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .header-image::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .btn-gold {
            background-color: #ffcc00;
            color: #000;
            font-weight: bold;
            border: none;
        }

        .btn-gold:hover {
            background-color: #e6b800;
        }

        .logo {
            max-width: 120px;
            margin-bottom: 20px;
            border-radius: 50%;
            background: #015c5cad;
            padding: 10px;
        }

        .features-section {
            background-color: #112240;
            padding: 50px 0;
        }

        footer {
            background-color: #0b1622;
        }
    </style>
</head>

<body>

    <header class="header-image">
        <div class="header-content text-white">
            <img src="{{asset('images/logo_shield.png')}}" alt="Logo Seguridad" class="logo">
            <h1 class="display-5 fw-bold">Sistema de Seguridad Privada</h1>
            <p class="lead mb-4">Protección física y digital en una sola plataforma</p>
            <div class="d-flex justify-content-center">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary py-3 px-4 mx-2">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-light mx-2">Registrarse</a>
                    @endif
                @else
                    <a href="{{ route('home') }}" class="btn btn-success py-3 px-4 mx-2">Dashboard</a>
                @endauth
            </div>

        </div>
    </header>

    <section class="features-section text-center text-light">
        <div class="container">
            <h2 class="mb-5">Nuestros Servicios</h2>
            <div class="row">
                <div class="col-md-4">
                    <img src="{{asset('images/pexels-photo-7858748.jpeg')}}"
                        class="img-fluid rounded mb-3" alt="Monitoreo">
                    <h4>Monitoreo 24/7</h4>
                    <p>Supervisión continua mediante sistemas de CCTV y monitoreo remoto.</p>
                </div>
                <div class="col-md-4">
                    <img src="{{asset('images/guardia1.avif')}}"
                        class="img-fluid rounded mb-3" alt="Personal de Seguridad">
                    <h4>Guardias Especializados</h4>
                    <p>Personal capacitado para resguardar tus instalaciones y activos críticos.</p>
                </div>
                <div class="col-md-4">
                    <img src="{{asset('images/sd.webp')}}"
                        class="img-fluid rounded mb-3" alt="Ciberseguridad">
                    <h4>Seguridad Digital</h4>
                    <p>Protección contra amenazas digitales mediante tecnología de punta.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center text-light py-3">
        &copy; 2025 Seguridad Privada S.A. Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
