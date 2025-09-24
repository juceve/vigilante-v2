<div>
    <style>
        /* Badge animada estilo “policía” para Ronda en Proceso */
        .ronda-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            color: #e7d90f;
            background: linear-gradient(270deg, #dc2626, #3b82f6, #609bfa, #3b82f6, #dc2626);
            background-size: 600% 600%;
            animation: ronda-gradient-police 5s ease infinite, ronda-pulse 3s infinite;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .ronda-badge:hover {
            transform: scale(1.1);
        }

        /* Gradiente animado estilo luces de policía */
        @keyframes ronda-gradient-police {
            0% {
                background-position: 0% 50%;
            }

            25% {
                background-position: 50% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            75% {
                background-position: 50% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Pulso sutil para resaltar */
        @keyframes ronda-pulse {

            0%,
            100% {
                box-shadow: 0 0 0px rgba(255, 255, 255, 0.4);
            }

            50% {
                box-shadow: 0 0 12px rgba(255, 255, 255, 0.6);
            }
        }
    </style>

    @if ($rondaejecutada_id)
        <a href="{{ route('vigilancia.recorrido_ronda', $rondaejecutada_id) }}" class="ronda-badge">
            <img src="{{ asset('images/guardman.png') }}" alt="Guard" width="20" height="20">
            Ronda en Progreso
        </a>
    @endif

</div>
@section('js2')
    <script>
        let latitud = null;
        let longitud = null;

        function obtenerUbicacion() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    latitud = position.coords.latitude;
                    longitud = position.coords.longitude;
                    Livewire.emit('registrarUbicacion', latitud, longitud);
                    console.log(`OK`);
                }, function(error) {
                    console.error("Error al obtener la ubicación:", error);
                    location.reload();
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                console.error("La geolocalización no está disponible en este navegador.");
            }
        }

        window.onload = function() {
            @if ($rondaejecutada_id)
                // Obtener la ubicación inmediatamente después de que la página haya cargado
                obtenerUbicacion();

                // Obtener la ubicación cada 1 minutos (60,000 milisegundos)
                setInterval(obtenerUbicacion, 90 * 1000);
            @endif
        };
    </script>
@endsection
