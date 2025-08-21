<?php

namespace App\Http\Livewire\Admin;

use App\Models\Rrhhcontrato;
use Livewire\Component;
use App\Models\Rrhhsueldo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProcesarSueldo extends Component
{
    public $rrhhsueldo;
    public function mount($rrhhsueldo_id)
    {
        $this->rrhhsueldo = Rrhhsueldo::find($rrhhsueldo_id);
    }

    public function render()
    {
        $contratos = $this->getContratosVigentes();
        return view('livewire.admin.procesar-sueldo', compact('contratos'))->extends('adminlte::page');
    }

    public function getContratosVigentes()
    {
        $anio = $this->rrhhsueldo->gestion;
        $mes = $this->rrhhsueldo->mes;

        // Primer y último día del mes a evaluar
        $fechaInicioMes = now()->setDate($anio, $mes, 1)->startOfDay();
        $fechaFinMes = now()->setDate($anio, $mes, 1)->endOfMonth()->endOfDay();

        $contratos = Rrhhcontrato::with('rrhhtipocontrato')
            ->where(function ($q) use ($fechaInicioMes, $fechaFinMes) {
                $q->whereNull('fecha_fin')
                    ->orWhereBetween('fecha_fin', [$fechaInicioMes, $fechaFinMes])
                    ->orWhere('fecha_fin', '>=', $fechaInicioMes);
            })
            ->where('fecha_inicio', '<=', $fechaFinMes)
            ->get()
            ->map(function ($contrato) use ($fechaInicioMes, $fechaFinMes) {
                // Mes completo
                $contrato->mes_completo = $contrato->fecha_inicio <= $fechaInicioMes
                    && (is_null($contrato->fecha_fin) || $contrato->fecha_fin >= $fechaFinMes);

                // Días procesables dentro del mes evaluado
                $fechaFin = $contrato->fecha_fin ?? $fechaFinMes;
                $inicioProcesable = Carbon::parse(max($contrato->fecha_inicio, $fechaInicioMes));
                $finProcesable = Carbon::parse(min($fechaFin, $fechaFinMes));

                // Si la fecha de fin es anterior al inicio, 0 días procesables
                $contrato->dias_procesables = $finProcesable->lt($inicioProcesable)
                    ? 0
                    : $finProcesable->diffInDays($inicioProcesable) + 1;

                // Cantidad de días del tipo de contrato (máximo 30)
                $dias_tipo = $contrato->rrhhtipocontrato->cantidad_dias ?? 30;
                $contrato->dias_tipo_contrato = min($dias_tipo, 30);

                // Valor del día según tipo de contrato
                $contrato->valor_dia = $contrato->salario_basico / $contrato->dias_tipo_contrato;

                return $contrato;
            });

        return $contratos;
    }
}
