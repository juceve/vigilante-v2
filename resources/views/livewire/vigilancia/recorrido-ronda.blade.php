<div>
    @section('title')
        Recorrido de la Ronda
    @endsection

    <!-- Header Corporativo -->
    <div class="patrol-header">
        <div class="container">
            <div class="header-navigation">
                <a href="{{ route('home') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="header-title">
                    <h1 class="title-text">RONDA EN PROGRESO...</h1>
                    <p class="subtitle-text">Sistema de Control de Puntos</p>
                </div>
                <div class="header-status">
                    <div class="status-indicator"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contenido Principal -->
    <div class="patrol-content">
        <div class="alert alert-primary text-center" role="alert">
            INICIO: <i class="fas fa-calendar"></i>
            {{ \Carbon\Carbon::parse($ronda_ejecutada->inicio)->format('d/m/Y') }} <i class="fas fa-clock"></i>
            {{ \Carbon\Carbon::parse($ronda_ejecutada->inicio)->format('H:i:s') }}
        </div>

        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <strong>{{ $cliente->nombre }}</strong>
            </div>
            <div class="card-body">
                <div wire:ignore id="map" style="height: 500px;"></div>
            </div>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-danger p-2" onclick="finalizarRonda();">
                <i class="fas fa-street-view fa-2x"></i>
                <h5>FINALIZAR RONDA</h5>
            </button>
        </div>
        <br>
    </div>
