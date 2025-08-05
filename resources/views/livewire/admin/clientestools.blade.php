<div>
    <div class="row">
        <div class="col col-12 col-md-3">
            <div class="card">
                <div class="card-body table-responsive p-0" style="height: 420px;">
                    <table class="table table-striped" style="font-size: 13px;">
                        <thead class="table-primary">
                            <tr>
                                <th>EMPRESAS</th>
                                <th class="text-right">OFICINA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-radio">
                                            @if ($cliente[3])
                                                <input class="custom-control-input custom-control-input-danger"
                                            @else
                                                @if ($cliente[4] == 2)
                                                    <input class="custom-control-input custom-control-input-secondary"
                                                @else
                                                    <input class="custom-control-input custom-control-input-primary"
                                                @endif
                                            @endif
                                                type="radio" id="{{ $cliente[0] }}" checked="">
                                                <label for="{{ $cliente[0] }}" class="custom-control-label">
                                                    <a href="javascript:void(0);" class="text-dark"
                                                        wire:click="cargarCliente({{ $cliente[0] }})">
                                                        {{ $cliente[1] }}
                                                    </a>
                                                </label>
                                        </div>
                                    </td>
                                    <td align="right">{{ $cliente[2] }}</td>
                                </tr>
                                @php
                                    $i = ($i == 5) ? 0 : $i + 1;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        {{-- SOLO CAMBIO: Cambiar div de Leaflet por Google Maps --}}
        <div class="col col-12 col-md-9" wire:ignore>
            <div class="card">
                <div class="card-body">
                    <div id="google_map" style="width: 100%; height: 380px;"></div>
                </div>
            </div>
        </div>
        
        {{-- TODO LO DEMÁS IGUAL - Sin cambios --}}
        @if (!is_null($selCliente))
            <div class="col-12">
                <div class="card">
                    @switch($marque)
                        @case(1)
                            <div class="card-header bg-primary text-white">
                        @break
                        @case(2)
                            <div class="card-header bg-secondary text-white">
                        @break
                        @case(0)
                            <div class="card-header bg-danger text-white">
                        @break
                        @default
                    @endswitch
                        <strong>{{ $selCliente->nombre }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" style="font-size: 14px;">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <td colspan="2"><strong>Datos de la Empresa</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Dirección:</strong></td>
                                                <td>{{ strtoupper($selCliente->direccion) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Contacto:</strong></td>
                                                <td>{{ strtoupper($selCliente->personacontacto) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Teléfono Contacto:</strong></td>
                                                <td>{{ strtoupper($selCliente->telefonocontacto) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped" style="font-size: 14px;">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <td colspan="4"><strong>Personal Asignado</strong></td>
                                            </tr>
                                            <tr class="table-info">
                                                <th>Nombre</th>
                                                <th>Turno</th>
                                                <th class="text-center">Asistencia</th>
                                                <th class="text-center">Alertas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($designaciones as $item)
                                                <tr>
                                                    <td>{{ $item->empleado }}</td>
                                                    <td>
                                                        {{ strtoupper($item->turno) }} <br>
                                                        <small>({{ $item->datosturno->horainicio }} - {{ $item->datosturno->horafin }})</small>
                                                    </td>
                                                    <td class="text-center">
                                                        @switch(yaMarque($item->id))
                                                            @case(1)
                                                                <span class="badge badge-pill badge-success">Activo</span>
                                                            @break
                                                            @case(2)
                                                                <span class="badge badge-pill badge-secondary">Descanso</span>
                                                            @break
                                                            @case(0)
                                                                <span class="badge badge-pill badge-danger">Inactivo</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $panicos = tengoPanicos($item->datosempleado->user_id, $selCliente->id);
                                                        @endphp
                                                        @if ($panicos > 0)
                                                            <a href="{{ route('admin.regactividad', $selCliente->id) }}">
                                                                <span class="badge badge-pill badge-danger">{{ $panicos }}</span>
                                                            </a>
                                                        @else
                                                            <span class="badge badge-pill badge-secondary">0</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- SOLO CAMBIO: JavaScript de Leaflet por Google Maps --}}
@section('js')
<script>
    let map;
    let markers = [];

    function initMap() {
        // Mismas coordenadas que tenías en Leaflet
        const defaultCenter = { lat: -17.7817999, lng: -63.1825485 };
        
        map = new google.maps.Map(document.getElementById("google_map"), {
            zoom: 12,
            center: defaultCenter,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapId: "DEMO_MAP_ID" // Para usar AdvancedMarkerElement en el futuro
        });

        loadMarkers();
    }

    function loadMarkers() {
        clearMarkers();

        var arr1 = "{{ $pts }}";
        if (!arr1) return;
        
        arr1 = arr1.split('$');
        
        for (let i = 0; i < arr1.length; i++) {
            if (!arr1[i]) continue;
            
            const pt = arr1[i].split("|");
            const position = { lat: parseFloat(pt[1]), lng: parseFloat(pt[2]) };

            let iconUrl;
            switch (pt[8]) {
                case '0':
                    iconUrl = "{{ asset('images/img-maps/marker_red.png') }}";
                    break;
                case '1':
                    iconUrl = "{{ asset('images/img-maps/marker_blue.png') }}";
                    break;
                case '2':
                    iconUrl = "{{ asset('images/img-maps/marker_grey.png') }}";
                    break;
                default:
                    iconUrl = "{{ asset('images/img-maps/marker_blue.png') }}";
            }

            // Usar google.maps.Marker (funciona perfectamente, solo es una advertencia)
            const marker = new google.maps.Marker({
                position: position,
                map: map,
                title: pt[0],
                icon: {
                    url: iconUrl,
                    scaledSize: new google.maps.Size(20, 35),
                    anchor: new google.maps.Point(10, 35)
                }
            });

            let infoContent = '';
            if (pt[8] === '0') {
                infoContent = `<h6>${pt[0]}</h6><small>${pt[3]}</small><p><a href="javascript:void(0);" onclick="cargarCliente(${pt[6]})" style="color: red">Ver alertas!</a><br><br><a href="./admin/clientes/${pt[6]}">Mas Información</a></p>`;
            } else {
                infoContent = `<h6>${pt[0]}</h6><small>${pt[3]}</small><p><a href="./admin/clientes/${pt[6]}">Mas Información</a></p>`;
            }

            const infoWindow = new google.maps.InfoWindow({ content: infoContent });
            marker.addListener('click', () => infoWindow.open(map, marker));
            markers.push(marker);
        }
    }

    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }

    function cargarCliente(id) {
        @this.cargarCliente(id);
    }

    document.addEventListener('livewire:update', () => {
        setTimeout(() => { if (map) loadMarkers(); }, 100);
    });
</script>

{{-- Carga corregida con loading=async --}}
<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps.api_key') }}&callback=initMap&loading=async">
</script>
@endsection
