<div>
    @section('title')
    Ronda
    @endsection
    
    <!-- Header Corporativo -->
    <div class="patrol-header">
        <div class="container">
            <div class="header-navigation">
                <a href="{{ route('home') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="header-title">
                    <h1 class="title-text">RONDA DE VIGILANCIA</h1>
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
        @if ($designacion)
        <!-- Información de Asignación -->
        <div class="assignment-card">
            <div class="assignment-header">
                <i class="fas fa-building"></i>
                <span>Asignación Actual</span>
            </div>
            <div class="assignment-body">
                <div class="assignment-item">
                    <div class="assignment-label">Cliente</div>
                    <div class="assignment-value">{{ $designacion->turno->cliente->nombre }}</div>
                </div>
                <div class="assignment-item">
                    <div class="assignment-label">Turno</div>
                    <div class="assignment-value">{{ $designacion->turno->nombre }}</div>
                </div>
            </div>
        </div>
        @if ($diaLaboral)
        @if (!$puntoRegistrado)
        @if ($proxpunto)
        <!-- Sección del Punto de Control -->
        <div class="control-point-section">
            <div class="control-point-card" wire:ignore>
                <div class="control-point-header">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="control-point-info">
                        <h5 class="control-point-title">Próximo Punto de Control</h5>
                        <p class="control-point-time">Programado: {{ $proxpunto->hora }}</p>
                    </div>
                    <div class="control-point-status">
                        <span class="status-badge">Pendiente</span>
                    </div>
                </div>
                <div class="control-point-body">
                    <div class="map-container">
                        <div id="mapa" class="patrol-map"></div>
                        <div id="geoButton" class="geo-button-container" style="display: none;">
                            <button class="geo-activation-button" onclick="solicitarUbicacion()">
                                <i class="fas fa-location-arrow"></i>
                                <span>Activar Mi Ubicación</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Información de Ubicación -->
            <div id="infoUbicacion" class="location-info-section d-none" wire:ignore.self>
                <div class="location-info-card">
                    <div class="location-info-header">
                        <i class="fas fa-map-pin"></i>
                        <span>Información de Ubicación</span>
                    </div>
                    <div class="location-info-body">
                        <div class="location-name">
                            <input type="text" class="location-input" wire:model='nombre' readonly placeholder="Nombre del punto">
                        </div>
                        <div class="coordinates-grid">
                            <div class="coordinate-item">
                                <label class="coordinate-label">Latitud</label>
                                <input type="text" class="coordinate-input" wire:model='lat' readonly>
                            </div>
                            <div class="coordinate-item">
                                <label class="coordinate-label">Longitud</label>
                                <input type="text" class="coordinate-input" wire:model='lng' readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Registro -->
            <div class="registration-section" id="divMarcarArribo" wire:ignore.self>
                <div class="notes-card">
                    <div class="notes-header">
                        <i class="fas fa-edit"></i>
                        <span>Anotaciones del Punto</span>
                    </div>
                    <div class="notes-body">
                        <textarea class="notes-textarea" wire:model.debounce.800ms='anotaciones' 
                                placeholder="Ingrese sus observaciones sobre este punto de control..."></textarea>
                    </div>
                </div>

                <div class="multimedia-card">
                    <div class="multimedia-header">
                        <i class="fas fa-camera"></i>
                        <span>Evidencia Multimedia</span>
                    </div>
                    <div class="multimedia-body">
                        <input class="multimedia-input" type="file" id="files" multiple 
                               accept="image/*,audio/*,video/*" wire:model='files'>
                        @foreach ($files as $file)
                        @error('file')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                        @endforeach
                        
                        @if ($files)
                        <div class="preview-section">
                            <span class="preview-label">Vista previa:</span>
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

                <div class="submit-section">
                    <button class="patrol-submit-button" wire:click='regRonda' wire:loading.attr='disabled'>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Registrar Punto de Control</span>
                    </button>
                </div>
            </div>
        </section>
        @else
        <!-- Estado: No hay más puntos -->
        <div class="status-card success-status">
            <div class="status-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="status-content">
                <h6 class="status-title">Ronda Completada</h6>
                <p class="status-message">No existen más puntos de control pendientes.</p>
            </div>
        </div>
        @endif
        @else
        <!-- Estado: Punto ya registrado -->
        <div class="status-card warning-status">
            <div class="status-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="status-content">
                <h6 class="status-title">Punto Ya Registrado</h6>
                <p class="status-message">Este punto de control ya fue registrado anteriormente.</p>
            </div>
        </div>
        @endif
        @else
        <!-- Estado: Día no laborable -->
        <div class="status-card warning-status">
            <div class="status-icon">
                <i class="fas fa-calendar-times"></i>
            </div>
            <div class="status-content">
                <h6 class="status-title">Día No Laborable</h6>
                <p class="status-message">Hoy no es día laborable para esta designación.</p>
            </div>
        </div>
        @endif
        @else
        <!-- Estado: Sin asignaciones -->
        <div class="status-card error-status">
            <div class="status-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="status-content">
                <h6 class="status-title">Sin Asignaciones</h6>
                <p class="status-message">No existen asignaciones habilitadas para su usuario.</p>
            </div>
        </div>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCamara" tabindex="-1" aria-labelledby="modalCamaraLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCamaraLabel">Lector de QR</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrarCamara()"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <a id="btn-scan-qr" href="#">
                            <img src="https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg"
                                class="img-fluid text-center" width="175">
                        </a>
                        <canvas hidden="" id="qr-canvas" class="img-fluid"></canvas>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeModal" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="cerrarCamara()"><i class="fas fa-times-circle"></i> Cerrar</button>

                </div>
            </div>
        </div>
    </div>
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
        --info-color: #0891b2;            /* Azul información */
        --surface-color: #ffffff;
        --background-color: #f8fafc;      /* Gris muy claro */
        --on-surface: #1e293b;            /* Texto principal */
        --text-secondary: #64748b;        /* Texto secundario */
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
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
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
        
        .assignment-body, .location-info-body, .notes-body, .multimedia-body {
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
        
        .assignment-card, .control-point-card, .location-info-card, 
        .notes-card, .multimedia-card, .status-card {
            background: var(--surface-color);
            border-color: var(--secondary-color);
        }
        
        .header-navigation {
            background: rgba(30, 41, 59, 0.95);
        }
        
        .location-input, .coordinate-input, .notes-textarea, .multimedia-input {
            background: var(--surface-color);
            border-color: var(--secondary-color);
            color: var(--on-surface);
        }
    }