</div>
@section('css')
    <style>
        /* Variables CSS - Paleta Empresarial de Seguridad */
        :root {
            --primary-color: #1e3a8a;
            /* Azul naval profundo */
            --primary-dark: #1e293b;
            /* Azul oscuro casi negro */
            --primary-light: #3b82f6;
            /* Azul corporativo */
            --secondary-color: #334155;
            /* Gris azulado */
            --secondary-dark: #1e293b;
            /* Gris oscuro */
            --accent-color: #d97706;
            /* Dorado corporativo */
            --accent-light: #f59e0b;
            /* Dorado claro */
            --success-color: #059669;
            /* Verde profesional */
            --warning-color: #d97706;
            /* Naranja dorado */
            --error-color: #dc2626;
            /* Rojo corporativo */
            --info-color: #0891b2;
            /* Azul información */
            --surface-color: #ffffff;
            --background-color: #f8fafc;
            /* Gris muy claro */
            --on-surface: #1e293b;
            /* Texto principal */
            --text-secondary: #64748b;
            /* Texto secundario */
            --shadow-light: 0 2px 8px rgba(30, 41, 59, 0.1);
            --shadow-medium: 0 4px 16px rgba(30, 41, 59, 0.15);
            --shadow-heavy: 0 8px 24px rgba(30, 41, 59, 0.2);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Estilos Generales */
        body {
            background-color: var(--background-color);
            font-family: 'Montserrat', sans-serif;
        }

        /* Header Corporativo */
        .patrol-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-medium);
        }

        .header-navigation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 1rem 1.5rem;
            box-shadow: var(--shadow-light);
        }

        .back-button {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            transition: var(--transition);
            box-shadow: var(--shadow-light);
        }

        .back-button:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-medium);
            color: white;
        }

        .header-title {
            text-align: center;
            flex: 1;
            margin: 0 1rem;
        }

        .title-text {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--on-surface);
            margin: 0;
            letter-spacing: 0.5px;
        }

        .subtitle-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin: 0.2rem 0 0 0;
            font-weight: 500;
        }

        .header-status {
            width: 50px;
            display: flex;
            justify-content: center;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            background: var(--success-color);
            border-radius: 50%;
            animation: pulse-patrol 2s infinite;
        }

        /* Contenido Principal */
        .patrol-content {
            padding: 0 1rem;
            max-width: 900px;
            margin: 0 auto;
        }

        /* Tarjeta de Asignación */
        .assignment-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            margin-bottom: 2rem;
            overflow: hidden;
            border: 2px solid var(--primary-color);
        }

        .assignment-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .assignment-header i {
            font-size: 1.2rem;
        }

        .assignment-body {
            padding: 1.5rem;
        }

        .assignment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .assignment-item:last-child {
            border-bottom: none;
        }

        .assignment-label {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .assignment-value {
            font-weight: 700;
            color: var(--on-surface);
            font-size: 1rem;
        }

        /* Sección del Punto de Control */
        .control-point-section {
            margin-bottom: 2rem;
        }

        .control-point-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            overflow: hidden;
            border: 2px solid var(--accent-color);
        }

        .control-point-header {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
            color: white;
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .control-point-header i {
            font-size: 1.3rem;
            margin-right: 0.5rem;
        }

        .control-point-info {
            flex: 1;
        }

        .control-point-title {
            margin: 0;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .control-point-time {
            margin: 0.3rem 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .control-point-status {
            display: flex;
            align-items: center;
        }

        .status-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .control-point-body {
            padding: 0;
        }

        /* Mapa */
        .map-container {
            position: relative;
        }

        .patrol-map {
            width: 100%;
            height: 350px;
            border: none;
        }

        .geo-button-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        .geo-activation-button {
            background: linear-gradient(135deg, var(--success-color), #047857);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(5, 150, 105, 0.3);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .geo-activation-button:hover {
            background: linear-gradient(135deg, #047857, #065f46);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        }

        /* Información de Ubicación */
        .location-info-section {
            margin-bottom: 1.5rem;
        }

        .location-info-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            overflow: hidden;
            border: 2px solid var(--info-color);
        }

        .location-info-header {
            background: linear-gradient(135deg, var(--info-color), #0e7490);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 600;
        }

        .location-info-body {
            padding: 1.5rem;
        }

        .location-name {
            margin-bottom: 1rem;
        }

        .location-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: var(--surface-color);
            color: var(--on-surface);
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            text-align: center;
            font-size: 1rem;
        }

        .coordinates-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .coordinate-item {
            display: flex;
            flex-direction: column;
        }

        .coordinate-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .coordinate-input {
            padding: 0.6rem 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: var(--surface-color);
            color: var(--on-surface);
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            text-align: center;
        }

        /* Sección de Registro */
        .registration-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Tarjeta de Notas */
        .notes-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            overflow: hidden;
            border: 2px solid var(--secondary-color);
        }

        .notes-header {
            background: linear-gradient(135deg, var(--secondary-color), var(--secondary-dark));
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 600;
        }

        .notes-body {
            padding: 1.5rem;
        }

        .notes-textarea {
            width: 100%;
            min-height: 100px;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            line-height: 1.5;
            color: var(--on-surface);
            background: var(--surface-color);
            transition: var(--transition);
            resize: vertical;
        }

        .notes-textarea:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(51, 65, 85, 0.1);
        }

        /* Tarjeta de Multimedia */
        .multimedia-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            overflow: hidden;
            border: 2px solid var(--accent-color);
        }

        .multimedia-header {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 600;
        }

        .multimedia-body {
            padding: 1.5rem;
        }

        .multimedia-input {
            width: 100%;
            padding: 0.8rem;
            border: 2px dashed var(--accent-color);
            border-radius: 12px;
            background: rgba(217, 119, 6, 0.05);
            color: var(--on-surface);
            font-family: 'Montserrat', sans-serif;
            transition: var(--transition);
        }

        .multimedia-input:focus {
            outline: none;
            border-color: var(--accent-light);
            background: rgba(217, 119, 6, 0.1);
        }

        /* Vista Previa */
        .preview-section {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .preview-label {
            color: var(--text-secondary);
            font-style: italic;
            font-weight: 500;
            margin-bottom: 0.8rem;
            display: block;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 0.8rem;
        }

        .preview-item {
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
        }

        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Botón de Envío */
        .submit-section {
            margin-bottom: 2rem;
        }

        .patrol-submit-button {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 1.2rem 2rem;
            border-radius: var(--border-radius);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(30, 58, 138, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
        }

        .patrol-submit-button:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary-dark));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }

        .patrol-submit-button:disabled {
            opacity: 0.6;
            transform: none;
            cursor: not-allowed;
        }

        /* Tarjetas de Estado */
        .status-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            border-left: 5px solid;
        }

        .status-card.success-status {
            border-left-color: var(--success-color);
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.05), rgba(5, 150, 105, 0.02));
        }

        .status-card.warning-status {
            border-left-color: var(--warning-color);
            background: linear-gradient(135deg, rgba(217, 119, 6, 0.05), rgba(217, 119, 6, 0.02));
        }

        .status-card.error-status {
            border-left-color: var(--error-color);
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.05), rgba(220, 38, 38, 0.02));
        }

        .status-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .success-status .status-icon {
            background: var(--success-color);
            color: white;
        }

        .warning-status .status-icon {
            background: var(--warning-color);
            color: white;
        }

        .error-status .status-icon {
            background: var(--error-color);
            color: white;
        }

        .status-content {
            flex: 1;
        }

        .status-title {
            margin: 0 0 0.5rem 0;
            font-weight: 700;
            color: var(--on-surface);
            font-size: 1.1rem;
        }

        .status-message {
            margin: 0;
            color: var(--text-secondary);
            font-weight: 500;
            line-height: 1.4;
        }

        /* Mensajes de Error */
        .error-message {
            color: var(--error-color);
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.5rem;
            display: block;
        }

        /* Animaciones */
        @keyframes pulse-patrol {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(1.1);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .patrol-content {
                padding: 0 0.5rem;
            }

            .header-navigation {
                padding: 0.8rem 1rem;
            }

            .title-text {
                font-size: 1.1rem;
            }

            .patrol-map {
                height: 280px;
            }

            .coordinates-grid {
                grid-template-columns: 1fr;
            }

            .control-point-header {
                padding: 1rem;
            }

            .assignment-body,
            .location-info_body,
            .notes-body,
            .multimedia-body {
                padding: 1rem;
            }

            .status-card {
                padding: 1.5rem;
                flex-direction: column;
                text-align: center;
            }

            .status-icon {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }
        }

        /* Modo Oscuro */
        @media (prefers-color-scheme: dark) {
            :root {
                --surface-color: #1e293b;
                --background-color: #0f172a;
                --on-surface: #e2e8f0;
                --text-secondary: #94a3b8;
            }

            body {
                background-color: var(--background-color);
                color: var(--on-surface);
            }

            .assignment-card,
            .control-point-card,
            .location-info-card,
            .notes-card,
            .multimedia-card,
            .status-card {
                background: var(--surface-color);
                border-color: var(--secondary-color);
            }

            .header-navigation {
                background: rgba(30, 41, 59, 0.95);
            }

            .location-input,
            .coordinate-input,
            .notes-textarea,
            .multimedia-input {
                background: var(--surface-color);
                border-color: var(--secondary-color);
                color: var(--on-surface);
            }
        }
    </style>
