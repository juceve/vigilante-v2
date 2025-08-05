<div>
    @section('title', 'Listado de Residencias')
    @section('plugins.Select2', true)
    @section('content_header')
        <h1><i class="fas fa-home mr-2"></i>Listado de Residencias</h1>
    @endsection

    @section('content')
        {{-- Mensajes de éxito --}}
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-1"></i>
                            Gestión de Residencias
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <button data-toggle="modal" data-target="#modalResidencia" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>
                            Nuevo
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- Filtros y búsqueda --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="search" class="form-control"
                                placeholder="Buscar por número de puerta, calle, manzano o lote...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select wire:model="perPage" class="form-control">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>

                {{-- Tabla de residencias --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th wire:click="sortBy('id')" style="cursor: pointer;">
                                    ID
                                    @if ($sortField === 'id')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('numeropuerta')" style="cursor: pointer;">
                                    Nº Puerta
                                    @if ($sortField === 'numeropuerta')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th>Calle</th>
                                <th>Manzano</th>
                                <th>Nº Lote</th>
                                <th>Cliente</th>
                                <th>Propietario</th>
                                <th>Cédula Propietario</th>
                                <th width="120">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($residencias as $residencia)
                                <tr>
                                    <td>{{ $residencia->id }}</td>
                                    <td>
                                        <span class="badge badge-primary">{{ $residencia->numeropuerta }}</span>
                                    </td>
                                    <td>{{ $residencia->calle ?? '-' }}</td>
                                    <td>{{ $residencia->manzano ?? '-' }}</td>
                                    <td>{{ $residencia->nrolote ?? '-' }}</td>
                                    <td>
                                        @if ($residencia->cliente)
                                            <small class="text-muted">{{ $residencia->cliente->nombre }}</small>
                                        @else
                                            <span class="badge badge-warning">Sin cliente</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($residencia->propietario)
                                            {{ $residencia->propietario->nombre ?? 'N/A' }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $residencia->cedula_propietario ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button wire:click="edit({{ $residencia->id }})" class="btn btn-sm btn-info"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="confirmDelete({{ $residencia->id }})"
                                                class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-home fa-2x mb-2"></i>
                                        <br>
                                        No se encontraron residencias
                                        @if ($search)
                                            para "{{ $search }}"
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if ($residencias->hasPages())
                    <div class="mt-3">
                        {{ $residencias->links() }}
                    </div>
                @endif
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalResidencia" tabindex="-1"
            aria-labelledby="modalResidenciaLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalResidenciaLabel">
                            <i class="fas fa-home mr-2"></i>
                            {{ $residencia_id ? 'Editar Residencia' : 'Nueva Residencia' }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numeropuerta">Número de Puerta *</label>
                                    <input type="text" wire:model="numeropuerta"
                                        class="form-control @error('numeropuerta') is-invalid @enderror"
                                        placeholder="Ej: 123">
                                    @error('numeropuerta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="calle">Calle</label>
                                    <input type="text" wire:model="calle"
                                        class="form-control @error('calle') is-invalid @enderror"
                                        placeholder="Nombre de la calle">
                                    @error('calle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="manzano">Manzano</label>
                                    <input type="text" wire:model="manzano"
                                        class="form-control @error('manzano') is-invalid @enderror"
                                        placeholder="Ej: A, B, C">
                                    @error('manzano')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nrolote">Número de Lote</label>
                                    <input type="text" wire:model="nrolote"
                                        class="form-control @error('nrolote') is-invalid @enderror" placeholder="Ej: 15">
                                    @error('nrolote')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nrolote">Propietario</label>
                                    <select name="propietario_id" id="propietario_id" wire:model="propietario_id"
                                        class="form-control select2bs4 @error('propietario_id') is-invalid @enderror"
                                        style="width: 100%;">
                                        <option value="">Seleccione un propietario</option>
                                        @foreach ($propietarios as $propietario)
                                            <option value="{{ $propietario->id }}">{{ $propietario->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('propietario_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="notas">Notas</label>
                            <textarea wire:model="notas" class="form-control @error('notas') is-invalid @enderror" rows="3"
                                placeholder="Observaciones adicionales..."></textarea>
                            @error('notas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i>
                            Cancelar
                        </button>
                        <button class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
                            <i class="fas fa-save mr-1"></i>
                            {{ $residencia_id ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @section('js')
            <script>
                // Inicializar Select2 cuando se abre el modal
                $('#modalResidencia').on('shown.bs.modal', function () {
                    $('#propietario_id').select2({
                        theme: 'bootstrap4',
                        dropdownParent: $('#modalResidencia')
                    });
                    
                    // Evento específico de Select2 para cerrar dropdown al seleccionar
                    $('#propietario_id').on('select2:select', function (e) {
                        @this.set('propietario_id', $(this).val());
                        // Cerrar el dropdown inmediatamente
                        $(this).select2('close');
                    });
                });

                // Sincronizar Select2 con Livewire (mantener para otros casos)
                $(document).on('change', '#propietario_id', function () {
                    @this.set('propietario_id', $(this).val());
                });

                // Reinicializar Select2 después de actualizaciones de Livewire
                document.addEventListener('livewire:update', function () {
                    setTimeout(function() {
                        if ($('#modalResidencia').hasClass('show')) {
                            $('#propietario_id').select2({
                                theme: 'bootstrap4',
                                dropdownParent: $('#modalResidencia')
                            });
                            
                            // Re-vincular el evento select2:select
                            $('#propietario_id').off('select2:select').on('select2:select', function (e) {
                                @this.set('propietario_id', $(this).val());
                                $(this).select2('close');
                            });
                        }
                    }, 100);
                });
            </script>
        @endsection

        {{-- Modal de confirmación para eliminar --}}
        {{-- @if ($confirmingDelete)
            <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-trash mr-2"></i>
                                Confirmar Eliminación
                            </h5>
                            <button type="button" wire:click="closeModal" class="close text-white">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h5>¿Está seguro de eliminar esta residencia?</h5>
                                <p class="text-muted">Esta acción no se puede deshacer.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i>
                                Cancelar
                            </button>
                            <button type="button" wire:click="delete" class="btn btn-danger">
                                <i class="fas fa-trash mr-1"></i>
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif --}}

    @endsection


</div>
