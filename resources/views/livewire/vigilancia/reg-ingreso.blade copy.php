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
                {{-- <input class="form-control" type="file" id="formFile" capture="camera"> --}}
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" id="imageInput" capture="camera" class="form-control custom-file-input"
                            accept="image/*" onchange="procesar()">
                        {{-- <label class="custom-file-label" for="inputGroupFile01">Seleccione una Imagen</label> --}}
                    </div>
                </div>
                <div id="preview" class="p-3 py-3" wire:ignore></div>
            </div>

        </div>


    </div>
    <div class="container-fluid d-grid mt-3 mb-3">

        <button class="btn btn-success" wire:click='registrar' wire:loading.remove wire:loading.attr="disabled">
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
<script>
    function procesar(){
    var srcEncoded;
    @this.set('filename',"");
    document.getElementById('preview').innerHTML='';
    const preview = document.getElementById('preview');
    const input = document.querySelector('#imageInput');
        // const file = document.querySelector('#imageInput').files[0];
    for (let i = 0; i < input.files.length; i++) {
        const file = input.files[i];
        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function (event) {
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

                // document.querySelector("#output").src = srcEncoded;    
                // document.querySelector("#divOutput").classList.remove('d-none');

                const resizedImg = new Image();
                
                resizedImg.src = srcEncoded;
                resizedImg.classList.add('img-fluid');
                resizedImg.classList.add('img-thumbnail');
                preview.innerHTML='<b>Vista previa:</b><br>';
                preview.appendChild(resizedImg);
                @this.cargaImagenBase64(srcEncoded);
            };
        };
    }
    
}
</script>
@endsection