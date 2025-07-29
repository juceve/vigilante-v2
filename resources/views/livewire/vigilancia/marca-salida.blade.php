<div class="container mt-3">
    <div class="row">
        <div class="col-12 text-center d-grid">
            <button class="btn btn-secondary  btn-sm d-grid py-4" onclick="marcar()">
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
    localize();

        function localize() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(enviar);
            } else {
                alert('Tu navegador no soporta geolocalizacion.');
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
        }
</script>
<script>
    function marcar() {
            Swal.fire({
                title: "FINALIZAR TURNO",
                text: "Esta seguro de realizar el marcado de salida?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "SI, marcar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('marcar');
                }
            });
        }
</script>
@endsection