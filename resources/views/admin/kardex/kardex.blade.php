@extends('adminlte::page')

@section('title')
    Kardex Empleado
@endsection
@section('content_header')
    <div class="row container-fluid">
        <div class="col-12 col-md-6">
            <h4>Kardex</h4>
        </div>
        <div class="col-12 col-md-6 text-right">

            <a href="{{ route('empleados.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>

        </div>


    </div>
@endsection
@section('content')
    <style>
        #tabsWrapper::-webkit-scrollbar {
            display: none;
        }

        #tabsWrapper {
            -ms-overflow-style: none;
            /* IE */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-info card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ $empleado->imgperfil ? Storage::url($empleado->imgperfil) : asset('images/avatar.png') }}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $empleado->nombres . ' ' . $empleado->apellidos }}</h3>

                        <p class="text-muted text-center">
                            {{ $contratoActivo ? $contratoActivo->rrhhcargo->nombre : 'Sin definir' }}
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Nro Doc.:</b> <a class="float-right">{{ $empleado->cedula }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Telefono:</b> <a class="float-right">{{ $empleado->telefono }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email:</b> <a class="float-right">{{ $empleado->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Contrato Vigente:</b> <a
                                    class="float-right">{{ $contratoActivo ? cerosIzq($contratoActivo->id) : 'Sin definir' }}</a>
                            </li>
                        </ul>

                        <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-info btn-block"><b>Editar
                                Datos <i class="fas fa-edit"></i></b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                {{-- <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div> --}}
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                   
                    <div class="card-header p-2 d-flex align-items-center">
                        <button class="btn btn-sm btn-light mr-2" id="scrollTabsLeft">&laquo;</button>

                        <div class="flex-grow-1 position-relative" style="overflow: hidden;">
                            <div id="tabsWrapper" style="overflow-x: auto; white-space: nowrap; scroll-behavior: smooth;">
                                <ul class="nav nav-pills flex-nowrap mb-0" id="tabNav" style="white-space: nowrap;">
                                    <li class="nav-item d-inline-block "><a class="nav-link active" href="#activity"
                                            data-toggle="tab">INFORMACIÓN GRAL.</a></li>
                                    <li class="nav-item d-inline-block"><a class="nav-link" href="#contratos"
                                            data-toggle="tab">CONTRATOS</a></li>
                                    <li class="nav-item d-inline-block nav-permisos"><a class="nav-link" href="#permisos"
                                            data-toggle="tab">PERMISOS Y LICENCIAS</a></li>
                                    <li class="nav-item d-inline-block nav-adelantos"><a class="nav-link" href="#adelantos"
                                            data-toggle="tab">ADELANTOS</a></li>
                                    <li class="nav-item d-inline-block nav-bonos"><a class="nav-link" href="#bonos"
                                            data-toggle="tab">BONOS Y DESCUENTOS</a>
                                    <li class="nav-item d-inline-block nav-dotaciones"><a class="nav-link" href="#dotaciones"
                                            data-toggle="tab">DOTACIONES</a>
                                        <!-- Más si querés -->
                                </ul>
                            </div>
                        </div>

                        <button class="btn btn-sm btn-light ml-2" id="scrollTabsRight">&raquo;</button>
                    </div>


                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                @include('admin.kardex.infogral')
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="contratos">
                                @livewire('kardex.contratos', ['empleado_id' => $empleado->id])
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="permisos">
                                @include('admin.kardex.licenciasypermisos')
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="adelantos">
                                @include('admin.kardex.adelantos')
                            </div>
                            <div class="tab-pane" id="bonos">
                                @include('admin.kardex.bonos')
                            </div>
                            <div class="tab-pane" id="dotaciones">
                                  @include('admin.kardex.dotaciones')
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
@section('js6')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabsWrapper = document.getElementById('tabsWrapper');
            const scrollLeft = document.getElementById('scrollTabsLeft');
            const scrollRight = document.getElementById('scrollTabsRight');

            const scrollAmount = 150;

            scrollLeft.addEventListener('click', () => {
                tabsWrapper.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            scrollRight.addEventListener('click', () => {
                tabsWrapper.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