@endsection
@section('js')
    {{-- <script>
        let map;
        // Función para cargar el API de Google Maps
        function loadGoogleMapsApi() {
            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps.api_key') }}&libraries=places&loading=async&callback=initMap`;
            script.async = true;
            document.head.appendChild(script);
        }

        // Definir la función de inicialización que será llamada como callback
        window.initMap = function() {
            try {
                const clienteLat = {{ is_numeric($cliente->latitud) ? $cliente->latitud : -17.7833 }};
                const clienteLng = {{ is_numeric($cliente->longitud) ? $cliente->longitud : -63.1821 }};
                const centro = {
                    lat: parseFloat(clienteLat),
                    lng: parseFloat(clienteLng)
                };

                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 18,
                    center: centro,
                    mapTypeId: 'roadmap',
                    gestureHandling: 'greedy'
                });

                cargarPuntosExistentes();
            } catch (error) {
                console.error('Error al inicializar el mapa:', error);
            }
        }

        // Cargar el API cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', loadGoogleMapsApi);

        function cargarPuntosExistentes() {
            @foreach ($puntos as $punto)
                if ({{ $punto->latitud }} && {{ $punto->longitud }}) {
                    const position = {
                        lat: parseFloat({{ $punto->latitud }}),
                        lng: parseFloat({{ $punto->longitud }})
                    };
                    crearMarcadorPunto({{ $punto->id }}, position, "{{ $punto->descripcion }}");
                }
            @endforeach
        }

        function crearMarcadorPunto(id, position, descripcion) {
            const marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: {
                    url: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png', // Cambiado a HTTPS
                    scaledSize: new google.maps.Size(35, 35),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34)
                },
                title: descripcion,
                animation: google.maps.Animation.DROP
            });


        }
    </script> --}}

    <script>
        let map;
        let userMarker; // marcador del usuario
        let ultimaPosicion = null;
        // Función para cargar el API de Google Maps
        function loadGoogleMapsApi() {
            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps.api_key') }}&libraries=places&loading=async&callback=initMap`;
            script.async = true;
            document.head.appendChild(script);
        }

        // Definir la función de inicialización que será llamada como callback
        window.initMap = function() {
            try {
                const clienteLat = {{ is_numeric($cliente->latitud) ? $cliente->latitud : -17.7833 }};
                const clienteLng = {{ is_numeric($cliente->longitud) ? $cliente->longitud : -63.1821 }};
                const centro = {
                    lat: parseFloat(clienteLat),
                    lng: parseFloat(clienteLng)
                };

                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 18,
                    center: centro,
                    mapTypeId: 'roadmap',
                    gestureHandling: 'greedy'
                });

                cargarPuntosExistentes();
                iniciarGeolocalizacion(); // 👈 añadimos la geolocalización
            } catch (error) {
                console.error('Error al inicializar el mapa:', error);
            }
        }

        // Cargar el API cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', loadGoogleMapsApi);

        // Mostrar los puntos existentes
        function cargarPuntosExistentes() {
            @foreach ($puntos as $punto)
                if ({{ $punto->latitud }} && {{ $punto->longitud }}) {
                    const position = {
                        lat: parseFloat({{ $punto->latitud }}),
                        lng: parseFloat({{ $punto->longitud }})
                    };
                    crearMarcadorPunto({{ $punto->id }}, position, "{{ $punto->descripcion }}");
                }
            @endforeach
        }

        function crearMarcadorPunto(id, position, descripcion) {
            const marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: {
                    url: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                    scaledSize: new google.maps.Size(35, 35),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34)
                },
                title: descripcion,
                animation: google.maps.Animation.DROP
            });
        }

        // 📍 Mostrar y actualizar tu ubicación en tiempo real
        function iniciarGeolocalizacion() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    (pos) => {

                        ultimaPosicion = pos.coords; // 👈 guardamos siempre la última

                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        const position = {
                            lat: lat,
                            lng: lng
                        };
                        (err) => console.error("Error al obtener la ubicación:", err), {
                            enableHighAccuracy: false,
                            maximumAge: 10000
                        }

                        if (!userMarker) {
                            // Primer marcador de tu posición
                            userMarker = new google.maps.Marker({
                                position: position,
                                map: map,
                                icon: {
                                    url: "{{ asset('images/guardman.png') }}", // ícono guardia
                                    scaledSize: new google.maps.Size(48, 48), // tamaño
                                    anchor: new google.maps.Point(24, 24) // punto de anclaje al centro
                                },
                                title: "👮 Guardia en ronda"
                            });
                            map.setCenter(position);
                        } else {
                            // Actualiza la posición sin crear más marcadores
                            userMarker.setPosition(position);
                        }
                    },
                    (err) => {
                        console.error("Error al obtener la ubicación: ", err);
                    }, {
                        enableHighAccuracy: true,
                        maximumAge: 0,
                        timeout: 10000
                    }
                );
            } else {
                alert("Tu navegador no soporta geolocalización.");
            }
        }
    </script>
    <script>
        function finalizarRonda() {
            swal.fire({
                title: 'Finalizar Ronda',
                text: '¿Estás seguro de que deseas finalizar esta ronda?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, finalizar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.fire({
                        title: 'Finalizando el recorrido...',
                        text: 'Por favor espera unos segundos',
                        allowOutsideClick: false,
                        didOpen: () => {
                            swal.showLoading();
                        }
                    });
                    if (ultimaPosicion) {
                        Livewire.emit('finalizarRonda', ultimaPosicion.latitude, ultimaPosicion.longitude);
                    } else {
                        swal.fire({
                            title: 'Error',
                            text: 'No se pudo obtener tu ubicación. Intenta nuevamente.',
                            icon: 'error'
                        });
                    }
                }
            });
        }
    </script>
    {{-- <script>
        function finalizarRonda() {
            swal.fire({
                title: 'Finalizar Ronda',
                text: '¿Estás seguro de que deseas finalizar esta ronda?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, finalizar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.fire({
                        title: 'Finalizando el recorrido...',
                        text: 'Por favor espera unos segundos',
                        allowOutsideClick: false,
                        didOpen: () => {
                            swal.showLoading();
                        }
                    });
                    if ("geolocation" in navigator) {
                        navigator.geolocation.getCurrentPosition(function(position) {

                            const latitud = position.coords.latitude;
                            const longitud = position.coords.longitude;

                            Livewire.emit('finalizarRonda', latitud, longitud);
                        }, function(error) {
                            swal.fire({
                                title: 'Error',
                                text: 'No se pudo obtener tu ubicación. Permite el acceso a la ubicación e intenta nuevamente.',
                                icon: 'error'
                            });
                        });
                    } else {
                        swal.fire({
                            title: 'Error',
                            text: 'Tu dispositivo no soporta geolocalización',
                            icon: 'error'
                        });
                    }
                }
            });

        }
    </script> --}}
@endsection
