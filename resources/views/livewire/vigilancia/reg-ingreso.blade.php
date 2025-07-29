<div>
    @section('title')
    INGRESOS
    @endsection
    <div class="row mb-2">
        <div class="col-2">
            <a href="{{ route('vigilancia.panelvisitas',$designacion->id) }}" class="text-silver"><i
                    class="fas fa-arrow-circle-left fa-2x"></i></a>
        </div>
        <div class="col-8">
            <h6 class="text-secondary text-center">REGISTRO DE INGRESOS</h6>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="content mt-3">
        <b>
            <h3 class="text-primary text-center">{{ $designacion->turno->cliente->nombre }}</h3>
        </b>
        <hr>
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <label>Doc. Identidad:</label>
                <div class="input-group mb-3">
                    <input type="search" class="form-control" wire:model.defer='docidentidad'
                        onkeyup="this.value=this.value.toUpperCase()">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2" wire:click='buscar'><i
                            class="fas fa-search"></i></button>
                </div>
                @error('docidentidad')
                <small class="text-danger">El campo Doc. Identidad es requerido</small>
                @enderror
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label>Nombre Visitante:</label>
                <input type="text" class="form-control" wire:model='nombrevisitante'
                    onkeyup="this.value=this.value.toUpperCase()">
                @error('nombrevisitante')
                <small class="text-danger">El campo Nombre Visitante es requerido</small>
                @enderror
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label>A quien visita:</label>
                <input type="search" class="form-control" wire:model='residente'
                    onkeyup="this.value=this.value.toUpperCase()">

            </div>
            <div class="col-12 col-md-6 mb-3">
                <label>Nro. vivienda:</label>
                <input type="search" class="form-control" wire:model='nrovivienda'
                    onkeyup="this.value=this.value.toUpperCase()">
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label>Motivo visita:</label>
                {!! Form::select('motivo_id', $motivos, null,
                ['class'=>'form-select','wire:model'=>'motivoid','placeholder'=>'Seleccione un
                motivo']) !!}
                @error('motivoid')
                <small class="text-danger">El campo Motivo Visita es requerido</small>
                @enderror
            </div>

            @if ($motivo->nombre=="Otros")
            <div class="col-12 col-md-6 mb-3">

                <label class="text-primary">Otro motivo:</label>
                <input type="text" class="form-control" wire:model='otros'
                    onkeyup="this.value=this.value.toUpperCase()">

            </div>
            @endif
            <div class="col-12 mb-3">
                <label>Observaciones:</label>
                <input type="text" class="form-control" wire:model='observaciones'>

            </div>
            <div class="col-12 mb-3">
                <label>Capturas:</label>
                {{--
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" id="imageInput" capture="camera" class="form-control custom-file-input"
                            accept="image/*" onchange="procesar()">

                    </div>
                </div>
                <div id="preview" class="p-3 py-3" wire:ignore></div> --}}

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

        </div>


    </div>
    <div class="container-fluid d-grid mt-3 mb-3">

        <button class="btn btn-success" onclick='registrar()' wire:loading.remove wire:loading.attr="disabled">
            REGISTRAR VISITA <i class="fas fa-save"></i>
        </button>

        <button class="btn btn-success" wire:loading wire:target='registrar' wire:loading.attr="disabled">
            Espere...
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </button>


    </div>
    <br>
</div>
@section('js')
{{-- <script src="{{asset('vendor/jquery/inputsfiles.js')}}"></script> --}}
<script>
    function registrar(){
        Swal.fire({
            title: "REGISTRAR VISITA",
            text: "Está seguro de realizar esta operación?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#146c43",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, registrar",
            cancelButtonText: "No, cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                @this.registrar();
            }
            });
        }
</script>
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