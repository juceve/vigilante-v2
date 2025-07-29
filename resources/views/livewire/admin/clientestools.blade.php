<div>
    <div class="row">
        <div class="col col-12 col-md-3">
            <div class="card">
                <div class="card-body table-responsive p-0" style="height: 420px;">
                    <table class="table table-striped" style="font-size: 13px;">
                        <thead class="table-primary">
                            <tr>
                                <th>
                                    EMPRESAS
                                </th>
                                <th class="text-right">
                                    OFICINA
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0;
                            @endphp
                            @foreach ($clientes as $cliente)
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        @if ($cliente[3])
                                        <input class="custom-control-input custom-control-input-danger" @else
                                            @if($cliente[4]==2) <input
                                            class="custom-control-input custom-control-input-secondary" @else <input
                                            class="custom-control-input custom-control-input-primary" @endif @endif
                                            type="radio" id="{{ $cliente[0] }}" checked="">
                                        <label for="{{ $cliente[0] }}" class="custom-control-label">
                                            <a href="javascript:void(0);" class="text-dark"
                                                wire:click="cargarCliente({{$cliente[0]}})">
                                                {{ $cliente[1] }}

                                            </a>
                                        </label>
                                    </div>
                                </td>
                                <td align="right">
                                    {{ $cliente[2] }}
                                </td>
                            </tr>
                            @php
                            if ($i == 5) {
                            $i = 0;
                            } else {
                            $i++;
                            }
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-9" wire:ignore>
            <div class="card">
                <div class="card-body">
                    <div id="mi_mapa" style="width: 100%; height: 380px;"></div>
                </div>
            </div>
        </div>
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

                            <strong>{{$selCliente->nombre}}</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-sm  table-bordered table-striped"
                                            style="font-size: 14px;">
                                            <thead>
                                                <tr class="bg-info text-white">
                                                    <td colspan="2"><strong>Datos de la Empresa</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Dirección:</strong></td>
                                                    <td>{{strtoupper($selCliente->direccion)}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Contacto:</strong></td>
                                                    <td>{{strtoupper($selCliente->personacontacto)}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Teléfono Contacto:</strong></td>
                                                    <td>{{strtoupper($selCliente->telefonocontacto)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-striped"
                                            style="font-size: 14px;">
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
                                                    <td>{{$item->empleado}}</td>
                                                    <td>
                                                        {{strtoupper($item->turno)}} <br>
                                                        <small>({{$item->datosturno->horainicio}} -
                                                            {{$item->datosturno->horafin}})</small>
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
                                                        $panicos =tengoPanicos($item->datosempleado->user_id,
                                                        $selCliente->id);

                                                        @endphp
                                                        @if ($panicos>0)
                                                        <a href="{{route('admin.regactividad',$selCliente->id)}}">
                                                            <span class="badge badge-pill badge-danger">
                                                                {{$panicos}}
                                                            </span>
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
        @section('plugins.OpenStreetMap', true)
        @section('js')
        <script>
            let map = L.map('mi_mapa').setView([-17.7817999, -63.1825485], 12)

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy;'
        }).addTo(map);

        var arr1 = "{{ $pts }}";
        arr1 = arr1.split('$');
        const puntos = [];

        var myIcon = L.icon({
            iconUrl: "{{ asset('images/img-maps/marker_blue.png') }}",
            iconSize: [20, 35],
            iconAnchor: [35, 35],
            popupAnchor: [-15, -30],
        });

        var myIconR = L.icon({
            iconUrl: "{{ asset('images/img-maps/marker_red.png') }}",
            iconSize: [20, 35],
            iconAnchor: [35, 35],
            popupAnchor: [-15, -30],
        });
        var myIconG = L.icon({
            iconUrl: "{{ asset('images/img-maps/marker_grey.png') }}",
            iconSize: [20, 35],
            iconAnchor: [35, 35],
            popupAnchor: [-15, -30],
        });

        for (let i = 0; i < arr1.length; i++) {
            const pt = arr1[i].split("|");
            puntos[i] = pt;
            switch (pt[8]) {
                case '0':
                L.marker(
            [pt[1], pt[2]], 
            {icon: myIconR}
            ).addTo(map).bindPopup('<h6>' + pt[0] + '</h6><small>' + pt[3] +
                '</small><p><a href="javascript:void(0);" onclick="cargarCliente('+ pt[6]+')" style="color: red">Ver alertas!</a><br><br><a href="./admin/clientes/' + pt[6] + '">' +
                'Mas Información</a></p>');
                    break;
                case '1':
                L.marker(
            [pt[1], pt[2]], 
            {icon: myIcon}
            ).addTo(map).bindPopup('<h6>' + pt[0] + '</h6><small>' + pt[3] +
                '</small><p><a href="./admin/clientes/' + pt[6] + '">' +
                'Mas Información</a></p>');
                    break;
                case '2':
                L.marker(
            [pt[1], pt[2]], 
            {icon: myIconG}
            ).addTo(map).bindPopup('<h6>' + pt[0] + '</h6><small>' + pt[3] +
                '</small><p><a href="./admin/clientes/' + pt[6] + '">' +
                'Mas Información</a></p>');
                    break;
            }


            // if (pt[7]==1) {
            //     L.marker(
            // [pt[1], pt[2]], 
            // {icon: myIconR}
            // ).addTo(map).bindPopup('<h6>' + pt[0] + '</h6><small>' + pt[3] +
            //     '</small><p><a href="javascript:void(0);" onclick="cargarCliente('+ pt[6]+')" style="color: red">Ver alertas!</a><br><br><a href="./admin/clientes/' + pt[6] + '">' +
            //     'Mas Información</a></p>');
            // } else {
            //     L.marker(
            // [pt[1], pt[2]], 
            // {icon: myIcon}
            // ).addTo(map).bindPopup('<h6>' + pt[0] + '</h6><small>' + pt[3] +
            //     '</small><p><a href="./admin/clientes/' + pt[6] + '">' +
            //     'Mas Información</a></p>');
            // }
            
        }
        // map.on('click', onMapClick)

        // function onMapClick(e) {
        //     alert("Posición: " + e.latlng)
        // }
        function cargarCliente(id){
            @this.cargarCliente(id);
        }
        </script>

        @endsection