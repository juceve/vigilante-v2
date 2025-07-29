<style>
    .btn-xs {
        padding: 0.15rem 0.4rem;
        font-size: 0.75rem;
        line-height: 1.2;
        border-radius: 0.15rem;
    }
</style>
<div class="row mb-2">
    <div class="col-12 col-md-9 mb-2">
        <strong>DOTACIONES - Contrato ID:
            {{ $contratoActivo ? cerosIzq($contratoActivo->id) : 'Sin definir' }}</strong>
    </div>
    <div class="col-12 col-md-3 mb-2">
        @if ($contratoActivo)
            <button class="btn btn-info btn-sm btn-block" data-toggle="modal" data-target="#modalDotaciones">
                Nuevo <i class="fas fa-plus"></i>
            </button>
        @endif

    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="tabla-dotaciones" style="width: 100%">
        <thead class="table-info">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Detalle</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>
<!-- Modal -->
<div class="modal fade" id="modalDotaciones" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalDotacionesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDotacionesLabel">Formulario de Dotaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiar3()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Fecha Solicitud</span>
                            </div>
                            <input type="date" class="form-control" id="fecha3" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Detalle</span>
                            </div>
                            <input type="text" step="any" class="form-control" id="detalle3"
                                placeholder="Detalle de la dotacion">
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Cant.</span>
                            </div>
                            <input type="number" id="cantidad3" class="form-control" value="1" placeholder="1">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="rrhhestadodotacion_id">
                                <option value="">Seleccione un tipo</option>
                                @foreach ($estadoDots as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <button class="btn btn-sm btn-success btn-block" onclick="agregarFila()">Agregar</button>
                    </div>
                </div>
                <span>Detalles</span>
                <div class="table-responsive">
                    <table class="table table-striped table-sm" id="tablaDetalles" style="font-size: 12px;">
                        <thead class="table-success">
                            <tr>
                                <th>Detalle</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th style="width: 25px"></th>
                            </tr>
                        </thead>
                        <tbody id="bodyDetalles" style="vertical-align: middle;">
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar3()"><i
                            class="fas fa-ban"></i>
                        Cancelar</button>
                    <button type="button" id="btnEdit3" class="btn btn-warning d-none"
                        onclick="updateDotacion()">Actualizar
                        Dotacion
                        <i class="fas fa-save"></i></button>
                    <button type="button" id="btnRegist3" class="btn btn-info" onclick="registrarDotacion()">Registrar
                        Dotacion <i class="fas fa-save"></i></button>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditDotacion" tabindex="-1"
    aria-labelledby="modalEditDotacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditDotacionLabel">Editar Dotación
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="rrhhdotacion_id">
                <div class="spinner-border text-primary d-none" id="spinner3" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div id="data3">
                    <div class="form-group">
                        <label>Fecha:</label>
                        <input type="date" class="form-control" id="fecha4">
                    </div>
                    <div class="form-group">
                        <label>Detalle:</label>
                        <input type="text" class="form-control" id="detalle4">
                    </div>
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input type="number" class="form-control" id="cantidad4">
                    </div>
                    <div class="form-group">
                        <label>Estado:</label>
                        <select class="form-control" id="rrhhestadodotacion_id4">
                            <option value="">Seleccione un tipo</option>
                            @foreach ($estadoDots as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cerrar</button>
                <button type="button" class="btn btn-warning" onclick="updateDotacion()">Actualizar Dotación <i
                        class="fas fa-save"></i></button>
            </div>
        </div>
    </div>
</div>
@section('js7')
    <script>
        $('.nav-dotaciones').click(function() {
            cargarTablaDotaciones();
        });
    </script>

    <script>
        function limpiar3() {
            const hoy = new Date();

            // Formatea la fecha como YYYY-MM-DD
            const fechaFormateada = hoy.toISOString().split('T')[0];
            // document.getElementById('rrhhadelanto_id').value = '';
            document.getElementById('fecha3').value = fechaFormateada;
            document.getElementById('rrhhestadodotacion_id').value = '';
            document.getElementById('detalle3').value = '';
            document.getElementById('cantidad3').value = '1';
            datos = [];
            renderizarTabla3();

            const btnEdit3 = document.getElementById('btnEdit3');
            const btnRegist3 = document.getElementById('btnRegist3');

            btnEdit3.classList.add('d-none');
            btnRegist3.classList.remove('d-none');
        }

        function editar3(rrhhdotacion_id) {
            const body3 = document.getElementById('data3');
            const spinner3 = document.getElementById('spinner3');

            body3.classList.add('d-none');
            spinner3.classList.remove('d-none');

            const formData = new FormData();
            formData.append('rrhhdotacion_id', rrhhdotacion_id);

            fetch('{{ route('dotaciones.edit') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {

                    document.getElementById('rrhhdotacion_id').value = data.message.id;

                    document.getElementById('fecha4').value = data.message.fecha;
                    document.getElementById('detalle4').value = data.message.detalle;
                    document.getElementById('cantidad4').value = data.message.cantidad;
                    document.getElementById('rrhhestadodotacion_id4').value = data.message.rrhhestadodotacion_id;

                    spinner3.classList.add('d-none');
                    body3.classList.remove('d-none');

                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al enviar la solicitud');
                });
        }
    </script>

    <script>
        // Array para guardar los datos
        let datos = [];

        function agregarFila() {
            const detalle = document.getElementById("detalle3").value.trim();
            const cantidad = document.getElementById("cantidad3").value.trim();
            const selectEstado = document.getElementById("rrhhestadodotacion_id");
            const estado = selectEstado.value;
            const estadoTexto = selectEstado.options[selectEstado.selectedIndex].text;
            // Validación básica
            if (!detalle || !cantidad || !estado) {
                alert("Por favor complete todos los campos.");
                return;
            }

            // Guardar en el array
            datos.push({
                detalle: detalle,
                cantidad: parseInt(cantidad),
                estado: estado,
                estadoTexto: estadoTexto
            });

            // Limpiar campos del formulario
            document.getElementById("detalle3").value = "";
            document.getElementById("cantidad3").value = "1";
            document.getElementById("rrhhestadodotacion_id").value = "";

            // Actualizar tabla
            renderizarTabla3();
        }

        function eliminarFila(index) {
            // Remover del array
            datos.splice(index, 1);
            renderizarTabla3();
        }

        function renderizarTabla3() {
            const tabla = document.getElementById("tablaDetalles");
            const tbody = document.getElementById("bodyDetalles");

            // Mostrar u ocultar la tabla
            if (datos.length === 0) {
                tabla.style.display = "none";
                return;
            }

            tabla.style.display = "table";
            tbody.innerHTML = ""; // Limpiar tabla antes de volver a llenarla

            datos.forEach((item, index) => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                
                <td>${item.detalle}</td>
                <td>${item.cantidad}</td>
                <td>${item.estadoTexto}</td>
                <td class="text-right"><button class="btn btn-xs btn-outline-danger"  style="font-size=12px;" onclick="eliminarFila(${index})" title="Quitar"><i class="fas fa-trash"></i></button></td>
            `;
                tbody.appendChild(fila);
            });
        }
    </script>

    <script>
        let tablaDotaciones;

        function cargarTablaDotaciones() {
            if (tablaDotaciones) {
                tablaDotaciones.ajax.reload(null, false); // recarga sin resetear paginación
                return;
            }


            tablaDotaciones = $('#tabla-dotaciones').DataTable({
                ajax: '{{ route('dotaciones.data', $contratoActivo ? $contratoActivo->id : 0) }}',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'fecha'
                    },
                    {
                        data: 'detalle'
                    },
                    {
                        data: 'cantidad'
                    },
                    {
                        data: 'rrhhestadodotacion'
                    },

                    {
                        data: 'boton',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        targets: [0, 1, 3, 4],
                        className: 'text-center'
                    },
                    // {
                    //     targets: [3],
                    //     className: 'text-right'
                    // },
                ],
                responsive: true,
                order: [
                    [0, 'desc']
                ],
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Todos"]
                ],
                language: {
                    url: '{{ asset('plugins/es-ES.json') }}'
                }
            });

            setTimeout(() => {
                tablaDotaciones.columns.adjust().draw();
            }, 300);
        }
    </script>
    <script>
        function updateDotacion() {
            const formDataU = new FormData();
            // Añadir campos
            formDataU.append('rrhhdotacion_id', $('#rrhhdotacion_id').val());
            formDataU.append('fecha', $('#fecha4').val());
            formDataU.append('detalle', $('#detalle4').val());
            formDataU.append('cantidad', $('#cantidad4').val());
            formDataU.append('rrhhestadodotacion_id', $('#rrhhestadodotacion_id4').val());


            fetch('{{ route('dotaciones.update') }}', {
                    method: 'POST',
                    body: formDataU,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    cargarTablaDotaciones();
                    $('#modalEditDotacion').modal('hide')
                    
                    if (data.success) {
                        Swal.fire({
                            title: 'Excelente',
                            text: 'Dotacion actualizado correctamente.',
                            icon: 'success'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error.',
                            icon: 'error'
                        });
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al enviar el bono');
                });
        }

        function registrarDotacion() {

            const formData = new FormData();


            // Añadir campos

            formData.append('fecha', $('#fecha3').val());
            formData.append('detalles', JSON.stringify(datos));
            formData.append('rrhhcontrato_id', {{ $contratoActivo?->id }});
            formData.append('empleado_id', {{ $contratoActivo?->empleado->id }});

            fetch('{{ route('dotaciones.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    cargarTablaDotaciones();

                    $('#modalDotaciones').modal('hide')
                    limpiar3();
                    if (data.success) {
                        Swal.fire({
                            title: 'Excelente',
                            text: 'Dotación registrado correctamente.',
                            icon: 'success'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error.',
                            icon: 'error'
                        });
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al enviar la dotación');
                });
        }
    </script>
@endsection
