<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title') | {{ strtoupper(config('app.name')) }}</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/blackbird1.png') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('web/css/styles.css') }}" rel="stylesheet" />
    @yield('css')

    @livewireStyles
    @yield('recaptcha')
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">


            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/blackbird1.png') }}"
                    alt="logo" width="50" height="54"> {{ strtoupper(config('app.name')) }}</a>
            @auth
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="{{ route('home') }}">Inicio</a></li>
                    {{--
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="#about">About</a></li> --}}


                    <li class="nav-item mx-0 mx-lg-1">
                        <a href="{{ route('logout') }}" class="nav-link py-3 px-0 px-lg-3 rounded" onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            <span>Cerrar Sesión</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>

            </div>
            @endauth
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 120px;">
        @yield('content')
    </div>


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('web/js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> --}}
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    @livewireScripts
    @yield('js')

    @if (session('success'))
    <script>
        Swal.fire(
                'Excelente!',
                '{{ session('success') }}',
                'success'
            )
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire(
                'Error',
                '{{ session('error') }}',
                'error'
            )
    </script>
    @endif

    @if (session('warning'))
    <script>
        Swal.fire(
                'Atención!',
                '{{ session('warning') }}',
                'warning'
            )
    </script>
    @endif

    <script>
        Livewire.on('dataTableRender', () => {
            $(".dataTable").dataTable({
                "destroy": true,
                order: [
                    [0, 'desc']
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                },
            })
        })

        Livewire.on('success', message => {
            // Swal.fire('Excelente!',message,'success');  
            Swal.fire({
                icon: 'success',
                title: 'Excelente',
                text: message,
                showConfirmButton: false,
                timer: 1500
            })
        });
        Livewire.on('error', message => {
            Swal.fire('Error!', message, 'error');

        });
        Livewire.on('warning', message => {
            Swal.fire('Atención!', message, 'warning');
        });
    </script>



</body>

</html>