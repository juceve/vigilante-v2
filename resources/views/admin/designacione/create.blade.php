@extends('adminlte::page')

@section('title')
    Nuevo Designación
@endsection
@section('content_header')
    <h4>Nuevo Designación</h4>
@endsection
@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header bg-info">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Formulario de Registro
                            </span>

                             <div class="float-right">
                                <a href="javascript:history.back()" class="btn btn-info btn-sm float-right"  data-placement="left">
                                  <i class="fas fa-arrow-left"></i> Volver
                                </a>
                              </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <form method="POST" action="{{ route('designaciones.store') }}"  role="form" enctype="multipart/form-data"> --}}
                            {{-- @csrf --}}

                            @livewire('admin.nueva-designacion', ['designacione' => $designacione])

                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{ asset('vendor/jquery/scripts.js') }}"></script>
    @include('vendor.mensajes')
@endsection