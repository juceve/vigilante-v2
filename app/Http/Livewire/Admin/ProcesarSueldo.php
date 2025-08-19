<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rrhhcontrato;
use App\Models\Empleado;
use App\Models\Rrhhsueldo;
use App\Models\Rrhhadelanto;
use App\Models\Rrhhbono;
use App\Models\Rrhhasistencia;
use App\Models\Rrhhestado;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Rrhhsueldoempleado;
use App\Models\Rrhhpermiso;
use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de tener este use
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class ProcesarSueldo extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $contratosVigentes = null, $alertasSolapamiento;
    public $rrhhsueldo;
    public $searchEmpleado = '';
    public $procesado = false;
    public $calcularHastaHoy = false;
    public $perPage = 7;
    public $procesando = false;

    protected $listeners = ['finalizarProceso'];

    public function mount($rrhhsueldo_id)
    {
        $this->rrhhsueldo = Rrhhsueldo::findOrFail($rrhhsueldo_id);

        $gestion = $this->rrhhsueldo->gestion;
        $mes = $this->rrhhsueldo->mes;

        $inicioMes = Carbon::create($gestion, $mes, 1)->startOfDay();
        $finMes = Carbon::create($gestion, $mes, 1)->endOfMonth()->endOfDay();

        // Trae todos los contratos que caen en el mes, sin importar si están activos
        $contratosEnMes = RrhhContrato::with(['empleado', 'rrhhtipocontrato', 'rrhhcargo'])
            ->whereDate('fecha_inicio', '<=', $finMes)
            ->where(function ($q) use ($inicioMes) {
                $q->whereNull('fecha_fin')
                    ->orWhereDate('fecha_fin', '>=', $inicioMes);
            })
            ->get();

        // Detecta solapamientos reales
        $alertasSolapamiento = collect();
        $contratosPorEmpleado = $contratosEnMes->groupBy('empleado_id');
        foreach ($contratosPorEmpleado as $empleado_id => $contratos) {
            $contratos = $contratos->sortBy('fecha_inicio')->values();
            for ($i = 0; $i < $contratos->count() - 1; $i++) {
                $a = $contratos[$i];
                $b = $contratos[$i + 1];
                $a_fin = $a->fecha_fin ? Carbon::parse($a->fecha_fin) : $finMes;
                $b_ini = Carbon::parse($b->fecha_inicio);
                if ($a_fin >= $b_ini) {
                    $alertasSolapamiento->push($empleado_id);
                    break;
                }
            }
        }
        if ($alertasSolapamiento->count() > 0) {
            $this->alertasSolapamiento = Empleado::whereIn('id', $alertasSolapamiento)->get();
        }

        // Procesa todos los contratos cumplidos
        $this->contratosVigentes = $contratosEnMes->map(function ($contrato) {
            $fechaInicio = $contrato->fecha_inicio instanceof Carbon
                ? $contrato->fecha_inicio
                : Carbon::parse($contrato->fecha_inicio);

            $gestionContrato = $fechaInicio->year;
            $mesContrato = $fechaInicio->month;

            if (
                $gestionContrato == $this->rrhhsueldo->gestion &&
                $mesContrato == $this->rrhhsueldo->mes
            ) {
                $contrato->inicio_mes = ($fechaInicio->day == 1)
                    ? 'MES COMPLETO'
                    : 'INICIO PARCIAL';
            } else {
                $contrato->inicio_mes = 'MES COMPLETO';
            }
            // Inicializa totales en 0
            $contrato->total_adelantos = 0;
            $contrato->total_bonos = 0;
            $contrato->total_ctrl_asist = 0;
            $contrato->total_liquido_pagable = $contrato->salario_basico;
            return $contrato;
        });
    }

    public function procesarSueldos()
    {
        // Simula un pequeño retardo para mostrar el loading (opcional)
        usleep(500000); // 0.5 segundos

        $gestion = (int) $this->rrhhsueldo->gestion;
        $mes = (int) $this->rrhhsueldo->mes;
        $diasEnMes = Carbon::create($gestion, $mes, 1)->daysInMonth;

        $fechaInicioMes = Carbon::create($gestion, $mes, 1);
        // Si el checkbox está activo, el cálculo es hasta hoy (pero no más allá del fin de mes)
        $fechaFinMes = $this->calcularHastaHoy
            ? min(Carbon::today(), Carbon::create($gestion, $mes, 1)->endOfMonth())
            : Carbon::create($gestion, $mes, 1)->endOfMonth();

        $this->contratosVigentes = $this->contratosVigentes->map(function ($contrato) use ($gestion, $mes, $diasEnMes, $fechaInicioMes, $fechaFinMes) {
            $cantidadDiasContrato = $contrato->rrhhtipocontrato->cantidad_dias ?? 0;
            $fechaInicioContrato = Carbon::parse($contrato->fecha_inicio);

            $diaInicio = 1;
            if (
                $fechaInicioContrato->year == $gestion &&
                $fechaInicioContrato->month == $mes &&
                $fechaInicioContrato->day > 1
            ) {
                $diaInicio = $fechaInicioContrato->day;
            }

            // Valor del día trabajado (según tipo de contrato)
            $valorDia = $cantidadDiasContrato > 0
                ? $contrato->salario_basico / $cantidadDiasContrato
                : 0;

            // Determina el rango real de días a calcular
            $fechaFinContrato = $contrato->fecha_fin ? Carbon::parse($contrato->fecha_fin) : null;
            $fechaInicioCalculo = $fechaInicioContrato->greaterThan($fechaInicioMes) ? $fechaInicioContrato : $fechaInicioMes;
            $fechaFinCalculo = $fechaFinContrato
                ? ($fechaFinContrato->lessThan($fechaFinMes) ? $fechaFinContrato : $fechaFinMes)
                : $fechaFinMes;

            if ($this->calcularHastaHoy) {
                $fechaFinCalculo = min($fechaFinCalculo, Carbon::today());
            }

            // Cálculo de asistencia y días realmente trabajados
            $diasTrabajadosMes = 0;
            $diferenciaTotal = 0;
            $fechaActual = $fechaInicioCalculo->copy();

            while ($fechaActual->lte($fechaFinCalculo)) {
                $diasTrabajadosMes++;

                $asistencia = Rrhhasistencia::where('empleado_id', $contrato->empleado_id)
                    ->whereDate('fecha', $fechaActual->format('Y-m-d'))
                    ->first();

                if ($asistencia) {
                    $estado = Rrhhestado::find($asistencia->rrhhestado_id);
                    $factor = $estado ? $estado->factor : 1;
                } else {
                    $factor = 1;
                }

                $diferenciaTotal += $valorDia * ($factor - 1);

                $fechaActual->addDay();
            }

            // Salario básico proporcional SIEMPRE por los días realmente trabajados
            $salarioBasicoProporcional = $cantidadDiasContrato > 0
                ? round($contrato->salario_basico * min($diasTrabajadosMes, $cantidadDiasContrato) / $cantidadDiasContrato, 2)
                : 0;

            // Salario ajustado por asistencia y proporcionalidad
            $contrato->salario_asistencia = round(min($salarioBasicoProporcional + $diferenciaTotal, $contrato->salario_basico), 2);
            $contrato->total_ctrl_asist = round(-$diferenciaTotal, 2);

            // Adelantos
            $fechaInicioVigencia = $fechaInicioCalculo->format('Y-m-d');
            $fechaFinVigencia = $fechaFinCalculo->format('Y-m-d');

            $adelantos = Rrhhadelanto::where('empleado_id', $contrato->empleado_id)
                ->whereDate('fecha', '>=', $fechaInicioVigencia)
                ->whereDate('fecha', '<=', $fechaFinVigencia)
                ->sum('monto');

            // Bonos (cantidad * monto)
            $bonos = Rrhhbono::where('empleado_id', $contrato->empleado_id)
                ->whereDate('fecha', '>=', $fechaInicioVigencia)
                ->whereDate('fecha', '<=', $fechaFinVigencia)
                ->get()
                ->sum(function ($bono) {
                    return $bono->cantidad * $bono->monto;
                });

            $contrato->total_adelantos = $adelantos;
            $contrato->total_bonos = $bonos;

            // Líquido pagable
            $contrato->total_liquido_pagable = $contrato->salario_asistencia - $adelantos + $bonos;

            // Rango del mes a analizar
            $inicioMes = Carbon::create($gestion, $mes, 1)->startOfDay();
            $finMes = Carbon::create($gestion, $mes, 1)->endOfMonth()->endOfDay();

            // Trae todos los permisos del empleado que se cruzan con el mes
            $permisos = Rrhhpermiso::where('empleado_id', $contrato->empleado_id)
                ->where(function ($q) use ($inicioMes, $finMes) {
                    $q->whereDate('fecha_inicio', '<=', $finMes)
                        ->whereDate('fecha_fin', '>=', $inicioMes);
                })
                ->get();

            $totalPermisos = 0;
            foreach ($permisos as $permiso) {
                $inicioPermiso = Carbon::parse($permiso->fecha_inicio)->startOfDay();
                $finPermiso = Carbon::parse($permiso->fecha_fin)->endOfDay();

                // Calcula el rango efectivo dentro del mes
                $inicio = $inicioPermiso->greaterThan($inicioMes) ? $inicioPermiso : $inicioMes;
                $fin = $finPermiso->lessThan($finMes) ? $finPermiso : $finMes;

                // Suma los días (incluyendo ambos extremos)
                $dias = $inicio->diffInDays($fin) + 1;
                $totalPermisos += $dias;
            }

            $contrato->total_permisos = $totalPermisos;

            return $contrato;
        });

        $this->procesado = true;
    }



    public function finalizarProceso()
    {
        if (!$this->procesando) {
            $this->procesando = true;

            // Procesa los sueldos antes de guardar
            $this->procesarSueldos();

            DB::beginTransaction();
            try {
                // Elimina registros previos para este sueldo (opcional pero recomendado)
                Rrhhsueldoempleado::where('rrhhsueldo_id', $this->rrhhsueldo->id)->delete();

                $gestion = (int) $this->rrhhsueldo->gestion;
                $mes = (int) $this->rrhhsueldo->mes;

                $sueldos = [];

                foreach ($this->contratosVigentes as $contrato) {
                    // Rango del mes a analizar
                    $inicioMes = Carbon::create($gestion, $mes, 1)->startOfDay();
                    $finMes = Carbon::create($gestion, $mes, 1)->endOfMonth()->endOfDay();

                    // Trae todos los permisos del empleado que se cruzan con el mes
                    $permisos = Rrhhpermiso::where('empleado_id', $contrato->empleado_id)
                        ->where(function ($q) use ($inicioMes, $finMes) {
                            $q->whereDate('fecha_inicio', '<=', $finMes)
                                ->whereDate('fecha_fin', '>=', $inicioMes);
                        })
                        ->get();

                    $totalPermisos = 0;
                    foreach ($permisos as $permiso) {
                        $inicioPermiso = Carbon::parse($permiso->fecha_inicio)->startOfDay();
                        $finPermiso = Carbon::parse($permiso->fecha_fin)->endOfDay();

                        // Calcula el rango efectivo dentro del mes
                        $inicio = $inicioPermiso->greaterThan($inicioMes) ? $inicioPermiso : $inicioMes;
                        $fin = $finPermiso->lessThan($finMes) ? $finPermiso : $finMes;

                        // Suma los días (incluyendo ambos extremos)
                        $dias = $inicio->diffInDays($fin) + 1;
                        $totalPermisos += $dias;
                    }

                    $sueldo = Rrhhsueldoempleado::create([
                        'rrhhsueldo_id'        => $this->rrhhsueldo->id,
                        'empleado_id'          => $contrato->empleado_id,
                        'rrhhcontrato_id'      => $contrato->id,
                        'nombreempleado'       => trim(($contrato->empleado->nombres ?? '') . ' ' . ($contrato->empleado->apellidos ?? '')),
                        'total_permisos'       => $totalPermisos,
                        'total_adelantos'      => $contrato->total_adelantos ? ($contrato->total_adelantos * -1) : 0, // Negativo si resta
                        'total_bonosdescuentos' => $contrato->total_bonos ?? 0,     // Puede ser positivo o negativo
                        'total_ctrlasistencias' => $contrato->total_ctrl_asist ?? 0, // Negativo si descuenta
                        'salario_mes'          => $contrato->salario_asistencia ?? 0,
                        'liquido_pagable'      => $contrato->total_liquido_pagable ?? 0,
                    ]);

                    $sueldos[] = $sueldo->toArray();
                }

                // Cambiar estado del sueldo a PROCESADO y guardar
                $this->rrhhsueldo->estado = 'PROCESADO';
                $this->rrhhsueldo->save();

                DB::commit();

                // Emitir evento para abrir el PDF
                // $this->emit('abrirPdfSueldos', $this->rrhhsueldo->id);

                $this->emit('renderizarpdf', $this->rrhhsueldo->id);



                // Redireccionar (el mensaje ya lo tienes configurado)
                return redirect()->route('admin.sueldos')->with('success', 'Sueldos finalizados y registrados correctamente.');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->emit('error', 'Ha ocurrido un error: ' . $e->getMessage());
            }
        }
    }

    public function getContratosFiltradosProperty()
    {
        $contratos = $this->contratosVigentes;

        if (!empty($this->searchEmpleado)) {
            $busqueda = mb_strtolower($this->searchEmpleado);
            $contratos = $contratos->filter(function ($contrato) use ($busqueda) {
                $nombre = mb_strtolower($contrato->empleado->nombres ?? '');
                $apellidos = mb_strtolower($contrato->empleado->apellidos ?? '');
                return strpos($nombre, $busqueda) !== false || strpos($apellidos, $busqueda) !== false;
            });
        }

        // Convierte a colección paginada manualmente
        $page = $this->page ?? 1;
        $perPage = $this->perPage;
        $items = $contratos->slice(($page - 1) * $perPage, $perPage)->values();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $contratos->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function updatingSearchEmpleado()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.procesar-sueldo', [
            'alertasSolapamiento' => $this->alertasSolapamiento,
            'rrhhsueldo' => $this->rrhhsueldo,
        ])->extends('adminlte::page');
    }
}
