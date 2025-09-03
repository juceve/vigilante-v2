<div>
    @section('title')
        Detalles del Pase
    @endsection

    <!-- Header Corporativo -->
    <div
        style="margin-top: 85px; background: linear-gradient(135deg, #1e3a8a, #1e293b); padding: 1rem 0; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(30, 41, 59, 0.1);">
        <div class="container">
            <div
                style="display: flex; align-items: center; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; padding: 1rem; box-shadow: 0 2px 8px rgba(30, 41, 59, 0.1);">
                <a href="{{ route('vigilancia.controlpases', $designacione_id) }}"
                    style="width: 50px; height: 50px; background: linear-gradient(135deg, #1e3a8a, #1e293b); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 1.2rem; margin-right: 1rem;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div style="flex: 1; text-align: center;">
                    <h1 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0; letter-spacing: 0.5px;">
                        PASE DE ACCESO <br> N°
                        {{ $paseingreso->residencia->cliente->id . '-' . cerosIzq2($paseingreso->id) }}
                    </h1>
                    <p style="font-size: 1.1rem;  margin: 0.2rem 0 0 0; font-weight: 500;">TIPO:
                        {{ $paseingreso->tipopase->nombre }}</p>
                </div>
            </div>
        </div>
    </div>
    <h4 class="text-center text-primary">Información del Pase</h4>
    <div class="table-responsive p-1">
        <table class="table table-bordered table-striped" style="font-size: 13px;">
            <tr>
                <td colspan="2">
                    <strong>Nombre:</strong> {{ $paseingreso->nombre }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Cedula:</strong> {{ $paseingreso->cedula }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Inicia:</strong> {{ $paseingreso->fecha_inicio }}
                </td>

                <td>
                    <strong>Expira:</strong> {{ $paseingreso->fecha_fin }}
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <strong>Detalles:</strong> {{ $paseingreso->detalles ?? 'N/A' }}
                </td>

            </tr>

        </table>
    </div>

    <h4 class="text-center text-blue mt-4">Datos de la Residencia</h4>
    <div class="table-responsive p-1">
        <table class="table table-bordered table-striped" style="font-size: 13px;">
            <tr>
                <td colspan="2">
                    <strong>Propietario:</strong> {{ $paseingreso->residencia->propietario->nombre }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Telefono:</strong> {{ $paseingreso->residencia->propietario->telefono }}
                </td>
                <td>
                    <strong>Ciudad:</strong> {{ $paseingreso->residencia->propietario->ciudad }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Nro. Puerta:</strong> {{ $paseingreso->residencia->numeropuerta ?? '-' }}
                </td>

                <td>
                    <strong>Piso:</strong> {{ $paseingreso->residencia->piso ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Calle:</strong> {{ $paseingreso->residencia->calle ?? '-' }}
                </td>

                <td>
                    <strong>Nro. Lote:</strong> {{ $paseingreso->residencia->nrolote ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Manzano:</strong> {{ $paseingreso->residencia->manzano ?? '-' }}
                </td>

                <td>
                    <strong>Estado:</strong> {{ $paseingreso->residencia->estado }}
                </td>
            </tr>

        </table>
    </div>
    <div class="row text-center px-2 mt-3">
        <div class="col-6 d-grid">
            <button class="btn btn-success" onclick='marcado("INGRESO")'>Marcar Ingreso <br><i
                    class="fas fa-sign-in-alt fs-2"></i></button>
        </div>
        <div class="col-6 d-grid">
            <button class="btn btn-danger" onclick='marcado("SALIDA")'>Marcar Salida <br><i
                    class="fas fa-sign-out-alt fs-2"></i></button>
        </div>
    </div>
    <br>

</div>
@section('js')
    <script>
        function marcado(tipo) {
            Swal.fire({
                title: "Marcar "+tipo,
                text: "¿Seguro de realizar esta operación?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "No, cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('marcar',tipo);
                }
            });
        }
    </script>
@endsection
@section('css')
    <style>
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        .form-control::placeholder {
            color: #94a3b8;
            font-style: italic;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .container {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
        }
    </style>
@endsection
