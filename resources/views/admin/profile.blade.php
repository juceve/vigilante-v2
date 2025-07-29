@extends('adminlte::page')

@section('title')
    Perfil de Usuario
@endsection
@section('content_header')
    <h4>Perfil de Usuario</h4>
@endsection
@section('content')
    <div class="content mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <span><strong>Información Personal</strong></span>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered ">
                                <tr>
                                    <td>Nombre:</td>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <td>Correo:</td>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        @if (Auth::user()->status)
                                            <span class="badge rounded-pill bg-success">Activo</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Inactivo</span>
                                        @endif
                                    </td>


                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3"></div>
                    <div class="col-12 col-md-6 mb-3">
                        <span><strong>Avatar</strong></span>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered " style="vertical-align: middle">
                                <tr>
                                    <td>Seleccione Imagen</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="img-avatar" accept="images/*">
                                                <label class="custom-file-label" for="img-avatar">Imagen</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Vista previa:</td>
                                    <td align="center">
                                        <img src="{{asset('images/escudo2.png')}}" class="img-fluid img-thumbnail" style="width: 50%">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="">
                            <button class="btn btn-info btn-block">Guardar Imagen</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3"></div>
                    <div class="col-12 col-md-6 mt-3">
                        <span><strong>Cambio de Password</strong></span>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered " style="vertical-align: middle">
                                <tr>
                                    <td>Password actual:</td>
                                    <td>
                                        <input type="password" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nuevo password:</td>
                                    <td>
                                        <input type="password" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Confirme password:</td>
                                    <td>
                                        <input type="password" class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="">
                            <button class="btn btn-danger btn-block">Cambiar Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
