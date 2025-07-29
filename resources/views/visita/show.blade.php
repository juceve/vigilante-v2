@extends('layouts.app')

@section('template_title')
    {{ $visita->name ?? "{{ __('Show') Visita" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Visita</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('visitas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $visita->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Docidentidad:</strong>
                            {{ $visita->docidentidad }}
                        </div>
                        <div class="form-group">
                            <strong>Residente:</strong>
                            {{ $visita->residente }}
                        </div>
                        <div class="form-group">
                            <strong>Nrovivienda:</strong>
                            {{ $visita->nrovivienda }}
                        </div>
                        <div class="form-group">
                            <strong>Motivo Id:</strong>
                            {{ $visita->motivo_id }}
                        </div>
                        <div class="form-group">
                            <strong>Otros:</strong>
                            {{ $visita->otros }}
                        </div>
                        <div class="form-group">
                            <strong>Imgs:</strong>
                            {{ $visita->imgs }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $visita->estado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
