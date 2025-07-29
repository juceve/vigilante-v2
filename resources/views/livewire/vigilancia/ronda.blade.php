<div>
    @section('title')
    Ronda
    @endsection
    <div class="row mb-3">
        <div class="col-1">
            <a href="{{ route('home') }}" class="text-silver"><i class="fas fa-arrow-circle-left fa-2x"></i></a>
        </div>
        <div class="col-10">
            <h4 class="text-secondary text-center">RONDA</h4>
        </div>
        <div class="col-1"></div>

    </div>
    <div class="container text-center mb-3">
        @if ($designacion)
        <table class="table table-bordered text-info">
            <tr>
                <th>
                    <strong>{{ $designacion->turno->cliente->nombre }}</strong>
                </th>
                <th>
                    <strong>{{ $designacion->turno->nombre }}</strong>
                </th>
            </tr>
        </table>
        @if ($diaLaboral)
        @if (!$puntoRegistrado)
        @if ($proxpunto)
        <section>
            <div class="card" wire:ignore>
                <div class="card-header text-center">
                    <h5 class="text-primary">Punto Programado: {{ $proxpunto->hora }}</h5>
                </div>
                <div class="card-body">
                    <div id="mapa" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
            {{-- <div class="form-group d-grid mt-2" id="btnUbicacion" wire:ignore.self>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalCamara"
                    onclick="encenderCamara()">
                    <i class="fas fa-camera"></i> Verificar Mi Ubicación
                </button>
            </div> --}}
            <div id="infoUbicacion" class="d-none mt-3" wire:ignore.self>
                <table class="table table-sm table-bordered">
                    <tr class="table-warning">
                        <td colspan="2"><input type="text" class="form-control form-control-sm text-center"
                                wire:model='nombre' readonly>
                        </td>
                    </tr>
                    <tr class="table-success">
                        <td><label><small>Latitud:</small></label><input type="text"
                                class="form-control form-control-sm" wire:model='lat' readonly></td>
                        <td><label><small>Longitud:</small></label><input type="text"
                                class="form-control form-control-sm" wire:model='lng' readonly></td>
                    </tr>

                </table>
            </div>
            <div class="form-group mt-3 d-grid" id="divMarcarArribo" wire:ignore.self>
                <div class="form-group">
                    <label for="">Anotaciones:</label>
                    <textarea class="form-control mb-2" wire:model.debounce.800ms='anotaciones'></textarea>
                </div>
                <div class="col-12 col-md-6 d-grid mb-3">
                    <div class="mb-3">
                        <label for="files" class="form-label text-primary"><strong>Multimedia</strong></label>
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
                </div>
                <button class="btn btn-primary" wire:click='regRonda' wire:loading.attr='disabled'>Marcar arribo <i
                        class="fas fa-map-marker-alt"></i></button>

            </div>
        </section>
        @else
        <div class="alert alert-success" role="alert">
            No existen más puntos de control.
        </div>
        @endif
        @else
        <div class="alert alert-warning" role="alert">
            Punto de control ya registrado.
        </div>
        @endif
        @else
        <div class="alert alert-warning" role="alert">
            Dia no laborable para esta designación.
        </div>
        @endif
        @else
        <div class="alert alert-danger" role="alert">
            No exiten asignaciones habilitadas.
        </div>

        @endif


    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCamara" tabindex="-1" aria-labelledby="modalCamaraLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCamaraLabel">Lector de QR</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrarCamara()"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <a id="btn-scan-qr" href="#">
                            <img src="https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg"
                                class="img-fluid text-center" width="175">
                        </a>
                        <canvas hidden="" id="qr-canvas" class="img-fluid"></canvas>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeModal" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="cerrarCamara()"><i class="fas fa-times-circle"></i> Cerrar</button>

                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script src="{{ asset('vendor/qr/qrCode.min.js') }}"></script>
<script src="{{ asset('vendor/qr/index.js') }}"></script>
@if ($proxpunto)
<script>
    let map;
            initMap();

            function initMap() {
                var latitud = {{ $cliente->latitud ? $cliente->latitud : '-17.7817999' }};
                var longitud = {{ $cliente->longitud ? $cliente->longitud : '-63.1825485' }};

                map = L.map('mapa').setView([latitud, longitud], 17)

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy;'
                }).addTo(map);

                L.marker([{{ $proxpunto->latitud }}, {{ $proxpunto->longitud }}], {
                    title: 'Punto de Control'
                }).addTo(map);
                if (navigator.geolocation) {
                    let miUbicacion = navigator.geolocation.getCurrentPosition(success);
                }
            }


            function success(geoLocationPosition) {

                let data = [
                    geoLocationPosition.coords.latitude,
                    geoLocationPosition.coords.longitude,
                ];

                var greenIcon = new L.Icon({
                    iconUrl: "{{ asset('images/img-maps/marker-icon-2x-green.png') }}",
                    shadowUrl: "{{ asset('images/img-maps/marker-shadow.png') }}",
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                auxMarker = L.marker(data, {
                    icon: greenIcon,
                    title: 'Mi Ubicacion'
                }).addTo(map);


                Livewire.emit('ubicacionAprox', data);
            }
</script>
@endif

<script>
    Livewire.on('resultadoQr', () => {

            // div1 = document.getElementById('btnUbicacion');
            // div1.classList.add("d-none");

            // div2 = document.getElementById('infoUbicacion');
            // div2.classList.remove('d-none')

            // div3 = document.getElementById('divMarcarArribo');
            // div3.classList.remove('d-none')
        });
</script>
@endsection