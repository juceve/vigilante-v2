<div>
    @section('title')
        Puntos de Control
    @endsection
    @section('content_header')
        <h4>Puntos de Control</h4>
    @endsection

    <div class="container-fluid">

        <div class="card">
            <div class="card-header bg-info">
                <div style="display: flex; justify-content: space-between; align-items: center;">

                    <span id="card_title">
                        CLIENTE: <strong>{{ $turno->cliente->nombre }}</strong>
                    </span>

                    <div class="float-right">
                        <a href="javascript:history.back()" class="btn btn-info btn-sm float-right" data-placement="left">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                TURNO: <strong>{{ $turno->nombre }}</strong>
                <hr>
                <div class="form-group">
                    <label>Listado de Puntos de Control</label>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-info">
                                    <tr>
                                        <th>Nro.</th>
                                        <th>Nombre</th>
                                        <th>Hora</th>
                                        {{-- <th>Latitud</th>
                                <th>Longitud</th> --}}
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($puntos as $punto)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $punto->nombre }}</td>
                                            <td>{{ $punto->hora }}</td>
                                            {{-- <td>{{ $punto->latitud }}</td>
                                    <td>{{ $punto->longitud }}</td> --}}
                                            <td align="right">
                                                <button class="btn btn-outline-danger btn-sm" title="Eliminar de la DB"
                                                    onclick="eliminar({{ $punto->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <button type="button" onClick="window.location.reload()" class="btn btn-success">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="mi_mapa2" style="width: 100%; height: 400px" wire:ignore></div>
                        <strong>Haga Click en el mapa para registrar un Nuevo Punto</strong>
                    </div>
                </div>
                <div style="display: none" id="nuevopt" wire:ignore.self>
                    <h5>Registrar Nuevo Punto</h5>
                    <div class="row">

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                {{-- <label>Nombre:</label> --}}
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre de Punto"
                                    wire:model='nombre' required>
                                @error('nombre')
                                    <small class="text-danger">El campo Nombre es requerido.</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                {{-- <label>Hora:</label> --}}
                                <input type="time" class="form-control" id="hora" required wire:model='hora'>
                                @error('hora')
                                    <small class="text-danger">El campo Hora es requerido.</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <button class="btn btn-primary btn-block" wire:click='registrarPunto'>Registrar</button>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="javascript:location.reload();" class="btn btn-secondary btn-block">Cancelar</a>
                        </div>
                        <div class="col-12 col-md-3 d-none">
                            <div class="form-group">
                                <label>Latitud:</label>
                                <input type="text" class="form-control" id="latitud" required
                                    placeholder="Seleccione un punto en el Mapa" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 d-none">
                            <div class="form-group">
                                <label>Longitud:</label>
                                <input type="text" class="form-control" id="longitud" required
                                    placeholder="Seleccione un punto en el Mapa" readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@section('plugins.OpenStreetMap', true)
@section('js')

    <script>
        let map2 = L.map('mi_mapa2').setView([{{ $cliente->latitud }}, {{ $cliente->longitud }}], 18)
        var auxMarker = "";
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy;'
        }).addTo(map2);

        var arr1 = "{{ $pnts }}";
        arr1 = arr1.split('$');
        const puntos = [];

        if (arr1[0] != "") {
            for (let i = 0; i < arr1.length; i++) {
                const pt = arr1[i].split("|");
                puntos[i] = pt;
                L.marker([pt[1], pt[2]], {
                    title: (pt[0])
                }).addTo(map2);
            }
        }


        map2.on('click', onMapClick)

        function onMapClick(e) {
            if (auxMarker) {
                map2.removeLayer(auxMarker);
            }
            var greenIcon = new L.Icon({
                iconUrl: "{{ asset('images/img-maps/marker-icon-2x-green.png') }}",
                shadowUrl: "{{ asset('images/img-maps/marker-shadow.png') }}",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            $('#nuevopt').css("display", "block");
            $('#nombre').focus();

            var coord = e.latlng;


            $('#latitud').val(coord['lat']);
            $('#longitud').val(coord['lng']);
            var data = [coord['lat'], coord['lng']];
            // console.log(data);
            Livewire.emit('cargaLatLng', data)
            auxMarker = L.marker(data, {
                icon: greenIcon
            }).addTo(map2);

        }

        Livewire.on('ocultar', () => {
            $('#nuevopt').css("display", "none");
        });
    </script>

    <script src="{{ asset('vendor/jquery/scripts.js') }}"></script>
    @include('vendor.mensajes')
    <script>
        function registrar() {
            var nombre = document.getElementById('nombre');
            var hora = document.getElementById('hora');
            var latitud = document.getElementById('latitud');
            var longitud = document.getElementById('longitud');
            if (nombre.value != "" && hora.value != "" && latitud.value != "" && longitud.value != "") {
                const data = [nombre.value, hora.value, latitud.value, longitud.value];
                Livewire.emit('registrarPunto', data);
                document.getElementById('nombre').value = "";
                document.getElementById('hora').value = "";
                document.getElementById('latitud').value = "";
                document.getElementById('longitud').value = "";
            }
        }

        function eliminar(id) {
            Swal.fire({
                title: 'Eliminar Punto',
                text: "Esta seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'No, cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('delete', id);
                }
            })
        }
    </script>

@endsection
