<div>
    <div class="row mb-3">
        <div class="col-12 col-md-8 col-lg-9">
            <strong>LISTADO DE CONTRATOS</strong>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <button class="btn btn-info btn-sm btn-block" data-toggle="modal" data-target="#modalNuevoContrato">
                Nuevo <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="table-responsive mi-contenedor">
        <table class="table table-bordered table-striped" style="width: 100%">
            <thead class="table-info">
                <tr class="text-center">
                    <th>ID</th>
                    <th class="text-left">Tipo Contrato</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contratos as $contrato)
                    <tr class="text-center">
                        <td class="align-middle">{{ $contrato->id }}</td>
                        <td class="align-middle text-left">{{ $contrato->rrhhtipocontrato->nombre }}</td>
                        <td class="align-middle">{{ $contrato->fecha_inicio }}</td>
                        <td class="align-middle">{{ $contrato->fecha_fin ? $contrato->fecha_fin : 'Indefinido' }}</td>
                        <td class="align-middle">
                            @if ($contrato->activo)
                                <span class="badge badge-pill badge-success">Activo</span>
                            @else
                                <span class="badge badge-pill badge-secondary">Finalizado</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-outline-info btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bars"></i> Opciones
                                </button>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        wire:click='verInfo({{ $contrato->id }})' data-toggle="modal"
                                        data-target="#modalNuevoContrato"><i
                                            class="fas fa-eye text-secondary"></i>&nbsp; Ver datos</a>
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        @if (!$contrato->activo) disabled @endif
                                        wire:click='editContrato({{ $contrato->id }})' data-toggle="modal"
                                        data-target="#modalNuevoContrato"><i
                                            class="fas fa-edit text-secondary"></i>&nbsp; Editar</a>
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        @if (!$contrato->activo) disabled @endif
                                        wire:click='editContrato({{ $contrato->id }})' data-toggle="modal"
                                        data-target="#modalDocs"><i class="fas fa-file text-secondary"></i>&nbsp;
                                        Documentos</a>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDocs" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalDocsLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDocsLabel"><i class="fas fa-folder-plus"></i> Documentos Adjuntos
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Referencia:</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Descripción corta"
                                    id='referencia' oninput="this.value = this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="custom-file custom-file-sm">
                                        <input type="file" class="custom-file-input" id="fileInput">
                                        <label class="custom-file-label" for="exampleInputFile">
                                            Seleccione un archivo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">


                            <div id="spinnerSubida" class="spinner-border text-primary d-none" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                            <button class="btn btn-primary btn-block" id="uploadBtn" wire:click='subirArchivo'>Guardar
                                <i class="fas fa-file-upload"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Referencia</th>
                                    <th>Archivo</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!is_null($selContrato))
                                    @foreach ($selContrato->rrhhdocscontratos as $index => $doc)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $doc->referencia }}</td>
                                            <td>{{ substr($doc->url,21,-1) }}</td>
                                            <td>{{ substr($doc->created_at,0,10) }}</td>
                                            <td class="text-right"> 
                                                <a href="{{ asset('storage/' . $doc->url) }}"
                                                    class="btn btn-sm btn-primary" target="_blank" title="Ver online">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ asset('storage/' . $doc->url) }}"
                                                    class="btn btn-sm btn-success" download title="Descargar">
                                                    <i class="fas fa-cloud-download-alt"></i>
                                                </a>

                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalNuevoContrato" tabindex="-1" aria-labelledby="modalNuevoContrato"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoContrato">FORMULARIO DE CONTRATO @if ($selContrato)
                            ID: {{ $selContrato->id }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click='limpiar'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div wire:loading>
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div wire:loading.remove>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Tipo</span>
                                    </div>
                                    <select wire:model="rrhhtipocontratoid"
                                        class="form-control @error('rrhhtipocontratoid')
                                    is-invalid @enderror"
                                        @if ($show) disabled @endif>
                                        <option value="">Seleccione un tipo</option>
                                        @foreach ($tipocontratos as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Cargo</span>
                                    </div>
                                    <select wire:model.defer="rrhhcargo_id"
                                        @if ($show) disabled @endif
                                        class="form-control @error('rrhhtipocontratoid')
                                    is-invalid
                                @enderror">">
                                        <option value="">Seleccione un cargo</option>
                                        @foreach ($cargos as $cargo)
                                            <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Fecha Incio</span>
                                    </div>
                                    <input type="date" @if ($show) disabled @endif
                                        class="form-control @error('fecha_inicio')
                                    is-invalid
                                @enderror"
                                        wire:model.defer="fecha_inicio">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Fecha Fin</span>
                                    </div>
                                    <input type="date" @if ($show) disabled @endif
                                        class="form-control @error('fecha_fin')
                                    is-invalid
                                @enderror"
                                        wire:model.defer="fecha_fin">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Salario Basico</span>
                                    </div>
                                    <input type="number" step="any"
                                        @if ($show) disabled @endif
                                        class="form-control @error('salario_basico')
                                    is-invalid
                                @enderror"
                                        placeholder="0.00" wire:model.defer="salario_basico">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Moneda</span>
                                    </div>
                                    <select wire:model.defer="moneda"
                                        @if ($show) disabled @endif
                                        class="form-control @error('moneda')
                                    is-invalid
                                @enderror">
                                        <option value="">Seleccione una moneda</option>
                                        <option value="BOL">Boliviano - BOL</option>
                                        <option value="USD">Dolar Americano - USD</option>
                                    </select>
                                </div>
                            </div>
                            @if ($edit || $show)
                                <div class="col-12 col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Motivo Fin</span>
                                        </div>
                                        <input type="text" step="any"
                                            @if ($show) disabled @endif
                                            class="form-control @error('motivo_fin')
                                    is-invalid
                                @enderror"
                                            placeholder="Detalla el motivo de la finalización del contrato"
                                            wire:model.defer="motivo_fin">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Activo</span>
                                        </div>
                                        <select wire:model.defer="activo"
                                            @if ($show) disabled @endif
                                            class="form-control @error('activo')
                                    is-invalid
                                @enderror">
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>

                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>
                        <div class="float-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                wire:click='limpiar'>
                                @if ($show)
                                    <i class="far fa-times-circle"></i> Cerrar
                                @else
                                    <i class="fas fa-ban"></i> Cancelar
                                @endif

                            </button>
                            @if ($edit)
                                <button type="button"
                                    class="btn btn-warning @if ($show) d-none @endif"
                                    wire:click='updateContrato' data-dismiss="modal">Actualizar Contrato <i
                                        class="fas fa-save"></i></button>
                            @else
                                <button type="button" class="btn btn-primary" wire:click='registrarContrato'
                                    data-dismiss="modal">Registrar Contrato <i class="fas fa-save"></i></button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <style>
        .mi-contenedor {
            overflow: visible !important;
            position: relative;
        }
    </style>

</div>
@section('js2')
    <script src="{{ asset('vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        Livewire.on('subir', id => {
            subirArchivo(id);
        });
    </script>
    <script>
        function subirArchivo(contrato_id) {
            const input = document.getElementById('fileInput');
            const boton = document.getElementById('uploadBtn');
            const referencia = document.getElementById('referencia').value;
            const file = input.files[0];
            boton.classList.add('d-none');
            document.getElementById('spinnerSubida').classList.remove('d-none');
            if (!file) {

                Livewire.emit('toast-warning', 'Selecciona un archivo');
                boton.classList.remove('d-none');
                document.getElementById('spinnerSubida').classList.add('d-none');
                return;
            }

            const formData = new FormData();
            formData.append('option', 1);
            formData.append('id', contrato_id);
            formData.append('archivo', file);
            fetch('{{ route('uploadFile') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(d => {
                    console.log(d.message);

                    Livewire.emit('registrarDoc', d.url, referencia);
                    boton.classList.remove('d-none');
                    document.getElementById('spinnerSubida').classList.add('d-none');
                    input.value = '';
                    document.getElementById('referencia').value = '';
                })
                .catch(err => {
                    console.error(err);
                    alert('Error al subir.');
                    boton.classList.remove('d-none');
                    document.getElementById('spinnerSubida').classList.add('d-none');
                });
        }
    </script>
@endsection
