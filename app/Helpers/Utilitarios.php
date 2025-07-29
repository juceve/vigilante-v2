<?php

use App\Http\Livewire\Vigilancia\HombreVivo;
use App\Models\Asistencia;
use App\Models\Citecobro;
use App\Models\Citecotizacion;
use App\Models\Citeinforme;
use App\Models\Citememorandum;
use App\Models\Citerecibo;
use App\Models\ConversionNumeros;
use App\Models\Designaciondia;
use App\Models\Designacione;
use App\Models\Dialibre;
use App\Models\Hombrevivo as ModelsHombrevivo;
use App\Models\Intervalo;
use App\Models\Marcacione;
use App\Models\Regronda;
use App\Models\Tarea;
use App\Models\Usercliente;
use App\Models\Vwnovedade;
use App\Models\Vwpanico;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

function tablaRondas($designacione_id)
{
    $designacione = Designacione::find($designacione_id);
    $diaslaborables = Designaciondia::where('designacione_id', $designacione_id)
        ->select('lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo')
        ->first();
    $diaslaborables = $diaslaborables->toArray();
    $ctrlpuntos = $designacione->turno->ctrlpuntos;
    $diasL = array(
        "",
        $diaslaborables['lunes'],
        $diaslaborables['martes'],
        $diaslaborables['miercoles'],
        $diaslaborables['jueves'],
        $diaslaborables['viernes'],
        $diaslaborables['sabado'],
        $diaslaborables['domingo']
    );
    $rondas = [];
    $actual = new DateTime($designacione->fechaInicio);
    $final = new DateTime($designacione->fechaFin);

    while ($actual <= $final) {
        $numeral = date('N', strtotime($actual->format('Y-m-d')));
        if ($diasL[$numeral]) {
            $fecha = $actual->format('Y-m-d');
            if (!esDiaLibre2($designacione_id, $fecha)) {
                $rondaA = [];
                $rondaA[] = array($fecha, 0);
                foreach ($ctrlpuntos as $punto) {
                    $ronda = Regronda::where([
                        ['designacione_id', $designacione_id],
                        ['fecha', $fecha],
                        ['ctrlpunto_id', $punto->id]
                    ])->first();

                    if ($ronda) {
                        if (hayRetraso($ronda->hora, $punto->hora)) {
                            $rondaA[] = array($ronda->hora, 2, $ronda->id);
                        } else {
                            $rondaA[] = array($ronda->hora, 0, $ronda->id);
                        }
                    } else {
                        if ($fecha <= date('Y-m-d')) {
                            $rondaA[] = array('X', 1, "");
                        } else {
                            $rondaA[] = array('--', 0, "");
                        }
                    }
                }
                $rondas[] = $rondaA;
            }
        }
        $actual->modify('+1 day');
    }
    return $rondas;
}

function tablaMarcaciones($designacione_id)
{
    $designacione = Designacione::find($designacione_id);
    $diaslaborables = Designaciondia::where('designacione_id', $designacione_id)
        ->select('lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo')
        ->first();
    $diaslaborables = $diaslaborables->toArray();
    $horainicio = $designacione->turno->horainicio;
    $horafin = $designacione->turno->horafin;


    $diasL = array(
        "",
        $diaslaborables['lunes'],
        $diaslaborables['martes'],
        $diaslaborables['miercoles'],
        $diaslaborables['jueves'],
        $diaslaborables['viernes'],
        $diaslaborables['sabado'],
        $diaslaborables['domingo']
    );
    $marcaciones = [];
    $actual = new DateTime($designacione->fechaInicio);
    $final = new DateTime($designacione->fechaFin);

    while ($actual <= $final) {
        $numeral = date('N', strtotime($actual->format('Y-m-d')));
        // dd($diasL[$numeral]);
        if ($diasL[$numeral]) {
            $fecha = $actual->format('Y-m-d');
            if (!esDiaLibre2($designacione_id, $fecha)) {
                $marcado = [];
                $marcadoA = array($fecha, 0, 0, 0, 0);
                $marcacionDia = Marcacione::where([
                    ['fecha', $fecha],
                    ['designacione_id', $designacione_id]
                ])->get()->toArray();
                if (count($marcacionDia) > 0) {
                    $marcadoA[1] = $marcacionDia[0]['hora'];
                    $marcadoA[3] = $marcacionDia[0]['id'];
                    if (count($marcacionDia) > 1) {
                        $marcadoA[2] = $marcacionDia[1]['hora'];
                        $marcadoA[4] = $marcacionDia[1]['id'];
                    }
                } else {
                    $marcadoA[1] = 1;
                    $marcadoA[2] = 1;
                }
                $marcaciones[] = $marcadoA;
            }
        }

        $actual->modify('+1 day');
    }

    return $marcaciones;
}

