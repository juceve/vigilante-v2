@extends('layouts.app')

@section('template_title')
    {{ $tipopase->name ?? "{{ __('Show') Tipopase" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Tipopase</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('tipopases.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $tipopase->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $tipopase->descripcion }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $tipopase->estado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
