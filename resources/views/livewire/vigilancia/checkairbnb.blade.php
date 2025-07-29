<div class="container mt-5">
    @section('title')
        Validaciones Airbnb
    @endsection
    <div class="row mb-1">
        <div class="col-1">
            <a href="{{ route('home') }}" class="text-silver"><i class="fas fa-arrow-circle-left fa-2x"></i></a>
        </div>
        <div class="col-10">
            <h4 class="text-secondary text-center">Validaciones Airbnb</h4>
        </div>
        <div class="col-1"></div>
    </div>
    {{-- <h2 class="text-center">Escanear Código QR</h2> --}}
    <div class="row justify-content-center" wire:ignore>
        <div id="reader" style="width: 100%; display: none;"></div>
        <div id="status" class="d-none" style="margin-top: 10px; color: green;"></div>
        <div class="input-group mb-3 mt-3" style="display: none;" id="search">
            <input type="number" class="form-control" placeholder="Cod. Registro" aria-label="Cod. Registro"
                aria-describedby="button-addon2" id="inputSearch" wire:model='search'>
            <button class="btn btn-outline-primary" type="button" id="button-addon2" wire:click='buscarCod'>Buscar</button>
        </div>
        
        <div id="controls" class="d-grid" style="margin-top: 15px;">
            <button id="startScanner" class="btn btn-success" style="height: 70px">Verificar Codigo Qr <i
                    class="fas fa-camera"></i></button>
            <button id="startKeyboard" class="btn btn-info mt-3" style="height: 70px" wire:click="$set('search', '')">Verificar Cod. Registro <i
                    class="fas fa-keyboard"></i></button>
            <button id="reloadPage" class="btn btn-success" style="display: none;height: 50px">Verificar otro Codigo Qr
                <i class="fas fa-camera"></i></button>
            <button id="cancelScanner" class="btn btn-danger" style="display: none;">Cancelar <i
                    class="fas fa-ban"></i></button>
            <button id="cancelScanner2" class="btn btn-danger" style="display: none;" wire:click="resetAll">Cancelar <i
                    class="fas fa-ban"></i></button>
        </div>

        <!-- Mostrar información del registro -->

    </div>
    @if ($airbnbtraveler->id != null)
        <div class="card mt-2">
            <div
                class="card-header @switch($status) @case('CREADO') bg-warning @break @case('ACTIVADO') bg-primary @break @case('FINALIZADO') bg-secondary @break @endswitch text-white">
                Datos del Registro
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <tr style="font-size: 12px">
                        <td><strong>ID Registro:</strong> {{ cerosIzq($airbnbtraveler->id) }}</td>
                        <td><strong>Estado:</strong> {{ $airbnbtraveler->status }}</td>
                    </tr>
                    <tr>
                        <td><strong>Datos Dpto.:</strong></td>
                        <td>{{ $airbnbtraveler->department_info }}</td>
                    </tr>
                    <tr>
                        <td><strong>Ingreso:</strong></td>
                        <td>{{ $airbnbtraveler->arrival_date }}</td>
                    </tr>
                    <tr>
                        <td><strong>Salida:</strong></td>
                        <td>{{ $airbnbtraveler->departure_date }}</td>
                    </tr>
                </table>

            </div>
        </div>

        <div class="card mt-2">
            <div class="card-header bg-secondary text-white">
                Personas registradas
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm" style="font-size: 10px">
                        <thead class="table-secondary">
                            <tr class="align-middle text-center">
                                <th>NOMBRE</th>
                                <th>CEDULA</th>
                                <th>CANT.<br>EQUIP.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="text-center table-info">TITULAR</td>
                            </tr>
                            <tr>
                                <td>{{ $airbnbtraveler->name }}</td>
                                <td class="text-center">{{ $airbnbtraveler->document_number }}</td>
                                <td class="text-center">{{ $airbnbtraveler->luggage_count }}</td>
                            </tr>
                            @if ($airbnbtraveler->airbnbcompanions->count() > 0)
                                <tr>
                                    <td colspan="3" class="text-center table-info">ACOMPAÑANTES</td>
                                </tr>
                                @foreach ($airbnbtraveler->airbnbcompanions as $companion)
                                    <tr>
                                        <td>{{ $companion->name }}</td>
                                        <td class="text-center">{{ $companion->document_number }}</td>
                                        <td class="text-center">{{ $companion->luggage_count }}</td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-grid">
                    <button class="btn text-white" style="font-size: 13px; background-color: lightslategrey"
                        wire:click='exportarPDF'>
                        Descargar información completa <i class="fas fa-file-download"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-2">

            @switch($status)
                @case('CREADO')
                    <div class="col-12 d-grid mb-3">
                        <button class="btn btn-primary" style="height: 50px"
                            onclick="activar({{ $airbnbtraveler->id }})">ACTIVAR
                            <i class="fas fa-power-off"></i></button>
                    </div>
                @break

                @case('ACTIVADO')
                    <div class="col-12 d-grid mb-3">
                        <button class="btn btn-danger" onclick="finalizar({{ $airbnbtraveler->id }})">FINALIZAR <i
                                class="fas fa-power-off"></i></button>
                    </div>
                    @if ($mensaje != '')
                        <div class="col-12 d-grid mb-3">
                            <button class="btn btn-primary" wire:click='sendWhatsAppLink'>INFORMAR <i
                                    class="fab fa-whatsapp"></i></button>
                        </div>
                        <div class="col-12 d-grid mb-3">
                            <button class="btn btn-success" wire:click='copiarAlPortapapeles'>Copiar Mensaje <i
                                    class="far fa-copy"></i></button>
                        </div>
                    @endif
                @break

                @case('FINALIZADO')
                    <div class="col-12">
                        <div class="alert alert-dark text-center" role="alert">
                            FINALIZADO <i class="fas fa-hourglass-end"></i>
                        </div>
                    </div>
                    @if ($mensaje != '')
                        <div class="col-12 d-grid mb-3">
                            <button class="btn btn-primary" wire:click='sendWhatsAppLink'>INFORMAR <i
                                    class="fab fa-whatsapp"></i></button>
                        </div>
                        <div class="col-12 d-grid mb-3">
                            <button class="btn btn-success" wire:click='copiarAlPortapapeles'>Copiar Mensaje <i
                                    class="far fa-copy"></i></button>
                        </div>
                    @endif
                @break
            @endswitch

        </div>

    @endif
    <div class="d-grid mt-3" wire:ignore>
        <a href="{{ route('vigilancia.ctrlairbnb') }}" id="ctrlbutton" class="btn btn-warning"
            style="height: 70px; align-content:center;">Control de Registros <i class="fas fa-clock"></i></a>
    </div>


