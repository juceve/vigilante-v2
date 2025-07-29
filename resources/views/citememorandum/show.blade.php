@extends('layouts.app')

@section('template_title')
    {{ $citememorandum->name ?? "{{ __('Show') Citememorandum" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Citememorandum</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('citememorandums.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Correlativo:</strong>
                            {{ $citememorandum->correlativo }}
                        </div>
                        <div class="form-group">
                            <strong>Gestion:</strong>
                            {{ $citememorandum->gestion }}
                        </div>
                        <div class="form-group">
                            <strong>Cite:</strong>
                            {{ $citememorandum->cite }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $citememorandum->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Fechaliteral:</strong>
                            {{ $citememorandum->fechaliteral }}
                        </div>
                        <div class="form-group">
                            <strong>Empleado:</strong>
                            {{ $citememorandum->empleado }}
                        </div>
                        <div class="form-group">
                            <strong>Empleado Id:</strong>
                            {{ $citememorandum->empleado_id }}
                        </div>
                        <div class="form-group">
                            <strong>Cuerpo:</strong>
                            {{ $citememorandum->cuerpo }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $citememorandum->estado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
