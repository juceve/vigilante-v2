<div>

    <div class="card">
        <div class="card-header bg-light">
            PROPIETARIOS VINCULADOS CON LA EMPRESA
            <div class="float-right">

                <button class="btn btn-light btn-sm" wire:click="create">
                    <i class="fa fa-plus"></i> Nuevo
                </button>


            </div>
        </div>

        <div class="card-body table-responsive">
            <div class="alert alert-primary" role="alert">
                Los propietarios que se muestran aqui son los que tienen una vinculación con alguna residencia de la
                empresa.
            </div>
            <div class="row mb-3">
                <!-- Buscador -->
                <div class="col-12 col-md-9 col-xl-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="search" class="form-control" placeholder="Ingrese su búsqueda..."
                            wire:model.debounce.500ms="search">
                    </div>
                </div>


                <!-- Selección de filas -->
                <div class="col-12 col-md-3 col-xl-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><small>Filas:</small></span>
                        </div>
                        <select class="form-control text-center" wire:model="perPage">
                            @foreach ($perPageOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="table-info">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Teléfono</th>
                        <th>Activo</th>
                        <th width="150px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($propietarios as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->cedula }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>

                                <span class="badge badge-pill {{ $item->activo ? 'badge-success' : 'badge-danger' }}"
                                    style="font-size: 12px">
                                    {{ $item->activo ? 'Sí' : 'No' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <button class="btn btn-info btn-sm" wire:click="show({{ $item->id }})">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <button class="btn btn-warning btn-sm" wire:click="edit({{ $item->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>


                                <button class="btn btn-danger btn-sm" onclick="eliminar({{ $item->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="float-right mt-3">
                {{ $propietarios->links() }}
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="modalPropietario" tabindex="-1" aria-labelledby="modalPropietario" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div
                    class="modal-header
                @switch($modalMode)
                    @case('create')
                        bg-primary text-white
                        @break
                    @case('edit')
                        bg-warning text-dark
                        @break
                    @default
                        bg-info text-white
                @endswitch">
                    <h5 class="modal-title">
                        @if ($modalMode == 'create')
                            Nuevo Propietario
                        @elseif($modalMode == 'edit')
                            Editar Propietario
                        @else
                            Ver Propietario
                        @endif
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">


                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label>Nombre</label>
                            <input type="text" class="form-control" wire:model.defer="nombre"
                                @if ($modalMode === 'show') disabled @endif>
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label>Cédula</label>
                            <input type="text" class="form-control" wire:model.defer="cedula"
                                @if ($modalMode === 'show') disabled @endif>
                            @error('cedula')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" wire:model.defer="telefono"
                                @if ($modalMode === 'show') disabled @endif>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" wire:model.defer="email"
                                @if ($modalMode === 'show') disabled @endif>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label>Dirección</label>
                            <input type="text" class="form-control" wire:model.defer="direccion"
                                @if ($modalMode === 'show') disabled @endif>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label>Ciudad</label>
                            <input type="text" class="form-control" wire:model.defer="ciudad"
                                @if ($modalMode === 'show') disabled @endif>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label>Activo</label>
                            <select class="form-control" wire:model.defer="activo"
                                @if ($modalMode === 'show') disabled @endif>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    @if ($modalMode === 'create')
                        <div class="alert alert-primary" role="alert">
                            Luego realizar el registro debe vincular el propietario a una residencia desde el módulo de
                            Residencias.
                        </div>
                    @endif


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i>
                        Cerrar</button>
                    @if ($modalMode !== 'show')
                        <button class="btn @if ($modalMode === 'create') btn-primary @else btn-warning @endif"
                            wire:click="save">
                            @if ($modalMode === 'create')
                                Registrar
                            @else
                                Guardar Cambios
                            @endif
                            <i class="fa fa-save"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        function eliminar(id) {
            swal.fire({
                title: 'Eliminar Registro',
                text: "¿Estás seguro? No podrás deshacer esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('delete', id);
                }
            });
        }
    </script>
    <script>
        Livewire.on('openModal', () => {
            $('#modalPropietario').modal('show');
        })
        Livewire.on('closeModal', () => {
            $('#modalPropietario').modal('hide');
        });
    </script>
@endsection
