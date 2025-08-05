<div>
    <div class="container text-center d-grid mt-5">
        <button class="btn btn-primary py-4" wire:click='marcar' wire:loading.attr="disabled" id="btn-guardar" onclick="activarGeolocalizacion()">
            <h4 class="text-secondary"><i class="fas fa-user-clock"></i> INICIAR TURNO</h4> <small
                class="text-secondary"><b>{{ $designacione->turno->horainicio }} HRS.</b></small>
        </button>
        <small class="text-muted mt-2">Se solicitará su ubicación al iniciar el turno</small>
    </div>
</div>
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btn-guardar');

            btn.addEventListener('click', function() {
                if (btn.disabled) return;
                btn.disabled = true;
            });
        });
    </script>
    <script>
        // Función que se ejecuta solo cuando el usuario hace clic en el botón
        window.activarGeolocalizacion = function() {
            localize();
        };

        function localize() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(enviar, error);
            } else {
                alert('Tu navegador no soporta geolocalizacion.');
            }
        }

        function enviar(pos) {
            var latitud = pos.coords.latitude;
            var longitud = pos.coords.longitude;
            let data = [
                latitud,
                longitud,
            ];
            Livewire.emit('cargaPosicion', data);
        }

        function error(err) {
            console.warn('Error de geolocalización:', err);
            // Continuar sin geolocalización
            Livewire.emit('cargaPosicion', [null, null]);
        }
    </script>
@endsection
