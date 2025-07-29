<div>
    @section('title')
    Novedades
    @endsection
    <div class="row mb-3">
        <div class="col-1">
            <a href="{{ route('home') }}" class="text-silver"><i class="fas fa-arrow-circle-left fa-2x"></i></a>
        </div>
        <div class="col-10">
            <h4 class="text-secondary text-center">NOVEDADES</h4>
        </div>
        <div class="col-1"></div>

    </div>
    <div class="row">
        <h6 class="text-center text-primary">NUEVO REGISTRO</h6>

        <div class="col-12 col-md-6 d-grid mb-3">
            <div class="mb-3">
                <label for="txtinforme" class="form-label text-primary"><strong>Anotaciones:</strong></label>
                <textarea class="form-control" id="txtinforme" wire:model.lazy='informe' rows="4"></textarea>
            </div>
        </div>

        <div class="col-12 col-md-6 d-grid mb-3">
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

        {{-- <div class="col-12 col-md-6 d-grid mb-3">
            <div class="mb-3">
                <label for="files" class="form-label text-primary"><strong>Imagenes:</strong></label>
                <input class="form-control" type="file" id="files" multiple accept="image/*,audio/*,video/*"
                    wire:model='files'>
                @foreach ($files as $file)
                @error('file')
                <span class="error">{{ $message }}</span>
                @enderror
                @endforeach
            </div>
            @if ($files)
            <small><i>Vista previa:</i></small>
            <div class="row">
                @foreach ($files as $file)
                <div class="col-4">
                    <img src="{{ $file->temporaryUrl() }}" class="img-thumbnail">
                </div>
                @endforeach
            </div>
            @endif
        </div> --}}
    </div>
    <div class="d-grid">
        <button class="btn btn-primary py-3" id="enviar" wire:click='enviar'>ENVIAR <i
                class="fas fa-paper-plane"></i></button>
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
<script>
    if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success2);
        }else{
            console.log('No tiene acceso a Ubicacion.');
        }

        function success2(geoLocationPosition) {
            // console.log(geoLocationPosition.timestamp);
            let data = [
                geoLocationPosition.coords.latitude,
                geoLocationPosition.coords.longitude,
            ];
            Livewire.emit('ubicacionAprox', data);
        }
</script>
@endsection