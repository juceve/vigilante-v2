<div>
    @section('title')
    Panico
    @endsection
    <div class="row mb-3">
        <div class="col-1">
            <a href="{{ route('home') }}" class="text-silver"><i class="fas fa-arrow-circle-left fa-2x"></i></a>
        </div>
        <div class="col-10">
            <h4 class="text-secondary text-center">PÁNICO</h4>
        </div>
        <div class="col-1"></div>

    </div>
    <section>
        <div class="content text-center d-grid mb-5">
            <button class="btn btn-light" id="button-call">
                <img class="w-25 temblor greyscale" src="{{ asset('web/assets/img/home/em-call.png') }}"
                    alt="Llamada Emergencia" id="telephone"><br>
                <h5 class="text-danger" id="llamada-emergencia">Llamada automática en <span id="numero">5</span></h5>
                <span class="text-primary">Toque para cancelar</span>
            </button>

        </div>

        <div class="row text-center">
            {{-- <div class="col-6 d-grid mb-3">
                <button class="btn btn-secondary"><i class="fas fa-map-marker-alt fa-2x"></i><br>Enviar
                    Ubicación</button>
            </div> --}}
            <div class="col-12 d-grid mb-3">
                <a class="btn btn-primary" href="tel:+59178458561" id="llamar" onclick="llamada()"><i
                        class="fas fa-phone-square-alt fa-rotate-90 fa-2x"></i><br>Llamar a
                    Central</a>
            </div>
        </div>
        <hr>

        <div class="row">
            <h5 class="text-center text-secondary">INFORMACIÓN DE PÁNICO</h5>
            <div class="col-12 col-md-6 d-grid mb-3">
                <div class="mb-3">
                    <label for="files" class="form-label text-primary"><strong>Multimedia</strong></label>
                    <input class="form-control" type="file" id="files" multiple accept="image/*,audio/*"
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
            </div>

            <div class="col-12 col-md-6 d-grid mb-3">
                <div class="mb-3">
                    <label for="txtinforme" class="form-label text-primary"><strong>Informe</strong></label>
                    <textarea class="form-control" id="txtinforme" wire:model.lazy='informe'></textarea>
                </div>
            </div>
        </div>
        <div class="d-grid">
            <button class="btn btn-primary" id="enviar">ENVIAR <i class="fas fa-paper-plane"></i></button>
        </div>

    </section>
</div>
@section('js')
<script>
    const button = document.getElementById('button-call');
        const buttonEnviar = document.getElementById('enviar');

        button.addEventListener('click', () => {
            button.disabled = true;
            var telefono = document.getElementById('telephone');
            telefono.classList.remove('temblor');
            telefono.classList.add('greyscale');
        });


        buttonEnviar.addEventListener('click', () => {
            paso1();
            // console.log('paso 1 activo');
        });


        var contador = 5;
        var numero = document.getElementById('numero');
        var llamar = document.getElementById('llamar');

        function iniciarContador() {

            let intervalo = setInterval(function() {
                console.log(contador);
                if (button.disabled == false) {
                    if (contador === 1) {
                        clearInterval(intervalo);
                        contador--;
                        numero.innerText = contador;

                        if (navigator.geolocation) {
                            // navigator.geolocation.getCurrentPosition(success);
                            llamar.click();
                        } else {
                            console.log("Llamando");
                        }

                    } else {
                        contador--;

                        numero.innerText = contador;
                    }
                } else {
                    clearInterval(intervalo);
                }

            }, 1000);
        }

        function llamada() {
            button.disabled = true;
            var telefono = document.getElementById('telephone');
            telefono.classList.remove('temblor');
            telefono.classList.add('greyscale');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success);
            }else{
                console.log('No entro');
            }
        }

        function success(geoLocationPosition) {
            // console.log(geoLocationPosition.timestamp);
            let data = [
                geoLocationPosition.coords.latitude,
                geoLocationPosition.coords.longitude,
                'ALTA',
                'Llamada de Panico'
            ];
            Livewire.emit('guardarRegistro', data);
        }

        function success2(geoLocationPosition) {
            console.log(geoLocationPosition.timestamp);
            let data = [
                geoLocationPosition.coords.latitude,
                geoLocationPosition.coords.longitude,
            ];
            // console.log('registro Panico');
            Livewire.emit('registroPanico', data);
        }

        function paso1() {
            button.disabled = true;
            var telefono = document.getElementById('telephone');
            telefono.classList.remove('temblor');
            telefono.classList.add('greyscale');
            Swal.fire({
                title: 'Guardar Registro',
                text: "Está seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (navigator.geolocation) {
                        // console.log('enviando coord');
                        navigator.geolocation.getCurrentPosition(success2);
                    }
                }
            })

        }

        document.addEventListener('DOMContentLoaded', () => {
            iniciarContador();
        });
</script>
@endsection