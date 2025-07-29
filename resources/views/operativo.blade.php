@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="container text-center " style="margin-top: 110px;">
    <h4 class="text-secondary">Bienvenido!</h4>
    <h1 style="color: #1abc9c"><strong>{{ Auth::user()->name }}</strong></h1>
</div>
<div class="container">
    @if ($designaciones)
    <div class="row">
        <div class="col-6">
            <small>Empresa: <b><span class="text-info">{{ $designaciones->turno->cliente->nombre }}</span></b></small>
        </div>
        <div class="col-6 text-end">
            <small>Turno: <b><span class="text-info">{{ $designaciones->turno->nombre }}</span></b></small>
        </div>
    </div>
    @endif
    <div class="container text-center mb-3">

    </div>
</div>
<hr>

@if ($designaciones)
@if (esDiaLibre($designaciones->id))
<div class="alert alert-success text-center" role="alert">
    HOY ES SU DIA LIBRE
</div>
@else
@if (yaMarque($designaciones->id))
@if (yaMarque($designaciones->id) == 1)
{{-- @dump(yaMarque($designaciones->id)) --}}
<section class="page-section portfolio p-0" id="portfolio">
    <div class="container">
        <!-- Portfolio Grid Items-->
        <div class="row justify-content-center">
            <!-- Portfolio Items -->
            <div class="col col-6 col-md-6 col-lg-4 mb-5">
                <div class="portfolio-item mx-auto border list-group-item-primary text-center">
                    <a href="{{ route('vigilancia.panico') }}">
                        <img class="w-50 py-4" src="{{ asset('web/assets/img/home/boton-rojo.png') }}" alt="..." />
                        <h6 class="text-primary">PANICO</h6>
                    </a>
                </div>
            </div>
            <div class="col col-6 col-md-6 col-lg-4 mb-5">
                <div class="portfolio-item mx-auto border list-group-item-primary text-center">
                    <a href="{{ route('vigilancia.ronda') }}">
                        <img class="w-50 py-4" src="{{ asset('web/assets/img/home/guardia.png') }}" alt="..." />
                        <h6 class="text-primary">RONDA</h6>
                    </a>
                </div>
            </div>
            <div class="col col-6 col-md-6 col-lg-4 mb-5">
                <div class="portfolio-item mx-auto border list-group-item-primary text-center">

                    @if (verificaTareas($designaciones->id))
                    <a href="{{route('vigilancia.tareas',$designaciones->id)}}">
                        <img class="w-50 py-4 temblor" src="{{ asset('web/assets/img/home/task.png') }}" alt="..." />

                        <img src="{{ asset('images/exclamation.png') }}" style="position:absolute;
                                                                            top:0px;
                                                                            left:0px;
                                                                            border:none;
                                                                            width: 50px;
                                                                            float: right" class="temblor">
                        <h6 class="text-primary">TAREAS</h6>
                    </a>
                    @else
                    <a href="{{ route('vigilancia.tareas',$designaciones->id) }}">
                        <img class="w-50 py-4" src="{{ asset('web/assets/img/home/task.png') }}" alt="..." />
                        <h6 class="text-primary">TAREAS</h6>
                    </a>
                    @endif
                </div>
            </div>
            <div class="col col-6 col-md-6 col-lg-4 mb-5">
                <div class="portfolio-item mx-auto border list-group-item-primary text-center">

                    @if ($intervalo = verificaHV($designaciones->id))
                    <a href="{{ route('vigilancia.hombre-vivo',$intervalo->id) }}">
                        <img class="w-50 py-4 temblor" src="{{ asset('web/assets/img/home/hombre-vivo.png') }}"
                            alt="..." />

                        <img src="{{ asset('images/exclamation.png') }}" style="position:absolute;
                                                                            top:0px;
                                                                            left:0px;
                                                                            border:none;
                                                                            width: 50px;
                                                                            float: right" class="temblor">
                        <h6 class="text-primary">HOMBRE VIVO</h6>
                    </a>
                    @else
                    <a href="{{ route('vigilancia.hombre-vivo',0) }}">
                        <img class="w-50 py-4" src="{{ asset('web/assets/img/home/hombre-vivo.png') }}" alt="..." />
                        <h6 class="text-primary">HOMBRE VIVO</h6>
                    </a>
                    @endif
                </div>
            </div>
            <div class="col col-6 col-md-6 col-lg-4 mb-5">
                <div class="portfolio-item mx-auto border list-group-item-primary text-center">
                    <a href="{{ route('vigilancia.panelvisitas',$designaciones->id) }}">
                        <img class="w-50 py-4" src="{{ asset('web/assets/img/home/regvisitas.png') }}" alt="..." />
                        <h6 class="text-primary">VISITAS</h6>
                    </a>
                </div>
            </div>

            <div class="col col-6 col-md-6 col-lg-4 mb-5">
                <div class="portfolio-item mx-auto border list-group-item-primary text-center">
                    <a href="{{ route('vigilancia.novedades',$designaciones->id) }}">
                        <img class="w-50 py-4" src="{{ asset('web/assets/img/home/news.png') }}" alt="..." />
                        <h6 class="text-primary">NOVEDADES</h6>
                    </a>
                </div>
            </div>
            <div class="col col-6 col-md-6 col-lg-4 mb-5">
                <div class="portfolio-item mx-auto border list-group-item-primary text-center">
                    <a href="{{ route('vigilancia.airbnb',$designaciones->id) }}">
                        <img class="w-50 py-4" src="{{ asset('web/assets/img/home/airbnb-logo.png') }}" alt="..." />
                        <h6 class="text-primary">AIRBNB</h6>
                    </a>
                </div>
            </div>
            {{-- End Portfolio Items --}}

        </div>
    </div>
    @livewire('vigilancia.marca-salida', ['designacione_id' => $designaciones->id])
</section>
@else
<div class="alert alert-warning text-center" role="alert">
    YA REGISTRÓ SU SALIDA.
</div>
@endif
@else
@livewire('vigilancia.marca-ingreso', ['designacione_id' => $designaciones->id])
@endif
<hr>
{{-- @if (yaMarque($designaciones->id))
@if (yaMarque($designaciones->id) > 1)

@endif
@endif --}}
@endif
@else
<div class="alert alert-danger text-center" role="alert">
    No exiten designaciones habilitadas.
</div>
<br>
{{-- @dump(Auth::user()->empleados[0]) --}}
@if (Auth::user()->empleados[0]->cubrerelevos)
<div class="container-fluid d-grid">
    <a href="{{route('vigilancia.cubrerelevos')}}" class="btn btn-success py-3">
        <h4>ACTIVAR RELEVO TEMPORAL <i class="fas fa-power-off"></i></h4>
    </a>
</div>
@endif
@endif


<script>
    setTimeout(() => {
            location.reload();
        }, 60000);
</script>
@endsection