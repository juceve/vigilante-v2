<div>
    <div class="container text-center d-grid mt-5">
        <button class="btn btn-primary py-4" id="btn-guardar" onclick="activarGeolocalizacion()">
            <h4 class="text-secondary"><i class="fas fa-user-clock"></i> INICIAR TURNO</h4> 
            <small class="text-secondary">
                <b>{{ $designacione->turno->horainicio }} HRS.</b>
            </small>
        </button>
        <small class="text-muted mt-2">Se solicitará su ubicación al iniciar el turno</small>
    </div>
</div>

@section('js')
    <script>
        function activarGeolocalizacion() {
            const btn = document.getElementById('btn-guardar');
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(enviar, error);
            } else {
                alert('Tu navegador no soporta geolocalizacion.');
                Livewire.emit('cargaPosicion', [null, null]);
            }
        }

        function enviar(pos) {
            let latitud = pos.coords.latitude;
            let longitud = pos.coords.longitude;
            Livewire.emit('cargaPosicion', [latitud, longitud]);
        }

        function error(err) {
            console.warn('Error de geolocalización:', err);
            Livewire.emit('cargaPosicion', [null, null]);
        }
    </script>
@endsection
