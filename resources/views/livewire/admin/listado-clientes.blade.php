<div>
    <div class="row">
        <div class="col-12 col-md-10">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="search" class="form-control" placeholder="Ingrese su busqueda..."
                    wire:model.debounce.500ms='busqueda'>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><small>Filas: </small></span>
                </div>
                <select class="form-control text-center" wire:model='filas'>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead">
                <tr class="table-info">
                    <th>No</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Oficina</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ ++$i }}</td>

                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>{{ $cliente->oficina }}</td>
                    <td>
                        @if ($cliente->status)
                        <span class="badge badge-pill badge-success">Activo</span>
                        @else
                        <span class="badge badge-pill badge-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td align="right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                data-toggle="dropdown">Opciones</button>
                            {{-- <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false"> --}}
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" style="">

                                <a class="dropdown-item" href="{{ route('clientes.show', $cliente->id) }}"><i
                                        class="fa fa-fw fa-eye text-secondary"></i> Info</a>
                                @can('clientes.edit')
                                <a class="dropdown-item" href="{{ route('clientes.edit', $cliente->id) }}"><i
                                        class="fa fa-fw fa-edit text-secondary"></i> Editar</a>
                                <a class="dropdown-item" href="{{ route('usuariocliente', $cliente->id) }}">
                                    <i class="fas fa-user-plus text-secondary"></i> Usuario externo</a>
                                @endcan
                                @can('turnos.index')
                                <a class="dropdown-item" href="{{ route('admin.turnos-cliente', $cliente->id) }}"><i
                                        class="fas fa-clock text-secondary"></i> Turnos</a>
                                @endcan
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                    class="delete" onsubmit="return false">
                                    @csrf
                                    @method('DELETE')
                                    @can('clientes.destroy')
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
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $clientes->links() }}
        </div>
    </div>
</div>