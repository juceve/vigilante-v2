@extends('layouts.app')

@section('title', 'Panel Operativo')

@push('head')
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
@endpush

@section('content')
{{-- Header Minimalista --}}
<div class="minimal-header" style="margin-top: 85px;">
    <div class="container">
        <div class="header-content">
            <div class="user-section">
                <div class="user-avatar-mini">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="user-details">
                    <h4 class="user-name-mini">{{ Auth::user()->name }}</h4>
                    <div class="status-badge">
                        <i class="fas fa-circle"></i>
                        <span>En Servicio</span>
                    </div>
                </div>
            </div>
            @if ($designaciones)
            <div class="assignment-compact">
                <div class="assignment-item">
                    <i class="fas fa-building"></i>
                    <span>{{ Str::limit($designaciones->turno->cliente->nombre ?? 'No asignada', 20) }}</span>
                </div>
                <div class="assignment-item">
                    <i class="fas fa-clock"></i>
                    <span>{{ $designaciones->turno->nombre ?? 'No asignado' }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Lógica Principal de Designaciones --}}
@if ($designaciones)
    @php
        // Optimización: Calcular una sola vez los estados del empleado
        $esDiaLibreHoy = esDiaLibre($designaciones->id);
        $estadoMarcado = yaMarque($designaciones->id);
        $tieneTareasPendientes = verificaTareas($designaciones->id);
        $intervaloHV = verificaHV($designaciones->id);
    @endphp

    @if ($esDiaLibreHoy)
        {{-- Día Libre --}}
        <div class="alert-modern alert-success text-center">
            <div class="alert-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="alert-content">
                <h5>Día Libre</h5>
                <p>Hoy es tu día de descanso</p>
            </div>
        </div>
    @else
        @if ($estadoMarcado > 0)
            @if ($estadoMarcado == 1)
                {{-- Panel de Funciones Material Design --}}
                <div class="functions-container">
                    <div class="container-fluid px-3">
                        <div class="functions-grid">
                            {{-- Botón de Pánico --}}
                            <div class="function-card emergency-card">
                                <a href="{{ route('vigilancia.panico') }}" class="card-link">
                                    <div class="card-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="card-content">
                                        <h6 class="card-title">PÁNICO</h6>
                                        <p class="card-subtitle">Emergencia</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Ronda --}}
                            <div class="function-card primary-card">
                                <a href="{{ route('vigilancia.ronda') }}" class="card-link">
                                    <div class="card-icon">
                                        <i class="fas fa-walking"></i>
                                    </div>
                                    <div class="card-content">
                                        <h6 class="card-title">RONDA</h6>
                                        <p class="card-subtitle">Vigilancia</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Tareas --}}
                            <div class="function-card warning-card {{ $tieneTareasPendientes ? 'has-notification' : '' }}">
                                <a href="{{ route('vigilancia.tareas', $designaciones->id) }}" class="card-link">
                                    <div class="card-icon">
                                        <i class="fas fa-tasks"></i>
                                        @if ($tieneTareasPendientes)
                                            <span class="notification-badge pulse"></span>
                                        @endif
                                    </div>
                                    <div class="card-content">
                                        <h6 class="card-title">TAREAS</h6>
                                        <p class="card-subtitle">{{ $tieneTareasPendientes ? 'Pendientes' : 'Asignadas' }}</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Hombre Vivo --}}
                            <div class="function-card success-card {{ $intervaloHV ? 'has-notification' : '' }}">
                                @if ($intervaloHV)
                                    <a href="{{ route('vigilancia.hombre-vivo', $intervaloHV->id) }}" class="card-link">
                                @else
                                    <a href="{{ route('vigilancia.hombre-vivo', 0) }}" class="card-link">
                                @endif
                                    <div class="card-icon">
                                        <i class="fas fa-heartbeat"></i>
                                        @if ($intervaloHV)
                                            <span class="notification-badge pulse"></span>
                                        @endif
                                    </div>
                                    <div class="card-content">
                                        <h6 class="card-title">HOMBRE VIVO</h6>
                                        <p class="card-subtitle">{{ $intervaloHV ? 'Pendiente' : 'Disponible' }}</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Visitas --}}
                            <div class="function-card info-card">
                                <a href="{{ route('vigilancia.panelvisitas', $designaciones->id) }}" class="card-link">
                                    <div class="card-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="card-content">
                                        <h6 class="card-title">VISITAS</h6>
                                        <p class="card-subtitle">Registro</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Novedades --}}
                            <div class="function-card secondary-card">
                                <a href="{{ route('vigilancia.novedades', $designaciones->id) }}" class="card-link">
                                    <div class="card-icon">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <div class="card-content">
                                        <h6 class="card-title">NOVEDADES</h6>
                                        <p class="card-subtitle">Reportes</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Airbnb --}}
                            <div class="function-card airbnb-card">
                                <a href="{{ route('vigilancia.airbnb', $designaciones->id) }}" class="card-link">
                                    <div class="card-icon">
                                        <i class="fab fa-airbnb"></i>
                                    </div>
                                    <div class="card-content">
                                        <h6 class="card-title">AIRBNB</h6>
                                        <p class="card-subtitle">Gestión</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Componente de Marca Salida Estilizado --}}
                    <div class="checkout-section">
                        <div class="checkout-card">
                            <div class="checkout-header">
                                <i class="fas fa-sign-out-alt"></i>
                                <h5>Finalizar Turno</h5>
                            </div>
                            <p class="checkout-description">
                                Marca tu salida cuando hayas completado todas las tareas asignadas
                            </p>
                            <div class="checkout-component">
                                @livewire('vigilancia.marca-salida', ['designacione_id' => $designaciones->id])
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Ya registró salida --}}
                <div class="alert-modern alert-completed text-center">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <h5>Turno Completado</h5>
                        <p>Ya registró su salida exitosamente</p>
                    </div>
                </div>
            @endif
        @else
            {{-- Componente de Marca Ingreso --}}
            <div class="check-in-container">
                @livewire('vigilancia.marca-ingreso', ['designacione_id' => $designaciones->id])
            </div>
        @endif
    @endif
