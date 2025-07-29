<div>
    @section('title')
    TAREAS
    @endsection
    <div class="row mb-3">
        <div class="col-2">
            <a href="{{ route('home') }}" class="text-silver"><i class="fas fa-arrow-circle-left fa-2x"></i></a>
        </div>
        <div class="col-8">
            <h6 class="text-secondary text-center">TAREAS</h6>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="content mt-3">
        <b>
            <h3 class="text-primary text-center">{{ $designacion->turno->cliente->nombre }}</h3>
        </b>
        <hr>
        <h6 class="text-center mb-3">TAREAS PENDIENTES</h6>
        {{-- <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            <input type="search" class="form-control" placeholder="Busqueda..." wire:model.debounce.500ms='search'
                id="search">
        </div> --}}

        <div class="table-responsive">
            <table class="table table-bordered table-striped" style="font-size: 12px; vertical-align: middle">
                <thead>
                    <tr class="table-primary text-center fw-bold">
                        <td style="width: 88px;">FECHA</td>
                        {{-- <td>OPERADOR</td> --}}
                        <td>DESCRIPCIÓN</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tareas as $item)
                    <tr>
                        <td class="text-center">{{$item->fecha}}</td>
                        {{-- <td class="text-center">{{$empleado->nombres." ".$empleado->apellidos}}</td> --}}
                        <td>{{$item->contenido}}</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalInfo"
                                wire:click='cargarTarea({{$item->id}})' style="font-size: 12px;" title="Procesar">
                                <i class="fas fa-check-double"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center"><i>No se encontraron resultados.</i></td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoLabel">Info Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        @if ($tarea)
                        <tr class="table-success">
                            <td><strong>Fecha:</strong></td>
                            <td>{{$tarea->fecha}}</td>
                        </tr>
                        <tr>
                            <td><strong>Cliente:</strong></td>
                            <td>{{$tarea->cliente->nombre}}</td>
                        </tr>
                        <tr>
                            <td><strong>Operador:</strong></td>
                            <td>{{$tarea->empleado->nombres}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>Descripción:</strong><br>
                                {{$tarea->contenido}}
                            </td>
                        </tr>
                        @endif


                    </table>
                    <label for="txtinforme" class="form-label text-primary"><strong>Capturas:</strong></label>
                    <div class="container-fluid mt-1" wire:ignore>
                        <form id="uploadForm">
                            <div class="row mb-3 input-row" id="inputRow0">
                                <div class="col">
                                    {{-- <label for="fileInput0" class="form-label">Upload Image</label> --}}
                                    <input type="file" class="form-control" id="fileInput0" name="fileInput0"
                                        onchange="CARGAFOTO('fileInput0')" accept="image/*,audio/*" capture="camera">
                                </div>
                                <div class="col-auto" id="thumbnailContainer0"></div>
                                <div class="col-auto d-none" id="deleteButtonContainer0">
                                    <button type="button" class="btn btn-danger"
                                        onclick="deleteInput('inputRow0');remArray(0)">x</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-ban"></i>
                        Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click='procesar' wire:loading.attr="disabled">
                        Finalizar Tarea <i class="fas fa-check-double"></i>
                        <div wire:loading wire:target="procesar">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script>
    let inputCount = 1;
    function remArray(id){
        Livewire.emit('deleteInput',id);
    }

    function CARGAFOTO(inputId) {
        var srcEncoded;
        @this.set('filename',"");
        const inputElement = document.getElementById(inputId);
        const file = inputElement.files[0];
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                document.getElementById(inputId).value="";
                Swal.fire({
                    title: "Error",
                    text: "Solo se permiten imagenes.",
                    icon: "error"
                });
                event.preventDefault();
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const thumbnailContainerId = `thumbnailContainer${inputId.replace('fileInput', '')}`;
                createThumbnail(e.target.result, thumbnailContainerId);
                showDeleteButton(inputId);
                createNewFileInput();

                const imgElement = document.createElement("img");
                imgElement.src = event.target.result;            

                imgElement.onload = function (e) {
                    const canvas = document.createElement("canvas");
                    const MAX_WIDTH = 400;

                    const scaleSize = MAX_WIDTH / e.target.width;
                    canvas.width = MAX_WIDTH;
                    canvas.height = e.target.height * scaleSize;

                    const ctx = canvas.getContext("2d");

                    ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                    srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");
                    
                    @this.cargaImagenBase64(srcEncoded);
                };
            }
            reader.readAsDataURL(file);
        }
        inputElement.disabled=true;
    }

    function createThumbnail(src, containerId) {
        const thumbnailContainer = document.getElementById(containerId);
        thumbnailContainer.innerHTML = '';
        const img = document.createElement('img');
        img.src = src;
        img.className = 'img-thumbnail';
        img.style.maxWidth = '100px';
        thumbnailContainer.appendChild(img);
    }

    function showDeleteButton(inputId) {
        const deleteButtonContainerId = `deleteButtonContainer${inputId.replace('fileInput', '')}`;
        const deleteButtonContainer = document.getElementById(deleteButtonContainerId);
        deleteButtonContainer.classList.remove('d-none');
    }

    function createNewFileInput() {
        const form = document.getElementById('uploadForm');
        const divRow = document.createElement('div');
        divRow.className = 'row mb-3 input-row';
        divRow.id = `inputRow${inputCount}`;

        const divInput = document.createElement('div');
        divInput.className = 'col';

        const label = document.createElement('label');
        label.className = 'form-label';
        label.textContent = 'Upload Image';

        const input = document.createElement('input');
        input.type = 'file';
        input.className = 'form-control';
        input.id = `fileInput${inputCount}`;
        input.name = `fileInput${inputCount}`;
        input.accept = 'image/*,audio/*';
        input.setAttribute('capture', `camera`);
        input.setAttribute('onchange', `CARGAFOTO('${input.id}')`);

        const divThumbnail = document.createElement('div');
        divThumbnail.className = 'col-auto';
        divThumbnail.id = `thumbnailContainer${inputCount}`;

        const divButton = document.createElement('div');
        divButton.className = 'col-auto d-none';
        divButton.id = `deleteButtonContainer${inputCount}`;
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-danger';
        button.textContent = 'x';
        button.setAttribute('onclick', `deleteInput('${divRow.id}');remArray('${inputCount}')`);
        // button.setAttribute('wire:click', `deleteInput('${inputCount}')`);

        divInput.appendChild(label);
        divInput.appendChild(input);
        divButton.appendChild(button);
        divRow.appendChild(divInput);
        divRow.appendChild(divThumbnail);
        divRow.appendChild(divButton);

        form.appendChild(divRow);
        inputCount++;
    }

    function deleteInput(rowId) {
        const row = document.getElementById(rowId);
        row.remove();
        // Ensure at least one empty input file remains
        const inputs = document.querySelectorAll('input[type="file"]');
        if (inputs.length === 0) {
            createNewFileInput();
        }
    }
</script>
@endsection