@extends('layouts.app')

@section('template_title')
    {{ $citecobro->name ?? "{{ __('Show') Citecobro" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Citecobro</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('citecobros.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Correlativo:</strong>
                            {{ $citecobro->correlativo }}
                        </div>
                        <div class="form-group">
                            <strong>Gestion:</strong>
                            {{ $citecobro->gestion }}
                        </div>
                        <div class="form-group">
                            <strong>Cite:</strong>
                            {{ $citecobro->cite }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $citecobro->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Fechaliteral:</strong>
                            {{ $citecobro->fechaliteral }}
                        </div>
                        <div class="form-group">
                            <strong>Cliente:</strong>
                            {{ $citecobro->cliente }}
                        </div>
                        <div class="form-group">
                            <strong>Cliente Id:</strong>
                            {{ $citecobro->cliente_id }}
                        </div>
                        <div class="form-group">
                            <strong>Representante:</strong>
                            {{ $citecobro->representante }}
                        </div>
                        <div class="form-group">
                            <strong>Mescobro:</strong>
                            {{ $citecobro->mescobro }}
                        </div>
                        <div class="form-group">
                            <strong>Factura:</strong>
                            {{ $citecobro->factura }}
                        </div>
                        <div class="form-group">
                            <strong>Monto:</strong>
                            {{ $citecobro->monto }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
