<div>
    @section('title')
        Hombre Vivo
    @endsection
    <div class="row mb-3">
        <div class="col-1">
            <a href="{{ route('home') }}" class="text-silver"><i class="fas fa-arrow-circle-left fa-2x"></i></a>
        </div>
        <div class="col-10">
            <h4 class="text-secondary text-center">HOMBRE VIVO</h4>
        </div>
        <div class="col-1"></div>
    </div>
    <div class="content">
        @if ($intervalo)
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white text-center">HORA PROGRAMADA: {{ $intervalo->hora }}</h4 class="text-primary">
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Anotaciones:</label>
                        <textarea class="form-control" wire:model='anotaciones' rows="2"></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" name="" id="" class="btn btn-primary py-3"
                            wire:click='reportarse'>Reportarse Activo <i class="fa-solid fa-person-rays"></i></button>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-success text-center" role="alert">
                NO CUENTA CON PETICIONES ACTIVAS
            </div>
        @endif

    </div>
</div>
@section('js')
    @if ($intervalo)
        <script>
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success2);
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
    @endif
@endsection