@else
    {{-- Sin Designaciones --}}
    <div class="alert-modern alert-error text-center">
        <div class="alert-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="alert-content">
            <h5>Sin Asignaciones</h5>
            <p>No existen designaciones habilitadas</p>
        </div>
    </div>

    {{-- Opción de Relevo Temporal --}}
    @if (Auth::user()->empleados[0]->cubrerelevos ?? false)
        <div class="relief-option">
            <a href="{{ route('vigilancia.cubrerelevos') }}" class="relief-button">
                <div class="relief-icon">
                    <i class="fas fa-power-off"></i>
                </div>
                <div class="relief-content">
                    <h5>Activar Relevo Temporal</h5>
                    <p>Cubrir turno de emergencia</p>
                </div>
            </a>
        </div>
    @endif
@endif

{{-- Estilos Material Design --}}
@push('styles')
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

    /* Header Minimalista */
    .minimal-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        padding: 1rem 0;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-light);
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: var(--shadow-light);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .user-section {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .user-avatar-mini {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        box-shadow: 0 2px 8px rgba(217, 119, 6, 0.3);
    }

    .user-details {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .user-name-mini {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--on-surface);
        margin: 0;
        line-height: 1.2;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        color: var(--success-color);
        font-weight: 500;
    }

    .status-badge i {
        font-size: 0.6rem;
        animation: pulse-dot 2s infinite;
    }

    .assignment-compact {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        text-align: right;
    }

    .assignment-item {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .assignment-item i {
        font-size: 0.7rem;
        color: var(--accent-color);
        width: 12px;
        text-align: center;
    }

    .assignment-item span {
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Grid de Funciones */
    .functions-container {
        padding: 0 1rem;
    }

    .functions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    /* Tarjetas de Función */
    .function-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        height: 120px; /* Altura fija para uniformidad */
        border: 2px solid transparent;
        /* Optimizaciones para touch */
        touch-action: manipulation; /* Evita delays y mejora responsividad */
        -webkit-tap-highlight-color: transparent; /* Quita highlight en iOS */
        user-select: none; /* Evita selección accidental */
    }

    .function-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-medium);
    }

    .function-card:active {
        transform: translateY(-2px);
    }

    .card-link {
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        color: inherit;
        padding: 1rem;
        justify-content: center;
        align-items: center;
        text-align: center;
        /* Optimizaciones para touch */
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .card-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        position: relative;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .card-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-title {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-subtitle {
        font-size: 0.75rem;
        margin: 0;
        opacity: 0.8;
        font-weight: 500;
    }

    /* Colores de las tarjetas */
    .emergency-card {
        border-color: var(--error-color);
    }
    .emergency-card .card-icon {
        background: linear-gradient(135deg, var(--error-color), #b91c1c);
        color: white;
    }
    .emergency-card .card-title {
        color: var(--error-color);
    }

    .primary-card {
        border-color: var(--primary-color);
    }
    .primary-card .card-icon {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
    }
    .primary-card .card-title {
        color: var(--primary-color);
    }

    .warning-card {
        border-color: var(--warning-color);
    }
    .warning-card .card-icon {
        background: linear-gradient(135deg, var(--warning-color), var(--accent-light));
        color: white;
    }
    .warning-card .card-title {
        color: var(--warning-color);
    }

    .success-card {
        border-color: var(--success-color);
    }
    .success-card .card-icon {
        background: linear-gradient(135deg, var(--success-color), #047857);
        color: white;
    }
    .success-card .card-title {
        color: var(--success-color);
    }

    .info-card {
        border-color: var(--info-color);
    }
    .info-card .card-icon {
        background: linear-gradient(135deg, var(--info-color), #0e7490);
        color: white;
    }
    .info-card .card-title {
        color: var(--info-color);
    }

    .secondary-card {
        border-color: var(--secondary-color);
    }
    .secondary-card .card-icon {
        background: linear-gradient(135deg, var(--secondary-color), var(--secondary-dark));
        color: white;
    }
    .secondary-card .card-title {
        color: var(--secondary-color);
    }

    .airbnb-card {
        border-color: var(--accent-color);
    }
    .airbnb-card .card-icon {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
        color: white;
    }
    .airbnb-card .card-title {
        color: var(--accent-color);
    }

    /* Notificaciones */
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        background: var(--error-color);
        border-radius: 50%;
        border: 2px solid white;
    }

    .pulse {
        animation: pulse-notification 1.5s infinite;
    }

    /* Alertas Modernas */
    .alert-modern {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-light);
        margin: 2rem 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-left: 4px solid;
    }

    .alert-completed {
        border-left-color: var(--success-color);
    }

    .alert-success {
        border-left-color: var(--success-color);
    }

    .alert-error {
        border-left-color: var(--error-color);
    }

    .alert-icon {
        font-size: 2.5rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .alert-completed .alert-icon {
        background: linear-gradient(135deg, var(--success-color), #047857);
        color: white;
    }

    .alert-success .alert-icon {
        background: linear-gradient(135deg, var(--success-color), #047857);
        color: white;
    }

    .alert-error .alert-icon {
        background: linear-gradient(135deg, var(--error-color), #b91c1c);
        color: white;
    }

    .alert-content h5 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .alert-content p {
        margin: 0;
        color: #666;
        font-weight: 500;
    }

    /* Botón de Relevo */
    .relief-option {
        margin: 2rem 1rem;
    }

    .relief-button {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, var(--success-color), #047857);
        color: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        box-shadow: var(--shadow-medium);
        transition: var(--transition);
        width: 100%;
    }

    .relief-button:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-heavy);
        color: white;
    }

    .relief-icon {
        font-size: 2rem;
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .relief-content h5 {
        font-weight: 700;
        margin-bottom: 0.3rem;
    }

    .relief-content p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    /* Sección de Marcar Salida */
    .checkout-section {
        margin: 2rem 1rem;
    }

    .checkout-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-light);
        border: 2px solid #f0f0f0;
        transition: var(--transition);
    }

    .checkout-card:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-medium);
    }

    .checkout-header {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1rem;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .checkout-header i {
        font-size: 1.5rem;
        color: var(--accent-color);
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, rgba(217, 119, 6, 0.1), rgba(217, 119, 6, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkout-header h5 {
        margin: 0;
        font-weight: 600;
        color: var(--on-surface);
        font-size: 1.1rem;
    }

    .checkout-description {
        color: var(--text-secondary);
        margin-bottom: 1.2rem;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .checkout-component {
        /* Estilos para el componente Livewire de marca salida */
    }

    /* Personalización para botones del componente Livewire */
    .checkout-component .btn {
        border-radius: 12px !important;
        font-weight: 600 !important;
        padding: 0.8rem 2rem !important;
        transition: var(--transition) !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        font-size: 0.9rem !important;
    }

    .checkout-component .btn-success {
        background: linear-gradient(135deg, var(--success-color), #047857) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3) !important;
    }

    .checkout-component .btn-success:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4) !important;
    }

    .checkout-component .btn-danger {
        background: linear-gradient(135deg, var(--error-color), #b91c1c) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3) !important;
    }

    .checkout-component .btn-danger:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4) !important;
    }

    .checkout-component .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3) !important;
    }

    .checkout-component .btn-primary:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4) !important;
    }

    /* Animaciones */
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    @keyframes pulse-notification {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* Responsivo */
    @media (min-width: 768px) {
        .functions-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .function-card {
            height: 140px;
        }
        
        .card-icon {
            font-size: 2.5rem;
            width: 60px;
            height: 60px;
        }
        
        .card-title {
            font-size: 1rem;
        }
        
        .card-subtitle {
            font-size: 0.8rem;
        }
    }

    @media (min-width: 1200px) {
        .functions-grid {
            grid-template-columns: repeat(4, 1fr);
            max-width: 1200px;
            margin: 0 auto 2rem auto;
        }
    }

    /* Modo oscuro */
    @media (prefers-color-scheme: dark) {
        .function-card {
            background: #1e293b;
            color: white;
            border-color: #334155;
        }
        
        .header-content {
            background: rgba(30, 41, 59, 0.95);
            color: white;
        }
        
        .user-name-mini {
            color: white;
        }
        
        .assignment-item {
            color: #94a3b8;
        }
        
        .checkout-card {
            background: #1e293b;
            color: white;
            border-color: #334155;
        }
        
        .checkout-header h5 {
            color: white;
        }
        
        .checkout-description {
            color: #94a3b8;
        }
        
        .alert-modern {
            background: #1e293b;
            color: white;
        }
        
        .alert-content h5 {
            color: white;
        }
        
        .alert-content p {
            color: #94a3b8;
        }
    }

    /* Responsivo para header minimalista */
    @media (max-width: 576px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .assignment-compact {
            text-align: center;
        }
        
        .assignment-item {
            justify-content: center;
            font-size: 0.75rem;
        }
        
        .user-name-mini {
            font-size: 1rem;
        }
        
        .checkout-header {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }
</style>
@endpush

{{-- JavaScript Optimizado Material Design --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh optimizado con visibilidad de página
        let refreshInterval;
        
        function startAutoRefresh() {
            refreshInterval = setTimeout(() => {
                // Solo refrescar si la página está visible
                if (!document.hidden) {
                    window.location.reload();
                } else {
                    // Si la página no está visible, reintentar en 10 segundos
                    startAutoRefresh();
                }
            }, 60000); // 60 segundos
        }
        
        // Manejar cambios de visibilidad de la página - passive
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Página oculta, pausar el refresh
                clearTimeout(refreshInterval);
            } else {
                // Página visible, reanudar el refresh
                startAutoRefresh();
            }
        }, { passive: true });
        
        // Efectos de interacción mejorados - optimizado para passive events
        const functionCards = document.querySelectorAll('.function-card');
        
        functionCards.forEach(card => {
            // Efecto de tap en móvil - passive para mejor rendimiento
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.95)';
            }, { passive: true });
            
            // Touch end para efecto visual - passive
            card.addEventListener('touchend', function() {
                this.style.transform = '';
            }, { passive: true });
            
            // Separar la lógica de prevención de zoom doble tap
            let touchTime = 0;
            card.addEventListener('touchstart', function(event) {
                // Solo prevenir zoom si hay múltiples toques rápidos
                if (event.touches.length > 1) return;
                
                const currentTime = new Date().getTime();
                const tapLength = currentTime - touchTime;
                
                if (tapLength < 300 && tapLength > 0) {
                    event.preventDefault();
                }
                touchTime = currentTime;
            }, { passive: false }); // NO passive solo para prevenir zoom
        });
        
        // Feedback háptico en dispositivos compatibles
        function provideFeedback() {
            if ('vibrate' in navigator) {
                navigator.vibrate(50); // Vibración corta
            }
        }
        
        // Agregar feedback a las tarjetas importantes - passive para mejor rendimiento
        const emergencyCard = document.querySelector('.emergency-card');
        const notificationCards = document.querySelectorAll('.has-notification');
        
        if (emergencyCard) {
            emergencyCard.addEventListener('click', provideFeedback, { passive: true });
        }
        
        notificationCards.forEach(card => {
            card.addEventListener('click', provideFeedback, { passive: true });
        });
        
        // Iniciar el auto-refresh
        startAutoRefresh();
        
        // Manejar errores de red para reintentar después - passive
        window.addEventListener('offline', function() {
            clearTimeout(refreshInterval);
            console.log('Aplicación sin conexión - pausando auto-refresh');
        }, { passive: true });
        
        window.addEventListener('online', function() {
            startAutoRefresh();
            console.log('Conexión restaurada - reanudando auto-refresh');
        }, { passive: true });
        
        // Mejora de accesibilidad - keydown requiere preventDefault así que NO passive
        const cards = document.querySelectorAll('.card-link');
        cards.forEach(card => {
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            }); // Sin passive porque usamos preventDefault
        });
        
        // Animación de entrada progresiva
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                }
            });
        });
        
        // Aplicar animación de entrada a las tarjetas
        functionCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    });
</script>
@endpush
@endsection