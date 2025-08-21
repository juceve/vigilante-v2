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
                    <div class="col-md-6 mb-3">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fas fa-search"></i></span>
                                </div>
                                <input type="search" class="form-control" placeholder="Busqueda por empleado"
                                    aria-label="Busqueda..." aria-describedby="basic-addon1"
                                    wire:model.debounce.500ms='search'>
                            </div>
                        </div>
                    <div class="col-12 col-md-3 mb-3">
                        {!! Form::select('cliente_id', $clientes, null,
                        ['class'=>'form-control','placeholder'=>'Todos los Clientes','wire:model'=>'cliente_id']) !!}
                    </div>
                  
                    <div class="col-12 col-md-3">
                        {!! Form::select('estado', [''=>'Todos los estados','1'=>'Activo','0'=>'Finalizado'],
                        null, ['class'=>'form-control','wire:model'=>'estado']) !!}
                    </div>
                </div>
                
                <div class="table-responsive">
                    @if (!is_null($resultados))
                    <div class="row w-100">
                        

                    </div>

                </div>

                @endif

                <div class="">
                    <table class="table table-bordered table-striped" style="vertical-align: middle; font-size: 13px;">
                        <thead>
                            <tr class="table-info text-center">
                                <th>No</th>
                                <th class="text-left">EMPLEADO</th>
                                <th >CLIENTE</th>
                                <th>TURNO</th>
                                <th >INICIO</th>
                                <th >FINAL</th>
                                <th>ESTADO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!is_null($resultados))
                            @foreach ($resultados as $designacione)
                            <tr class="text-center">
                                {{-- <td>{{ ++$i }}</td> --}}
                                
                                <td>{{ $designacione->id}}</td>
                                <td class="text-left">{{ $designacione->empleado}}</td>
                                <td>{{ $designacione->cliente }}
                                <td>{{ $designacione->turno }}</td>
                                <td>{{ $designacione->fechaInicio }}</td>
                                <td>{{ $designacione->fechaFin }}</td>
                                <td >
                                    @if (!$designacione->estado) <span
                                        class="badge badge-pill badge-warning">Finalizado</span>
                                    @else
                                    <span class="badge badge-pill badge-success">Activo</span>
                                    @endif
                                </td>
                                <td class="text-right" style="width: 100px">
                                    <div class="btn-group dropleft">
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
                                            {{-- @can('admin.registros.asistencia')
                                            <a class="dropdown-item"
                                                href="{{ route('marcaciones', $designacione->id) }}" title="">
                                                <i class="fas fa-user-clock text-secondary"></i>
                                                Asistencias
                                            </a>
                                            @endcan --}}
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
                    <div class="float-right">
                        {{ $resultados->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

  
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