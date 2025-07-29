@extends('adminlte::page')

@section('title')
    Información Cliente
@endsection
@section('content_header')
    <h4>Información Cliente</h4>
@endsection
@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Datos Cliente
                            </span>

                            <div class="float-right">
                                <a href="javascript:history.back()" class="btn btn-info btn-sm float-right"
                                    data-placement="left">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <strong>Nombre:</strong>
                                    {{ $cliente->nombre }}
                                </div>
                                <div class="form-group">
                                    <strong>Tipo Documento:</strong>
                                    {{ $cliente->tipodocumento->name }}
                                </div>
                                <div class="form-group">
                                    <strong>Nro. Documento:</strong>
                                    {{ $cliente->nrodocumento }}
                                </div>
                                <div class="form-group">
                                    <strong>Dirección:</strong>
                                    {{ $cliente->direccion }}
                                </div>
                                <div class="form-group">
                                    <strong>U.V.:</strong>
                                    {{ $cliente->uv }}
                                </div>
                                <div class="form-group">
                                    <strong>Manzano:</strong>
                                    {{ $cliente->manzano }}
                                </div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <strong>Persona Contacto:</strong>
                                    {{ $cliente->personacontacto }}
                                </div>
                                <div class="form-group">
                                    <strong>Teléfono Contacto:</strong>
                                    {{ $cliente->telefonocontacto }}
                                </div>
                                <div class="form-group">
                                    <strong>Oficina Vinculada:</strong>
                                    {{ $cliente->oficina->nombre }}
                                </div>
                                <div class="form-group">
                                    <strong>Observaciones:</strong>
                                    {{ $cliente->observaciones }}
                                </div>
                                <div class="form-group">
                                    <strong>Estado:</strong>
                                    @if ($cliente->status)
                                        <span class="badge badge-pill badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-pill badge-secondary">Inactivo</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-none">
                            <strong>Latitud:</strong>
                            {{ $cliente->latitud }}
                        </div>
                        <div class="form-group d-none">
                            <strong>Longitud:</strong>
                            {{ $cliente->longitud }}
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mapa">Ubicación del Domicilio:</label>
                            <div id="mi_mapa" class="border" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection

@section('plugins.OpenStreetMap', true)
@section('js')
    <script>
        let map = L.map('mi_mapa').setView([{{ $cliente->latitud }}, {{ $cliente->longitud }}], 17)

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy;'
        }).addTo(map);


        var myIcon = L.icon({
            iconUrl: "{{ asset('images/punt.png') }}",
            iconSize: [35, 35],
            iconAnchor: [35, 35],
            popupAnchor: [-15, -30],
        });

        L.marker([{{ $cliente->latitud }}, {{ $cliente->longitud }}]).addTo(map);
        // map.on('click', onMapClick)

        // function onMapClick(e) {
        //     alert("Posición: " + e.latlng)
        // }
    </script>
@endsection