function hayRetraso($hora_marcado, $hora_programada)
{
    $horaInicio = $hora_programada;
    $horaLlegada = $hora_marcado;

    $inicio = new DateTime($horaInicio);
    $llegada = new DateTime($horaLlegada);
    // $inicio->modify('-5 minutes');
    $interval = $inicio->diff($llegada);
    $retrasoMinutos = $interval->format('%i');

    if ($llegada > $inicio) {
        return true;
    } else {
        return false;
    }
}

function esDiaLibre($designacione_id)
{
    $dia = Dialibre::where([
        ['fecha', date('Y-m-d')],
        ['designacione_id', $designacione_id]
    ])->get();
    if ($dia->count() > 0) {
        return true;
    } else {
        return false;
    }
}


function esDiaLibre2($designacione_id, $fecha)
{
    $dia = Dialibre::where([
        ['fecha', $fecha],
        ['designacione_id', $designacione_id]
    ])->get();
    if ($dia->count() > 0) {
        return true;
    } else {
        return false;
    }
}

function traeDesignacionActiva($empleado_id){
    $designacione = Designacione::where('empleado_id',$empleado_id)
    ->where('estado',1)
    ->orderBy('id','DESC')->first();
    dd($designacione);
}

function yaMarque($designacione_id)
{
    $designacione = Designacione::find($designacione_id);
    $hoy = date('Y-m-d');
    $horaingreso = new DateTime($hoy . " " . $designacione->turno->horainicio);
    $horaingreso = $horaingreso->modify('-1 hours');
    $horaingreso = $horaingreso->format('H:i');
    $horaactual = date('H:i');

    if ($designacione->turno->horainicio < $designacione->turno->horafin) {
        // DIURNO
        $marcacion = Asistencia::where([
            ['designacione_id', $designacione_id],
            ['fecha', $hoy],
        ])->first();

        if ($marcacion) {
            if ($marcacion->ingreso && $marcacion->salida) {
                return 2;
            } else {
                return 1;
            }
        } else {
            if ($horaactual >= $horaingreso) {
                return 0;
            } else {
                return 2;
            }
        }
    } else {
        // NOCTURNO
        $ayer = new DateTime($hoy);
        $ayer = $ayer->modify('-1 days');
        $ayer = $ayer->format('Y-m-d');

        $marcacion = [];
        if ($horaactual > $horaingreso) {
            $marcacion = Asistencia::where('designacione_id', $designacione_id)
                ->where('fecha', $hoy)
                ->first();
        } else {
            $marcacion = Asistencia::where('designacione_id', $designacione_id)
                ->where('fecha', $ayer)
                ->first();
        }
        if ($marcacion) {
            if ($marcacion->ingreso && $marcacion->salida) {
                return 2;
            } else {
                return 1; //MARCO INGRESO
            }
        } else {
            if ($horaactual >= $horaingreso) {
                return 0; //NO MARCO INGRESO
            } else {
                return 2; //MARCO INGRESO Y SALIDA
            }
        }
    }
}

