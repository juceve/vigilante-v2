<div>
    @section('title')
    Registro de Designaciones
    @endsection
    @section('content_header')
    <div class="container-fluid">

        <div style="display: flex; justify-content: space-between; align-items: center;" class="mb-2 mt-2">
            <h4>Registro de Designaciones</h4>

            <div class="float-right">
                @can('designaciones.create')
                <a href="{{ route('designaciones.create') }}" class="btn btn-info btn-sm float-right"
                    data-placement="left">
                    <i class="fas fa-plus"></i> Nuevo
                </a>
                @endcan
            </div>
        </div>
    </div>
    @endsection

    <div class="container-fluid">
        <div class="card">

            <div class="card-body">
                <label for="">Filtrar:</label>
                <div class="row">
                    <div class="col-12 col-md-3 mb-3">
                        {!! Form::select('cliente_id', $clientes, null,
                        ['class'=>'form-control','placeholder'=>'Seleccione un cliente','wire:model'=>'cliente_id']) !!}
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Desde</span>
                            </div>
                            <input type="date" class="form-control" wire:model='inicio' aria-label="inicio"
                                aria-describedby="basic-addon1">
                        </div>

                    </div>
                    <div class="col-12 col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Hasta</span>
                            </div>
                            <input type="date" class="form-control" wire:model='final' aria-label="final"
                                aria-describedby="basic-addon1">
                        </div>

                    </div>
                    <div class="col-12 col-md-3">
                        {!! Form::select('estado', [''=>'Todos','1'=>'Activo','0'=>'Finalizado'],
                        null, ['class'=>'form-control','wire:model'=>'estado']) !!}
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    @if (!is_null($resultados))
                    <div class="row w-100">
                        <div class="col-12 mb-3">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fas fa-search"></i></span>
                                </div>
                                <input type="search" class="form-control" placeholder="Busqueda..."
                                    aria-label="Busqueda..." aria-describedby="basic-addon1"
                                    wire:model.debounce.500ms='search'>
                            </div>
                        </div>

                    </div>

                </div>

                @endif

                <div class="">
                    <table class="table table-bordered table-striped dataTableLiv" style="vertical-align: middle">
                        <thead>
                            <tr class="table-info">
                                <th>No</th>
                                <th>EMPLEADO</th>
                                <th>CLIENTE</th>
                                <th>TURNO</th>
                                <th style="width: 45px;">INICIO</th>
                                <th style="width: 45px;">FINAL</th>
                                <th>ESTADO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!is_null($resultados))
                            @foreach ($resultados as $designacione)
                            <tr>
                                {{-- <td>{{ ++$i }}</td> --}}
                                
                                <td>{{ $designacione->id}}</td>
                                <td>{{ $designacione->empleado}}</td>
                                <td>{{ $designacione->cliente }}
                                <td>{{ $designacione->turno }}</td>
                                <td>{{ $designacione->fechaInicio }}</td>
                                <td>{{ $designacione->fechaFin }}</td>
                                <td class="text-center">
                                    @if (!$designacione->estado) <span
                                        class="badge badge-pill badge-warning">Finalizado</span>
                                    @else
                                    <span class="badge badge-pill badge-success">Activo</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                            data-toggle="dropdown">Opciones</button>
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">

                                            @can('admin.registros.hombrevivo')
                                            <a class="dropdown-item"
                                                href="{{ route('designaciones.show', $designacione->id) }}" title="">
                                                <i class="fas fa-fw fa-street-view text-secondary"></i>
                                                Rondas
                                            </a>
                                            @endcan
                                            @can('admin.registros.hombrevivo')
                                            <a class="dropdown-item"
                                                href="{{ route('registroshv', $designacione->id) }}" title="">
                                                <i class="fas fa-fw fa-user-check text-secondary"></i>
                                                Hombre Vivo
                                            </a>
                                            @endcan
                                            @can('admin.registros.asistencia')
                                            <a class="dropdown-item"
                                                href="{{ route('marcaciones', $designacione->id) }}" title="">
                                                <i class="fas fa-user-clock text-secondary"></i>
                                                Asistencias
                                            </a>
                                            @endcan
                                            @can('admin.registros.novedades')
                                            <a class="dropdown-item"
                                                href="{{ route('regnovedades', $designacione->id) }}" title="">
                                                <i class="fas fa-book text-secondary"></i>
                                                Novedades
                                            </a>
                                            @endcan

                                            @can('admin.registros.diaslibres')
                                            <a class="dropdown-item"
                                                href="{{ route('designaciones.diaslibres', $designacione->id) }}">
                                                <i class="fas fa-fw fa-calendar-alt text-secondary"></i>
                                                Días libres</a>
                                            @endcan

                                            @can('designaciones.edit')
                                            <a class="dropdown-item"
                                                href="{{ route('designaciones.edit', $designacione->id) }}" title=""><i
                                                    class="fa fa-fw fa-edit text-secondary"></i> Editar
                                            </a>
                                            @endcan
                                            @can('designaciones.finalizar')
                                            <button type="submit" class="dropdown-item"
                                                onclick="finalizar({{$designacione->id}})">
                                                <i class="far fa-fw fa-calendar-times text-secondary"></i>
                                                Finalizar
                                            </button>
                                            @endcan
                                            <form action="{{ route('designaciones.destroy', $designacione->id) }}"
                                                method="POST" onsubmit="return false" class="delete">
                                                @csrf
                                                @method('DELETE')
                                                @can('designaciones.destroy')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-fw fa-trash text-secondary"></i>
                                                    Eliminar de la DB
                                                </button>
                                                @endcan

                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    {{-- <div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoLabel"><strong>INFO VISITA - ID: {{$visita->id}}</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div wire:loading>

                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>

                    </div>
                    <div wire:loading.remove>
                        <div class="row">
                            <div class="col-12 col-md-6">

                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td><strong>CLIENTE:</strong></td>
                                        <td>{{$visita->cliente}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>VISITANTE:</strong></td>
                                        <td>{{$visita->visitante}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>DOC. IDENTIDAD:</strong></td>
                                        <td>{{$visita->docidentidad}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>RESIDENTE:</strong></td>
                                        <td>{{$visita->residente}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NRO. VIVIENDA:</strong></td>
                                        <td>{{$visita->nrovivienda}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>INGRESO:</strong></td>
                                        <td>{{$visita->fechaingreso." ".$visita->horaingreso}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>SALIDA:</strong></td>
                                        <td>{{$visita->fechaSALIMOTIVO." ".$visita->horaSALIMOTIVO}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MOTIVO:</strong></td>
                                        <td>{{$visita->motivo}}</td>
                                    </tr>
                                    @if ($visita->motivo =="Otros")
                                    <tr>
                                        <td><strong>OTROS:</strong></td>
                                        <td>{{$visita->otros}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><strong>OBSERVACIONES:</strong></td>
                                        <td>{{$visita->observaciones}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>ESTADO:</strong></td>
                                        <td>
                                            @if ($visita->estado)
                                            <span class="badge badge-pill badge-success">Activo</span>
                                            @else
                                            <span class="badge badge-pill badge-warning">Finalizado</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@section('js')

<script>
    function finalizar(id){
        Swal.fire({
        title: "FINALIZAR DESIGNACIÓN",
        text: "Está seguro de realizar esta operación?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "No, cancelar",
        }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('finalizar',id);
        }
        });
    }
</script>
@endsection