@extends('layouts.app')

@section('template_title')
    {{ $citerecibo->name ?? "{{ __('Show') Citerecibo" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Citerecibo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('citerecibos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Correlativo:</strong>
                            {{ $citerecibo->correlativo }}
                        </div>
                        <div class="form-group">
                            <strong>Gestion:</strong>
                            {{ $citerecibo->gestion }}
                        </div>
                        <div class="form-group">
                            <strong>Cite:</strong>
                            {{ $citerecibo->cite }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $citerecibo->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Fechaliteral:</strong>
                            {{ $citerecibo->fechaliteral }}
                        </div>
                        <div class="form-group">
                            <strong>Cliente:</strong>
                            {{ $citerecibo->cliente }}
                        </div>
                        <div class="form-group">
                            <strong>Cliente Id:</strong>
                            {{ $citerecibo->cliente_id }}
                        </div>
                        <div class="form-group">
                            <strong>Mescobro:</strong>
                            {{ $citerecibo->mescobro }}
                        </div>
                        <div class="form-group">
                            <strong>Monto:</strong>
                            {{ $citerecibo->monto }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $citerecibo->estado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
