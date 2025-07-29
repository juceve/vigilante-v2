@extends('layouts.app')

@section('template_title')
    {{ $citecotizacion->name ?? "{{ __('Show') Citecotizacion" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Citecotizacion</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('citecotizacions.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Correlativo:</strong>
                            {{ $citecotizacion->correlativo }}
                        </div>
                        <div class="form-group">
                            <strong>Gestion:</strong>
                            {{ $citecotizacion->gestion }}
                        </div>
                        <div class="form-group">
                            <strong>Cite:</strong>
                            {{ $citecotizacion->cite }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $citecotizacion->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Fechaliteral:</strong>
                            {{ $citecotizacion->fechaliteral }}
                        </div>
                        <div class="form-group">
                            <strong>Destinatario:</strong>
                            {{ $citecotizacion->destinatario }}
                        </div>
                        <div class="form-group">
                            <strong>Cargo:</strong>
                            {{ $citecotizacion->cargo }}
                        </div>
                        <div class="form-group">
                            <strong>Monto:</strong>
                            {{ $citecotizacion->monto }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $citecotizacion->estado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