function tengoPanicos($user_id, $cliente_id)
{
    $hoy = date('Y-m-d');
    $panicos = Vwpanico::where([
        ['cliente_id', $cliente_id],
        ['user_id', $user_id],
        ['fecha', $hoy],
        ['visto', 0],
    ])->get();

    return $panicos->count();
}

function crearIntervalo($horaI, $horaF, $intervalo)
{
    $inicio = date('Y-m-d ') . $horaI;
    $final = date('Y-m-d ') . $horaF;
    $inicio = new DateTime($inicio);
    $final = new DateTime($final);
    $int = "+" . $intervalo . " hour";
    $intervalo = array();
    while ($inicio <= $final) {
        $inicio->modify($int);
        if ($inicio < $final) {
            $intervalo[] = $inicio->format('H:i');
        }
    }

    return $intervalo;
}

function verificaHV($designacione_id)
{
    $designacione = Designacione::find($designacione_id);
    $hora = date('H:') . '00';
    $intervalo = Intervalo::where([
        ['designacione_id', $designacione->id],
        ['hora', $hora],
    ])->first();
    if ($intervalo) {
        $marcado = ModelsHombrevivo::where([
            ['intervalo_id', $intervalo->id],
            ['fecha', date('Y-m-d')]
        ])->first();
        if ($marcado) {
            return false;
        } else {
            return $intervalo;
        }
    } else {
        return false;
    }
}

function verificaTareas($designacione_id)
{
    $designacione = Designacione::find($designacione_id);
    $tareas = Tarea::where([
        ["cliente_id", $designacione->turno->cliente_id],
        ["empleado_id", $designacione->empleado_id],
        ["fecha", date('Y-m-d')],
        ["estado", 1],
    ])->get();
    if ($tareas->count() > 0) {
        return true;
    } else {
        return false;
    }
}

function registrosHV($designacione_id)
{
    $designacione = Designacione::find($designacione_id);
    $diaslaborables = Designaciondia::where('designacione_id', $designacione_id)
        ->select('lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo')
        ->first();
    $diaslaborables = $diaslaborables->toArray();
    $intervalos = $designacione->intervalos;
    $diasL = array(
        "",
        $diaslaborables['lunes'],
        $diaslaborables['martes'],
        $diaslaborables['miercoles'],
        $diaslaborables['jueves'],
        $diaslaborables['viernes'],
        $diaslaborables['sabado'],
        $diaslaborables['domingo']
    );
    $rondas = [];
    $actual = new DateTime($designacione->fechaInicio);
    $final = new DateTime($designacione->fechaFin);

    while ($actual <= $final) {
        $numeral = date('N', strtotime($actual->format('Y-m-d')));
        if ($diasL[$numeral]) {
            $fecha = $actual->format('Y-m-d');
            if (!esDiaLibre2($designacione_id, $fecha)) {
                $rondaA = [];
                $rondaA[] = array($fecha, 0);
                foreach ($intervalos as $intervalo) {
                    $hv = ModelsHombrevivo::where([
                        ['intervalo_id', $intervalo->id],
                        ['fecha', $fecha]
                    ])->first();

                    if ($hv) {

                        $rondaA[] = array($hv->hora, 0, $hv->id);
                    } else {
                        if ($fecha <= date('Y-m-d')) {
                            $rondaA[] = array('X', 1, "");
                        } else {
                            $rondaA[] = array('--', 2, "");
                        }
                    }
                }
                $rondas[] = $rondaA;
            }
        }
        $actual->modify('+1 day');
    }
    return $rondas;
}

function fechaEs($fecha)
{
    setlocale(LC_TIME, 'es_VE.UTF-8', 'esp');
    $date = strtotime($fecha);
    $fecha = strftime('%e de %B de %Y', $date);

    return $fecha;
}

function ultDiaMes($fecha)
{
    $L = new DateTime($fecha);
    $literal = $L->format('Y-m-t');
    $literal = strtotime($literal);
    setlocale(LC_TIME, 'es_VE.UTF-8', 'esp');
    $literal = strftime('%e de %B de %Y', $literal);

    return $literal;
}

