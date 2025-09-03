@extends('layouts.app')

@section('template_title')
    {{ $paseingreso->name ?? "{{ __('Show') Paseingreso" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Paseingreso</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('paseingresos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Residencia Id:</strong>
                            {{ $paseingreso->residencia_id }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $paseingreso->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Cedula:</strong>
                            {{ $paseingreso->cedula }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Inicio:</strong>
                            {{ $paseingreso->fecha_inicio }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Fin:</strong>
                            {{ $paseingreso->fecha_fin }}
                        </div>
                        <div class="form-group">
                            <strong>Tipopase Id:</strong>
                            {{ $paseingreso->tipopase_id }}
                        </div>
                        <div class="form-group">
                            <strong>Detalles:</strong>
                            {{ $paseingreso->detalles }}
                        </div>
                        <div class="form-group">
                            <strong>Url Foto:</strong>
                            {{ $paseingreso->url_foto }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