</style>
@endsection

@section('js')
<script src="{{ asset('vendor/qr/qrCode.min.js') }}"></script>
<script src="{{ asset('vendor/qr/index.js') }}"></script>
@if ($proxpunto)
<script>
    let map;
    let auxMarker;
    let controlMarker;

    function initMap() {
        var latitud = {{ $cliente->latitud ? $cliente->latitud : '-17.7817999' }};
        var longitud = {{ $cliente->longitud ? $cliente->longitud : '-63.1825485' }};

        try {
            map = new google.maps.Map(document.getElementById("mapa"), {
                zoom: 17,
                center: { lat: latitud, lng: longitud },
                mapId: "DEMO_MAP_ID"
            });

            // Crear marcador personalizado para el punto de control (rojo/azul por defecto)
            const controlMarkerImg = document.createElement('img');
            controlMarkerImg.src = "{{ asset('web/assets/img/home/ptctrl.png') }}";
            controlMarkerImg.style.width = '39px';
            controlMarkerImg.style.height = '39px';

            // Marcador del punto de control
            controlMarker = new google.maps.marker.AdvancedMarkerElement({
                position: { lat: {{ $proxpunto->latitud }}, lng: {{ $proxpunto->longitud }} },
                map: map,
                content: controlMarkerImg,
                title: 'Punto de Control - {{ $proxpunto->hora }}'
            });

            if (navigator.geolocation) {
                // Mostrar botón para que el usuario active la geolocalización
                document.getElementById('geoButton').style.display = 'block';
            } else {
                // Si no hay soporte de geolocalización, mostrar mensaje
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-warning mt-2';
                alertDiv.innerHTML = '<small><i class="fas fa-exclamation-triangle"></i> Su navegador no soporta geolocalización.</small>';
                document.getElementById("mapa").parentNode.appendChild(alertDiv);
            }
        } catch (e) {
            console.error('Error al cargar Google Maps:', e);
            document.getElementById("mapa").innerHTML = '<div class="alert alert-warning">No se pudo cargar el mapa. Verifique que no tenga bloqueadores de anuncios activos.</div>';
        }
    }

    function success(geoLocationPosition) {
        let data = [
            geoLocationPosition.coords.latitude,
            geoLocationPosition.coords.longitude,
        ];

        try {
            // Crear marcador con icono de guardia de seguridad para mi ubicación actual
            const guardMarkerImg = document.createElement('img');
            guardMarkerImg.src = "{{ asset('web/assets/img/home/guard.png') }}";
            guardMarkerImg.style.width = '35px';
            guardMarkerImg.style.height = '35px';

            // Si ya existe un marcador de ubicación, removerlo
            if (auxMarker) {
                auxMarker.map = null;
            }

            // Crear nuevo marcador para mi ubicación
            auxMarker = new google.maps.marker.AdvancedMarkerElement({
                position: { lat: data[0], lng: data[1] },
                map: map,
                content: guardMarkerImg,
                title: 'Mi Ubicación - Guardia de Seguridad'
            });

            // Enviar datos a Livewire
            Livewire.emit('ubicacionAprox', data);
            
            // Ajustar el mapa para mostrar ambos marcadores
            const bounds = new google.maps.LatLngBounds();
            bounds.extend({ lat: {{ $proxpunto->latitud }}, lng: {{ $proxpunto->longitud }} });
            bounds.extend({ lat: data[0], lng: data[1] });
            map.fitBounds(bounds);
            
            // Asegurar un zoom mínimo
            google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                if (map.getZoom() > 18) {
                    map.setZoom(18);
                }
            });

        } catch (e) {
            console.error('Error al crear marcador:', e);
        }
    }

    function error(err) {
        let mensaje = '';
        switch(err.code) {
            case err.PERMISSION_DENIED:
                mensaje = "Permita el acceso a su ubicación para continuar.";
                break;
            case err.POSITION_UNAVAILABLE:
                mensaje = "No se pudo obtener su ubicación. Verifique su GPS/WiFi.";
                break;
            case err.TIMEOUT:
                mensaje = "Tiempo agotado al obtener ubicación.";
                break;
            default:
                mensaje = "Error desconocido al obtener la ubicación.";
                break;
        }
        console.warn('Error de geolocalización:', mensaje, err);
        
        // Mostrar mensaje con opción de reintentar
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning mt-2';
        alertDiv.innerHTML = `
            <small><i class="fas fa-exclamation-triangle"></i> ${mensaje}</small><br>
            <button class="btn btn-sm btn-primary mt-1" onclick="reintentar()">
                <i class="fas fa-location-arrow"></i> Reintentar
            </button>
        `;
        
        const mapaContainer = document.getElementById("mapa").parentNode;
        if (mapaContainer && !mapaContainer.querySelector('.alert-warning')) {
            mapaContainer.appendChild(alertDiv);
        }
    }

    // Función para solicitar ubicación cuando el usuario hace clic
    window.solicitarUbicacion = function() {
        // Ocultar el botón
        document.getElementById('geoButton').style.display = 'none';
        
        if (navigator.geolocation) {
            const options = {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 60000
            };
            navigator.geolocation.getCurrentPosition(success, error, options);
        }
    };

    // Función para reintentar geolocalización
    window.reintentar = function() {
        // Remover alertas
        document.querySelectorAll('.alert-warning').forEach(alert => alert.remove());
        
        // Mostrar el botón nuevamente
        document.getElementById('geoButton').style.display = 'block';
    };

    // Cargar Google Maps
    const script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps.api_key') }}&loading=async&libraries=marker&callback=initMap';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
</script>
@endif

<script>
    Livewire.on('resultadoQr', () => {

            // div1 = document.getElementById('btnUbicacion');
            // div1.classList.add("d-none");

            // div2 = document.getElementById('infoUbicacion');
            // div2.classList.remove('d-none')

            // div3 = document.getElementById('divMarcarArribo');
            // div3.classList.remove('d-none')
        });
</script>
@endsection