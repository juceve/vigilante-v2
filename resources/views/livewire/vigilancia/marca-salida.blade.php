<div class="container mt-3">
    <div class="row">
        <div class="col-12 text-center d-grid">
            <button class="btn btn-secondary  btn-sm d-grid py-4" onclick="prepararMarcado()">
                <div class="row">
                    <div class="col-6 text-start">Marcar Salida</div>
                    <div class="col-6 text-end">
                        <small class="text-danger"><b>{{ $designacione->turno->horafin }} Hrs.</b></small>
                    </div>
                </div>
            </button>
        </div>
    </div>
</div>
@section('js')
<script>
        function localize() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(enviar, function(error) {
                    console.error('Error obteniendo ubicación:', error);
                    Swal.fire('Advertencia', 'No se pudo obtener la ubicación. Se marcará sin coordenadas.', 'warning');
                    marcar(); // Marcar sin coordenadas si falla la geolocalización
                });
            } else {
                Swal.fire('Error', 'Tu navegador no soporta geolocalización.', 'error');
                marcar(); // Marcar sin coordenadas si no hay soporte
            }
        }

        function enviar(pos) {
            var latitud = pos.coords.latitude;
            var longitud = pos.coords.longitude;
            // var precision = pos.coords.accuracy;
            let data = [
                latitud,
                longitud,
            ];
            Livewire.emit('cargaPosicion', data);
            // Ejecutar el marcado después de cargar la posición
            marcar();
        }
</script>
<script>
    function prepararMarcado() {
        Swal.fire({
            title: "FINALIZAR TURNO",
            text: "Esta seguro de realizar el marcado de salida? Se obtendrá su ubicación actual.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "SI, marcar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // Obtener ubicación después de la confirmación del usuario
                localize();
            }
        });
    }
    
    function marcar() {
        Livewire.emit('marcar');
    }
</script>
@endsection