</div>
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };

            // Elementos HTML
            const readerDiv = document.getElementById("reader");
            const statusDiv = document.getElementById("status");
            const search = document.getElementById("search");
            const startButton = document.getElementById("startScanner");
            const keyButton = document.getElementById("startKeyboard");
            const reloadButton = document.getElementById("reloadPage");
            const cancelButton = document.getElementById("cancelScanner");
            const cancelButton2 = document.getElementById("cancelScanner2");
            const ctrlButton = document.getElementById("ctrlbutton");

            // Variable de control para el estado del escaneo
            let isScanning = false;

            // Función para iniciar el lector
            startButton.addEventListener("click", () => {
                isScanning = true; // Permitir escaneo
                startButton.style.display = "none"; // Ocultar botón de inicio
                ctrlButton.style.display = "none"; // Ocultar botón de inicio
                keyButton.style.display = "none"; // Ocultar botón de inicio
                cancelButton.style.display = "inline-block"; // Mostrar botón de cancelar
                readerDiv.style.display = "block"; // Mostrar lector

                html5QrCode.start({
                        facingMode: "environment"
                    }, // Cámara trasera
                    config,
                    qrCodeMessage => {
                        if (isScanning) {
                            isScanning = false; // Detener escaneo
                            statusDiv.innerText = `Código QR leído: ${qrCodeMessage}`;

                            // Llamar a Livewire
                            @this.buscarRegistro(qrCodeMessage)
                                .then(() => {
                                    detenerScanner(); // Detener el lector
                                    mostrarBotonRecarga(); // Mostrar botón de recarga
                                })
                                .catch(err => {
                                    console.error("Error en Livewire:", err);
                                });
                        }
                    },
                    errorMessage => {
                        console.warn("Error al escanear:", errorMessage);
                    }
                ).catch(err => {
                    console.error("No se pudo iniciar el escáner:", err);
                    detenerScanner(); // Restaurar estado en caso de error
                });
            });

            keyButton.addEventListener("click", () => {
                startButton.style.display = "none"; // Ocultar botón de inicio
                keyButton.style.display = "none"; // Ocultar botón de keyboard
                ctrlButton.style.display = "none"; // Ocultar botón de control
                cancelButton2.style.display = "inline-block"; // Mostrar botón de cancelar
                search.style.display = ""; // Mostrar div search
                document.getElementById('inputSearch').focus();
            });

            // Función para detener el lector
            function detenerScanner() {
                html5QrCode.stop().then(() => {
                    console.log("Escáner detenido correctamente.");
                    readerDiv.style.display = "none"; // Ocultar lector
                    cancelButton.style.display = "none"; // Ocultar botón de cancelar
                }).catch(err => {
                    // console.error("Error al detener el escáner:", err);
                });
            }

            // Mostrar botón de recarga
            function mostrarBotonRecarga() {
                reloadButton.style.display = "inline-block"; // Mostrar botón de recarga
                startButton.style.display = "none"; // Ocultar botón de iniciar cámara
            }

            // Evento del botón "Cancelar"
            cancelButton.addEventListener("click", () => {
                location.reload(); // Recargar la página
                
            });
            cancelButton2.addEventListener("click", () => {
                location.reload(); // Recargar la página
               

            });

            // Evento del botón "Recargar Página"
            reloadButton.addEventListener("click", () => {
                location.reload(); // Recargar la página
            });
        });
    </script>
    <script>
        function activar(id) {
            Swal.fire({
                title: "ACTIVAR RESERVA",
                text: "Está seguro de realizar esta operación?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, actívalo",
                cancelButtonText: "No, cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('activar', id);
                }
            });
        }

        function finalizar(id) {
            Swal.fire({
                title: "FINALIZAR VISITA",
                text: "Está seguro de realizar esta operación?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, finalizar",
                cancelButtonText: "No, cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('finalizar', id);
                }
            });
        }
    </script>
    <script>
        Livewire.on('success', msg => {
            Swal.fire({
                title: "Excelente!",
                text: msg,
                icon: "success"
            });
        });
        Livewire.on('error', msg => {
            Swal.fire({
                title: "Error",
                text: msg,
                icon: "error"
            });
        });

        Livewire.on('copiarTexto', texto => {
            // Usar la API del portapapeles para copiar el texto
            navigator.clipboard.writeText(texto).then(() => {
                console.log('Texto copiado al portapapeles:', texto);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Texto copiado al portapapeles',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }).catch(err => {
                console.error('Error al copiar el texto:', err);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error al copiar el texto',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        });

        Livewire.on("open-whatsapp", event => {
            // console.log(event.url);

            window.open(event.url, '_blank');
        });
    </script>
@endsection
