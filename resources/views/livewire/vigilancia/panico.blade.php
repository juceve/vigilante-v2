<div>
    @section('title')
    Pánico
    @endsection

    <!-- Header Corporativo -->
    <div class="panic-header">
        <div class="container">
            <div class="header-navigation">
                <a href="{{ route('home') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="header-title">
                    <h3 class="title-text">SISTEMA DE PÁNICO</h3>
                    <p class="subtitle-text">Emergencia y Seguridad</p>
                </div>
                <div class="header-status">
                    <span class="status-indicator"></span>
                </div>
            </div>
        </div>
    </div>
    <section class="panic-content">
        <!-- Botón de Emergencia Principal -->
        <div class="emergency-section">
            <div class="emergency-card">
                <button class="emergency-button" id="button-call">
                    <div class="emergency-icon">
                        <img class="emergency-image temblor greyscale" src="{{ asset('web/assets/img/home/em-call.png') }}"
                            alt="Llamada Emergencia" id="telephone">
                    </div>
                    <div class="emergency-content">
                        <h4 class="emergency-title" id="llamada-emergencia">
                            Llamada automática en <span class="countdown" id="numero">5</span>
                        </h4>
                        <p class="emergency-subtitle">Toque para cancelar</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Botón de Llamada Manual -->
        <div class="call-section">
            <div class="call-card">
                <a class="call-button" href="tel:+591{{$parametrosgenerales->telefono_panico}}" id="llamar" onclick="llamada()">
                    <div class="call-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="call-content">
                        <h5>Llamar a Central</h5>
                        <p>Contacto directo de emergencia</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Información de Pánico -->
        <div class="info-section">
            <div class="info-header">
                <h4 class="info-title">INFORMACIÓN DE PÁNICO</h4>
                <p class="info-subtitle">Complete los detalles del incidente</p>
            </div>

            <div class="info-content">
                <div class="row">
                    <!-- Multimedia -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="media-card">
                            <div class="card-header">
                                <i class="fas fa-camera"></i>
                                <span>Multimedia</span>
                            </div>
                            <div class="card-body">
                                <input class="file-input" type="file" id="files" multiple accept="image/*,audio/*"
                                    wire:model='files'>
                                @foreach ($files as $file)
                                @error('file')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                                @endforeach

                                @if ($files)
                                <div class="preview-section">
                                    <small class="preview-label">Vista previa:</small>
                                    <div class="preview-grid">
                                        @foreach ($files as $file)
                                        <div class="preview-item">
                                            <img src="{{ $file->temporaryUrl() }}" class="preview-image">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informe -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="report-card">
                            <div class="card-header">
                                <i class="fas fa-file-alt"></i>
                                <span>Informe</span>
                            </div>
                            <div class="card-body">
                                <textarea class="report-textarea" id="txtinforme"
                                    placeholder="Describa brevemente la situación de emergencia..."
                                    wire:model.lazy='informe'></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Envío -->
        <div class="submit-section">
            <button class="submit-button" id="enviar">
                <span class="submit-text">ENVIAR REPORTE</span>
                <i class="fas fa-paper-plane submit-icon"></i>
            </button>
        </div>

    </section>
