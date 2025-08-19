<div>
    @php
        $meses_es = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
    @endphp

    @section('title')
        Sueldos
    @endsection

    @section('content_header')
        <div class="container-fluid">
            <h4>PROCESAR SUELDOS</h4>
            <h5>
                <strong>Gestión:</strong> {{ $rrhhsueldo->gestion }} -
                <strong>Mes:</strong> {{ $meses_es[$rrhhsueldo->mes] }}
            </h5>
        </div>
    @endsection
    {{-- @dump($contratosVigentes) --}}
    <div class="container-fluid">
        {{-- Buscador --}}
        <div class="row mb-3">
            <div class="col-md-4 mb-2">
                <div class="input-group">
                    <input wire:model.debounce.500ms="searchEmpleado" type="search" class="form-control"
                        placeholder="Buscar empleado por nombre o apellido...">
                    <div class="input-group-append">
                        <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-8 text-right mb-2">
               
                <button class="btn btn-primary" wire:click="procesarSueldos">
                    <i class="fas fa-cogs"></i> Procesar Sueldos
                </button>
            </div>
        </div>

        {{-- Alerta de contratos solapados --}}
        @if (isset($alertasSolapamiento) && $alertasSolapamiento->count())
            <div class="alert alert-warning">
                <strong>¡Atención!</strong> Existen empleados con más de un contrato activo en este periodo:
                <ul>
                    @foreach ($alertasSolapamiento as $empleado)
                        <li>{{ $empleado->nombres }} {{ $empleado->apellidos ?? '' }}</li>
                    @endforeach
                </ul>
                Por favor, revise y corrija estos casos para evitar inconsistencias en el pago de sueldos.
            </div>
        @endif

        <div class="card card-primary card-outline shadow">
            <div class="card-body">
                {{-- <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>Total registros:</strong>
                        <span class="text-primary font-weight-bold">
                            {{ $this->contratosFiltrados->count() }}
                        </span>
                    </div>
                </div> --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">Nro.</th>
                                <th>Empleado</th>
                                <th class="text-center">Salario Asistencia</th>
                                <th class="text-center">Total Permisos</th> <!-- NUEVA COLUMNA -->
                                <th class="text-center">Total Adelantos</th>
                                <th class="text-center">Total Bonos</th>
                                <th class="text-center">Total Ctrl Asist.</th>
                                <th class="text-center">Liquido Pagable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = ($this->contratosFiltrados->currentPage() - 1) * $this->contratosFiltrados->perPage() + 1; @endphp
                            @forelse($this->contratosFiltrados as $contrato)
                                <tr>
                                    <td class="text-center align-middle text-muted">{{ $i++ }}</td>
                                    <td>
                                        <div class="font-weight-bold text-primary" style="font-size: 1.08em;">
                                            {{ $contrato->empleado->nombres ?? '' }}
                                            {{ $contrato->empleado->apellidos ?? '' }}
                                        </div>
                                        <div class="text-secondary" style="font-size: 0.90em;">
                                            {{ $contrato->rrhhcargo->nombre ?? '-' }} &mdash;
                                            {{ $contrato->rrhhtipocontrato->nombre ?? '-' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 0.88em;">
                                            <span class="font-italic">Inicio contrato:</span>
                                            <span>{{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="text-dark" style="font-size: 0.90em;">
                                            <span class="font-italic">Sueldo:</span>
                                            <span class="font-weight-bold">{{ number_format($contrato->salario_basico, 2) }}</span>
                                        </div>
                                    </td>
                                    <td class="text-right align-middle text-info font-weight-bold">
                                        <span style="font-size: 0.98em;">
                                            {{ $procesado ? number_format($contrato->salario_asistencia, 2) : number_format($contrato->salario_basico, 2) }}
                                        </span>
                                    </td>

                                    <td
                                        class="text-center align-middle text-warning font-weight-bold">
                                        <span style="font-size: 0.98em;">
                                            {{ $procesado ? ($contrato->total_permisos ?? 0) : 0 }}
                                        </span>
                                    </td>

                                    <td
                                        class="text-right align-middle {{ $procesado && $contrato->total_adelantos > 0 ? 'text-danger font-weight-bold' : 'text-muted' }}">
                                        <span style="font-size: 0.98em;">
                                            {{ $procesado ? number_format(abs($contrato->total_adelantos), 2) : '0.00' }}
                                        </span>
                                    </td>
                                    <td
                                        class="text-right align-middle
                                        @if ($procesado && $contrato->total_bonos > 0) text-success font-weight-bold
                                        @elseif($procesado && $contrato->total_bonos < 0) text-danger font-weight-bold
                                        @else text-muted @endif">
                                        <span style="font-size: 0.98em;">
                                            {{ $procesado ? number_format(abs($contrato->total_bonos), 2) : '0.00' }}
                                        </span>
                                    </td>
                                    <td
                                        class="text-right align-middle
                                        @if ($procesado && $contrato->total_ctrl_asist > 0) text-danger font-weight-bold
                                        @elseif($procesado && $contrato->total_ctrl_asist < 0) text-success font-weight-bold
                                        @else text-muted @endif">
                                        <span style="font-size: 0.98em;">
                                            {{ $procesado ? number_format(abs($contrato->total_ctrl_asist), 2) : '0.00' }}
                                        </span>
                                    </td>
                                    <td
                                        class="text-right align-middle font-weight-bold
                                        @if ($procesado && $contrato->total_liquido_pagable > 0) text-primary
                                        @elseif($procesado && $contrato->total_liquido_pagable <= 0) text-danger
                                        @else text-dark @endif">
                                        <span style="font-size: 1.05em;">
                                            {{ $procesado ? number_format($contrato->total_liquido_pagable, 2) : number_format($contrato->salario_basico, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No hay contratos vigentes para
                                        este periodo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="float-right mt-3">
                        {{ $this->contratosFiltrados->links() }}
                    </div>
                </div>
                @if ($procesado)
                    <div class="row mt-3">
                        <div class="col-12 col-md-6"></div>
                        <div class="col-12 col-md-3 mb-3">
                            <button class="btn btn-secondary btn-block" onclick="cancelarProceso()"><i
                                    class="fas fa-ban"></i> Cancelar</button>
                        </div>
                        <div class="col-12 col-md-3">
                            <button class="btn btn-success btn-block" onclick="confirmarFinalizarProceso()">
                                Finalizar Proceso <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div> {{-- cierre de .container-fluid --}}

    <div wire:loading wire:target="procesarSueldos,finalizarProceso">
        <div
            style="
            position: fixed;
            top: 0; left: 0; 
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        ">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            &nbsp; Ejecutando operaciones, por favor espere...
        </div>


    </div>
</div> {{-- cierre del div principal --}}
@section('js')
    <script>
        function cancelarProceso() {
            Swal.fire({
                title: "Cancelar Proceso",
                text: "No podrás revertir esto, se perderá todos los resultados.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "No, cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.sueldos') }}";
                }
            });
        }

        function confirmarFinalizarProceso() {
            Swal.fire({
                title: "¿Finalizar Proceso?",
                text: "¿Está seguro de finalizar y registrar estos sueldos? Esta acción no se puede deshacer.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Sí, finalizar",
                cancelButtonText: "No, cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.finalizarProceso();
                }
            });
        }
    </script>
    <script>
        Livewire.on('renderizarpdf', id => {
            var win = window.open("../pdf/sueldos/" + id, '_blank');
            win.focus();
        });
    </script>
@endsection
