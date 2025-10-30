<div class="container-fluid px-3 py-2" style="margin-top: 110px;">
    @section('title', 'Mis Asistencias')
    <!-- Header / back -->
    <div class="d-flex align-items-center mb-3">
        <a class="btn btn-link p-0 me-2" href="{{route('vigilancia.profile')}}" aria-label="Volver">
            <i class="fas fa-arrow-left fa-lg"></i>
        </a>
        <h4 class="mb-0">Mis Asistencias</h4>

    </div>

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="input-group mb-3">
                <label class="input-group-text" for="gestionID">Año</label>
                <select class="form-select" id="gestionID" wire:model="gestionSel">
                    @foreach ($gestiones as $gestion)
                    <option value="{{$gestion}}" @if ($gestion===date('Y')) selected @endif>{{$gestion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-group mb-3">
                <label class="input-group-text" for="mesID">Mes</label>
                <select class="form-select" id="mesID" wire:model="mesSel">
                    @foreach ($meses as $mes)
                    <option value="{{$mes['id']}}">{{$mes['nombre']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12 col-md-4 d-grid">
            <button class="btn btn-primary" wire:click="buscar" wire:loading.attr="disabled" wire:loading.target="buscar">
                Buscar <i class="fas fa-search"></i>
                <div wire:loading wire:target="buscar" class="spinner-border spinner-border-sm" role="status">
            </button>
        </div>
    </div>
    @if ($resultados)
    @php
    // obtiene el nombre del mes a partir del id seleccionado; si no existe, muestra el id
    $mesNombre = collect($meses)->firstWhere('id', $mesSel)['nombre'] ?? $mesSel;
    @endphp

    <h5 class="text-muted text-center mt-3" style="font-size: 15px">RESULTADOS DE ASISTENCIA <br>
        {{strtoupper($mesNombre)}}/{{$gestionSel}}</h5>

    <!-- Contenedor desplazable para que el tbody haga scroll y el thead quede fijo -->
    <style>
        /* Ajusta la altura máxima visible según necesites */
        .table-wrapper {
            max-height: 60vh;
            overflow: auto;
        }

        /* Hace los th pegajosos */
        .table-wrapper table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            background: #1abc9c; /* asegúrate de que el fondo no sea transparente */
            /* opcional: sombra para separación visual */
            box-shadow: 0 2px 2px -1px rgba(0,0,0,0.15);
        }
    </style>

    <div class="table-wrapper">
        <table class="table table-striped table-bordered" style="font-size: 12px;">
            <thead>
                <tr class="text-center text-white">
                    <th>FECHA</th>
                    <th>INGRESO</th>
                    <th>SALIDA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diasMes as $dia)
                @php
                // Buscamos la asistencia correspondiente a este día
                $asistenciaDia = collect($resultados)->first(function ($a) use ($dia) {
                    return substr($a->ingreso, 0, 10) == $dia || substr($a->salida, 0, 10) == $dia;
                });
                @endphp

                <tr class="text-center">
                    <td class="align-middle"><strong>{{ $dia }}</strong></td>

                    {{-- Columna Ingreso --}}
                    <td class="align-middle">
                        {!! $asistenciaDia && $asistenciaDia->ingreso
                        ?'<strong class="text-primary">' . substr($asistenciaDia->ingreso, 0, 10) . '<br>' . substr($asistenciaDia->ingreso, 11, 8) . '</strong>'
                        : 'Sin marcado' !!}
                    </td>

                    {{-- Columna Salida --}}
                    <td class="align-middle">
                        {!! $asistenciaDia && $asistenciaDia->salida
                        ? '<strong class="text-blue">'.substr($asistenciaDia->salida, 0, 10) . '<br>' . substr($asistenciaDia->salida, 11, 8).'</strong>'
                        : 'Sin marcado' !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>