function traeCiteInforme($cite_id)
{
    $citeinforme = Citeinforme::find($cite_id);
    if (Auth::user()->template == "CLIENTE") {
        $usuariocliente = Usercliente::where('user_id', Auth::user()->id)->first();
        if ($citeinforme->cliente_id == $usuariocliente->cliente_id) {
            return $citeinforme->toArray();
        } else {
            return "";
        }
    } else {
        return $citeinforme->toArray();
    }
}
function traecitememo($cite_id)
{
    $citememo = Citememorandum::find($cite_id);

    return $citememo->toArray();
}

function traeCitecobro($cobro_id)
{
    $citecobro = Citecobro::find($cobro_id);
    if (Auth::user()->template == "CLIENTE") {
        $usuariocliente = Usercliente::where('user_id', Auth::user()->id)->first();
        if ($citecobro->cliente_id == $usuariocliente->cliente_id) {
            return $citecobro->toArray();
        } else {
            return "";
        }
    } else {
        return $citecobro->toArray();
    }
}
function traeCiterecibo($recibo_id)
{
    $citerecibo = Citerecibo::find($recibo_id);
    if (Auth::user()->template == "CLIENTE") {
        $usuariocliente = Usercliente::where('user_id', Auth::user()->id)->first();
        if ($citerecibo->cliente_id == $usuariocliente->cliente_id) {
            return $citerecibo->toArray();
        } else {
            return "";
        }
    } else {
        return $citerecibo->toArray();
    }
}
function traeCitecotizacion($cotizacion_id)
{
    $citecotizacion = Citecotizacion::find($cotizacion_id);

    return $citecotizacion->toArray();
}

function traeDetallesCotizacion($cotizacion_id)
{
    $citecotizacion = Citecotizacion::find($cotizacion_id);

    return $citecotizacion->detalles->toArray();
}

function numLiteral($monto)
{
    $conversiones = new ConversionNumeros();
    $literal = $conversiones->toInvoice($monto, 2, 'bolivianos');

    return $literal;
}

function codGet($myString)
{
    $myString = str_replace("/", "^&10&^", $myString);
    return $myString;
}
function decodGet($myString)
{
    $myString = str_replace("^&10&^", "/", $myString);
    return $myString;
}

function cerosIzq($num)
{
    $num = str_pad($num, 5, '0', STR_PAD_LEFT);
    return $num;
}

function verifAirbnb($fechaFutura)
{
    // Obtener la fecha y hora actual
    $ahora = Carbon::now();

    // Calcular la diferencia entre la fecha actual y la fecha futura
    $diferencia = $ahora->diff($fechaFutura);

    // Convertir la diferencia en horas
    $diferenciaEnHoras = ($diferencia->days * 24) + $diferencia->h + ($diferencia->i / 60);

    // Si la fecha futura ya pasó, marcar como 'danger'
    if ($fechaFutura <= $ahora) {
        return 'danger text-danger';  // Si la fecha futura ya ha pasado
    } elseif ($diferenciaEnHoras <= 1) {
        return 'danger';  // Menos de 1 hora
    } elseif ($diferenciaEnHoras <= 24) {
        return 'warning';  // Mayor a 1 hora y menor o igual a 1 día
    } else {
        return 'success';  // Mayor a 1 día
    }
}

function diffDays($fecha1)
{
    $fecha1 = Carbon::parse($fecha1);
    $fecha2 = Carbon::parse(now());
    $dias = $fecha1->diffInDays($fecha2);
    return $dias;
}
function diffHours($fecha1)
{
    $fecha1 = Carbon::parse($fecha1);
    $fecha2 = Carbon::parse(now());
    $horas = $fecha1->diffInHours($fecha2);
    return $horas;
}
function diffMinutes($fecha1)
{
    $fecha1 = Carbon::parse($fecha1);
    $fecha2 = Carbon::parse(now());
    $minutos = $fecha1->diffInMinutes($fecha2);
    return $minutos;
}
