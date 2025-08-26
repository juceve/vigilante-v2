@extends('layouts.app')

@section('template_title')
    {{ $residencia->name ?? "{{ __('Show') Residencia" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Residencia</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('residencias.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Cliente Id:</strong>
                            {{ $residencia->cliente_id }}
                        </div>
                        <div class="form-group">
                            <strong>Propietario Id:</strong>
                            {{ $residencia->propietario_id }}
                        </div>
                        <div class="form-group">
                            <strong>Cedula Propietario:</strong>
                            {{ $residencia->cedula_propietario }}
                        </div>
                        <div class="form-group">
                            <strong>Numeropuerta:</strong>
                            {{ $residencia->numeropuerta }}
                        </div>
                        <div class="form-group">
                            <strong>Piso:</strong>
                            {{ $residencia->piso }}
                        </div>
                        <div class="form-group">
                            <strong>Calle:</strong>
                            {{ $residencia->calle }}
                        </div>
                        <div class="form-group">
                            <strong>Nrolote:</strong>
                            {{ $residencia->nrolote }}
                        </div>
                        <div class="form-group">
                            <strong>Manzano:</strong>
                            {{ $residencia->manzano }}
                        </div>
                        <div class="form-group">
                            <strong>Notas:</strong>
                            {{ $residencia->notas }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $residencia->estado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
