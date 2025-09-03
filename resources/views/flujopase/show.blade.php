@extends('layouts.app')

@section('template_title')
    {{ $flujopase->name ?? "{{ __('Show') Flujopase" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Flujopase</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('flujopases.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Paseingreso Id:</strong>
                            {{ $flujopase->paseingreso_id }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $flujopase->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $flujopase->tipo }}
                        </div>
                        <div class="form-group">
                            <strong>Hora:</strong>
                            {{ $flujopase->hora }}
                        </div>
                        <div class="form-group">
                            <strong>User Id:</strong>
                            {{ $flujopase->user_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
