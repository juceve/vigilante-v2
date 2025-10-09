<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kardex</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bs3/bootstrap.min.css') }}">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #23272f;
            background: #fff;
            margin: 0;
        }

        .contenido {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            min-height: 75%;
            background: rgba(255, 255, 255, 0.8);
            z-index: -1;
        }

        .document-footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            font-size: 10px;
            color: #555;
            text-align: center;
            border-top: 1px solid #aaa;
            padding-top: 5px;
        }
    </style>


</head>

<body>

    <div class="contenido">

        <div class="row" style="width: 100%;margin-right: 3rem; margin-left: 10px;">
            <div class="col-xs-5">
                <br>
                <small>
                    <strong>
                        {{ strtoupper(config('app.name')) }} <br>
                        Seguridad Privada y Vigilancia <br>

                        SANTA CRUZ - BOLIVIA
                    </strong>
                </small>
            </div>

            <div class="col-xs-3 text-right">

            </div>
            <div class="col-xs-4 text-center">
                <img class="img-responsive" src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                    style="width: 60px; margin-top: 1rem">
            </div>
        </div>

        <h4 class="text-center text-primary " style="margin-left: 22px;">
            <div class="alert alert-info" role="alert">FICHA DE EMPLEADO</div>
        </h4>

        <div class="panel panel-primary" style="font-size: 14px; margin-top: 10px; margin-left: 22px;">
            <div class="panel-heading text-center">
                <h3 class="panel-title">INFORMACIÓN PERSONAL</h3>
            </div>
            <div class="panel-body">
                <div style="font-size:0;">
                    <div class="text-center"
                        style="display:inline-block; width:20%; vertical-align:top; font-size:13px; ">
                        @if ($empleado->imgperfil)
                            <img src="{{ Storage::url($empleado->imgperfil) }}" class="img-responsive"
                                style="max-width:110px; max-height:110px;border:1px solid #337ab7; border-radius:8px; padding: 1rem; object-fit:cover;">
                        @else
                            <img src="{{ asset('images/no-perfil2.jpg') }}" class="img-responsive"
                                style="width: 110px;border:1px solid #337ab7; border-radius:8px; padding: 1rem">
                        @endif
                    </div>
                    <div
                        style="display:inline-block; width:77%; margin-left: 15px; vertical-align:top; font-size:12px;">
                        <div class="row">
                            <div class="col-xs-6">

                                <p>
                                    <strong>Nombres: </strong> {{ $empleado->nombres }}
                                </p>
                                <p>
                                    <strong>Nro. Doc.: </strong> {{ $empleado->cedula }}
                                </p>
                                <p>
                                    <strong>Fecha Nacimiento: </strong> {{ formatearFecha($empleado->fecnacimiento) }}
                                </p>
                                <p>
                                    <strong>Dirección: </strong> {{ $empleado->direccion }}
                                </p>
                                <p>
                                    <strong>Email: </strong> {{ $empleado->email }}
                                </p>
                            </div>
                            <div class="col-xs-6">
                                <p>
                                    <strong>Apellidos: </strong> {{ $empleado->apellidos }}
                                </p>
                                <p>
                                    <strong>Tipo Doc.: </strong> {{ $empleado->tipodocumento->name }}
                                </p>
                                <p>
                                    <strong>Nacionalidad: </strong> {{ $empleado->nacionalidad }}
                                </p>
                                <p>
                                    <strong>Teléfono: </strong> {{ $empleado->telefono }}
                                </p>
                                <p>
                                    <strong>Usuario Sistema: </strong>
                                    {{ $empleado->user_id ? 'Generado' : 'No generado' }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="panel panel-primary" style="font-size: 12px; margin-top: 10px; margin-left: 22px;">
            <div class="panel-heading text-center">
                <h3 class="panel-title">INFORMACIÓN LABORAL</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">

                        <p>
                            <strong>Area: </strong> {{ $empleado->area->nombre }}
                        </p>
                        @if ($contrato)
                            <p>
                                <strong>Inicio: </strong> {{ formatearFecha($contrato->fecha_inicio) }}
                            </p>
                            <p>
                                <strong>Tipo Contrato: </strong> {{ $contrato->rrhhtipocontrato->nombre }}
                            </p>
                            <p>
                                <strong>Salario: </strong> {{ $contrato->salario_basico }}
                            </p>
                            <p>
                                <strong>Gestora: </strong> {{ number_format($contrato->gestora, 2, '.') }}
                            </p>
                        @endif
                    </div>
                    <div class="col-xs-6">
                        <p>
                            <strong>Nro. Contrato.: </strong> {{ $contrato ? cerosIzq($contrato->id) : 'Sin definir' }}
                        </p>
                        @if ($contrato)
                            <p>
                                <strong>Final: </strong>
                                {{ $contrato->fecha_fin ? formatearFecha($contrato->fecha_fin) : 'Indefinido' }}
                            </p>
                            <p>
                                <strong>Cargo: </strong> {{ $contrato->rrhhcargo->nombre }}
                            </p>
                            <p>
                                <strong>Moneda: </strong> {{ $contrato->moneda }}
                            </p>
                            <p>
                                <strong>Caja/Seguro: </strong> {{ $contrato->caja_seguro ? 'SI' : 'NO' }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="panel panel-primary" style="font-size: 12px; margin-top: 10px; margin-left: 22px;">
            <div class="panel-heading text-center">
                <h3 class="panel-title">DATOS DE REFERENCIA Y MÉDICOS</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">

                        <p>
                            <strong>Persona de Referecia: </strong> {{ $empleado->persona_referencia ?? '-' }}
                        </p>
                        <p>
                            <strong>Parentezco: </strong> {{ $empleado->parentezco_referencia ?? '-' }}
                        </p>
                    </div>
                    <div class="col-xs-6">
                        <p>
                            <strong>Telf. Referencia: </strong> {{ $empleado->telefono_referencia ?? '-' }}
                        </p>

                    </div>
                </div>
                <div class="alert alert-warning" role="alert">
                    <div class="row">
                        <div class="col-xs-6">

                            <p>
                                <strong>Padece Enfermedad: </strong><br>{{ $empleado->enfermedades ?? 'N/A' }}
                            </p>

                        </div>
                        <div class="col-xs-6">
                            <p>
                                <strong>Padece Alergias: </strong><br>{{ $empleado->alergias ?? 'N/A' }}
                            </p>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <div class="document-footer">
        Documento confidencial - {{ config('app.name', 'Sistema de Gestión') }}<br>
        Impreso el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
    </div>

    <script src="{{ asset('vendor/bs3/bootstrap.min.js') }}"></script>
</body>

</html>