</div>
@section('css')
<style>
    /* Variables CSS - Paleta Empresarial de Seguridad */
    :root {
        --primary-color: #1e3a8a;          /* Azul naval profundo */
        --primary-dark: #1e293b;           /* Azul oscuro casi negro */
        --primary-light: #3b82f6;          /* Azul corporativo */
        --secondary-color: #334155;        /* Gris azulado */
        --secondary-dark: #1e293b;         /* Gris oscuro */
        --accent-color: #d97706;           /* Dorado corporativo */
        --accent-light: #f59e0b;          /* Dorado claro */
        --success-color: #059669;          /* Verde profesional */
        --warning-color: #d97706;          /* Naranja dorado */
        --error-color: #dc2626;           /* Rojo corporativo */
        --emergency-color: #dc2626;        /* Rojo emergencia */
        --info-color: #0891b2;            /* Azul información */
        --surface-color: #ffffff;
        --background-color: #f8fafc;      /* Gris muy claro */
        --on-surface: #1e293b;            /* Texto principal */
        --text-secondary: #64748b;        /* Texto secundario */
        --shadow-light: 0 2px 8px rgba(30, 41, 59, 0.1);
        --shadow-medium: 0 4px 16px rgba(30, 41, 59, 0.15);
        --shadow-heavy: 0 8px 24px rgba(30, 41, 59, 0.2);
        --shadow-emergency: 0 4px 20px rgba(220, 38, 38, 0.3);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Estilos Generales */
    body {
        background-color: var(--background-color);
        font-family: 'Montserrat', sans-serif;
    }

    /* Header Corporativo */
    .panic-header {
        background: linear-gradient(135deg, var(--emergency-color), #b91c1c);
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
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
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
        background: var(--emergency-color);
        border-radius: 50%;
        animation: pulse-emergency 2s infinite;
    }

    /* Contenido Principal */
    .panic-content {
        padding: 0 1rem;
        max-width: 800px;
        margin: 0 auto;
    }

    /* Sección de Emergencia */
    .emergency-section {
        margin-bottom: 2rem;
    }

    .emergency-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-emergency);
        border: 3px solid var(--emergency-color);
        text-align: center;
    }

    .emergency-button {
        background: none;
        border: none;
        width: 100%;
        cursor: pointer;
        transition: var(--transition);
    }

    .emergency-button:hover {
        transform: translateY(-2px);
    }

    .emergency-button:disabled {
        opacity: 0.6;
        transform: none;
    }

    .emergency-icon {
        margin-bottom: 1.5rem;
    }

    .emergency-image {
        width: 80px;
        height: 80px;
        filter: none;
        transition: var(--transition);
    }

    .emergency-image.greyscale {
        filter: grayscale(100%);
    }

    .emergency-title {
        color: var(--emergency-color);
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }

    .countdown {
        background: var(--emergency-color);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        font-weight: 800;
        animation: pulse-countdown 1s infinite;
    }

    .emergency-subtitle {
        color: var(--primary-color);
        font-weight: 600;
        margin: 0;
        font-size: 0.95rem;
    }

    /* Sección de Llamada */
    .call-section {
        margin-bottom: 2rem;
    }

    .call-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        overflow: hidden;
        border: 2px solid var(--primary-color);
    }

    .call-button {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        text-decoration: none;
        transition: var(--transition);
        width: 100%;
    }

    .call-button:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary-dark));
        color: white;
        transform: translateY(-1px);
        box-shadow: var(--shadow-medium);
    }

    .call-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .call-content h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .call-content p {
        margin: 0.3rem 0 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    /* Sección de Información */
    .info-section {
        margin-bottom: 2rem;
    }

    .info-header {
        text-align: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        border-left: 4px solid var(--accent-color);
    }

    .info-title {
        color: var(--on-surface);
        font-weight: 700;
        margin: 0;
        font-size: 1.2rem;
        letter-spacing: 0.5px;
    }

    .info-subtitle {
        color: var(--text-secondary);
        margin: 0.5rem 0 0 0;
        font-weight: 500;
    }

    /* Tarjetas de Información */
    .media-card, .report-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        overflow: hidden;
        height: 100%;
        border: 2px solid #e2e8f0;
        transition: var(--transition);
    }

    .media-card:hover, .report-card:hover {
        border-color: var(--accent-color);
        box-shadow: var(--shadow-medium);
    }

    .card-header {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .card-header i {
        font-size: 1.1rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Input de Archivo */
    .file-input {
        width: 100%;
        padding: 0.8rem;
        border: 2px dashed var(--accent-color);
        border-radius: 12px;
        background: rgba(217, 119, 6, 0.05);
        color: var(--on-surface);
        font-family: 'Montserrat', sans-serif;
        transition: var(--transition);
    }

    .file-input:focus {
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
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 0.8rem;
        margin-top: 0.8rem;
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

    /* Textarea del Reporte */
    .report-textarea {
        width: 100%;
        min-height: 120px;
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

    .report-textarea:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
    }

    .report-textarea::placeholder {
        color: var(--text-secondary);
        font-style: italic;
    }

    /* Botón de Envío */
    .submit-section {
        margin-bottom: 2rem;
    }

    .submit-button {
        width: 100%;
        background: linear-gradient(135deg, var(--success-color), #047857);
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
        box-shadow: 0 4px 16px rgba(5, 150, 105, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
    }

    .submit-button:hover {
        background: linear-gradient(135deg, #047857, #065f46);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
    }

    .submit-button:active {
        transform: translateY(0);
    }

    .submit-icon {
        font-size: 1.1rem;
    }

    /* Error Messages */
    .error-message {
        color: var(--error-color);
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: 0.5rem;
        display: block;
    }

    /* Animaciones */
    .temblor {
        animation: shake 2s infinite;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
        20%, 40%, 60%, 80% { transform: translateX(3px); }
    }

    @keyframes pulse-emergency {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
    }

    @keyframes pulse-countdown {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .panic-content {
            padding: 0 0.5rem;
        }

        .header-navigation {
            padding: 0.8rem 1rem;
        }

        .title-text {
            font-size: 1.1rem;
        }

        .emergency-card {
            padding: 1.5rem;
        }

        .emergency-image {
            width: 60px;
            height: 60px;
        }

        .emergency-title {
            font-size: 1.1rem;
        }

        .call-button {
            padding: 1rem;
        }

        .call-icon {
            width: 50px;
            height: 50px;
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

        .emergency-card, .call-card, .media-card, .report-card, .info-header {
            background: var(--surface-color);
            border-color: var(--secondary-color);
        }

        .header-navigation {
            background: rgba(30, 41, 59, 0.95);
        }

        .file-input, .report-textarea {
            background: var(--surface-color);
            border-color: var(--secondary-color);
            color: var(--on-surface);
        }

        .file-input:focus, .report-textarea:focus {
            border-color: var(--accent-color);
        }
    }
</style>
@endsection

@section('js')
<script>
    const button = document.getElementById('button-call');
        const buttonEnviar = document.getElementById('enviar');

        button.addEventListener('click', () => {
            button.disabled = true;
            // var telefono = document.getElementById('telephone');
            var telefono = '{{$parametrosgenerales->telefono_panico}}';
            telefono.classList.remove('temblor');
            telefono.classList.add('greyscale');
        });


        buttonEnviar.addEventListener('click', () => {
            paso1();
            // console.log('paso 1 activo');
        });


        var contador = 5;
        var numero = document.getElementById('numero');
        var llamar = document.getElementById('llamar');

        function iniciarContador() {

            let intervalo = setInterval(function() {
                console.log(contador);
                if (button.disabled == false) {
                    if (contador === 1) {
                        clearInterval(intervalo);
                        contador--;
                        numero.innerText = contador;

                        if (navigator.geolocation) {
                            // navigator.geolocation.getCurrentPosition(success);
                            llamar.click();
                        } else {
                            console.log("Llamando");
                        }

                    } else {
                        contador--;

                        numero.innerText = contador;
                    }
                } else {
                    clearInterval(intervalo);
                }

            }, 1000);
        }

        function llamada() {
            button.disabled = true;
            // var telefono = document.getElementById('telephone');
            var telefono = '{{$parametrosgenerales->telefono_panico}}';
            telefono.classList.remove('temblor');
            telefono.classList.add('greyscale');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success);
            }else{
                console.log('No entro');
            }
        }

        function success(geoLocationPosition) {
            // console.log(geoLocationPosition.timestamp);
            let data = [
                geoLocationPosition.coords.latitude,
                geoLocationPosition.coords.longitude,
                'ALTA',
                'Llamada de Panico'
            ];
            Livewire.emit('guardarRegistro', data);
        }

        function success2(geoLocationPosition) {
            console.log(geoLocationPosition.timestamp);
            let data = [
                geoLocationPosition.coords.latitude,
                geoLocationPosition.coords.longitude,
            ];
            // console.log('registro Panico');
            Livewire.emit('registroPanico', data);
        }

        function paso1() {
            button.disabled = true;
            // var telefono = document.getElementById('telephone');
            var telefono = '{{$parametrosgenerales->telefono_panico}}';
            telefono.classList.remove('temblor');
            telefono.classList.add('greyscale');
            Swal.fire({
                title: 'Guardar Registro',
                text: "Está seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (navigator.geolocation) {
                        // console.log('enviando coord');
                        navigator.geolocation.getCurrentPosition(success2);
                    }
                }
            })

        }

        document.addEventListener('DOMContentLoaded', () => {
            iniciarContador();
        });
</script>
@endsection
