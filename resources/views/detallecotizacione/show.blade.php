@extends('layouts.app')

@section('template_title')
    {{ $detallecotizacione->name ?? "{{ __('Show') Detallecotizacione" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Detallecotizacione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('detallecotizaciones.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Citecotizacion Id:</strong>
                            {{ $detallecotizacione->citecotizacion_id }}
                        </div>
                        <div class="form-group">
                            <strong>Detalle:</strong>
                            {{ $detallecotizacione->detalle }}
                        </div>
                        <div class="form-group">
                            <strong>Cantidad:</strong>
                            {{ $detallecotizacione->cantidad }}
                        </div>
                        <div class="form-group">
                            <strong>Precio:</strong>
                            {{ $detallecotizacione->precio }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
