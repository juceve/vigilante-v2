<?php

namespace App\Http\Livewire\Kardex;

use App\Models\Empleado;
use App\Models\Rrhhcargo;
use App\Models\Rrhhcontrato;
use App\Models\Rrhhdocscontrato;
use App\Models\Rrhhtipocontrato;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Contratos extends Component
{

    public $empleado, $procesando = false, $edit = false, $show = false, $selContrato;
    public $rrhhtipocontratoid = "", $fecha_inicio = "", $fecha_fin = "", $salario_basico = "", $rrhhcargo_id = "", $moneda = "", $motivo_fin = "", $activo = '';
    public $referencia = "";

    public function mount($empleado_id)
    {
        $this->empleado = Empleado::find($empleado_id);
    }
    public function render()
    {

        $tipocontratos = Rrhhtipocontrato::where('activo', 1)->get();
        $cargos = Rrhhcargo::all();
        $contratos = $this->empleado->contratos()->orderBy('id', 'desc')->get();
        return view('livewire.kardex.contratos', compact('contratos', 'tipocontratos', 'cargos'));
    }

    protected $listeners = ['registrarDoc'];

    protected $rules = [
        'rrhhtipocontratoid' => 'required',
        'fecha_inicio' => 'required',
        'salario_basico' => 'required',
        'rrhhcargo_id' => 'required',
        'moneda' => 'required',
    ];

    public function subirArchivo()
    {
        $this->emit('subir', $this->selContrato->id);
    }

    public function registrarDoc($url, $referencia)
    {
        DB::beginTransaction();
        try {
            $referencia = str_replace(' ','_',$referencia);
            $documento = Rrhhdocscontrato::create([
                'rrhhcontrato_id' => $this->selContrato->id,
                'referencia' => $referencia,
                'url' => $url,
            ]);
            
            DB::commit();
            $this->selContrato->refresh();
            $this->emit('toast-success', 'Documento registrado correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();

            // Convertir a ruta relativa para Storage
            $rutaRelativa = str_replace('public/storage/', '', $url);

            Storage::disk('public')->delete($rutaRelativa);
            Log::info($th->getMessage());
            
        }
    }

    public function verInfo($contrato_id)
    {
        $this->show = true;
        $this->editContrato($contrato_id);
    }

    public function editContrato($contrato_id)
    {
        $this->selContrato = Rrhhcontrato::find($contrato_id);

        $this->rrhhtipocontratoid = $this->selContrato->rrhhtipocontrato_id;
        $this->fecha_inicio = $this->selContrato->fecha_inicio;
        $this->fecha_fin = $this->selContrato->fecha_fin;
        $this->salario_basico = $this->selContrato->salario_basico;
        $this->rrhhcargo_id = $this->selContrato->rrhhcargo_id;
        $this->moneda = $this->selContrato->moneda;
        $this->motivo_fin = $this->selContrato->motivo_fin;
        $this->activo = $this->selContrato->activo;
        $this->edit = true;
    }

    public function limpiar()
    {
        $this->reset('rrhhtipocontratoid', 'fecha_inicio', 'fecha_fin', 'salario_basico', 'rrhhcargo_id', 'moneda', 'motivo_fin', 'procesando', 'activo', 'selContrato', 'edit', 'show');
    }

    public function updateContrato()
    {
        if ($this->procesando) {
            return;
        } else {
            $this->validate();

            $this->procesando = true;
            DB::beginTransaction();
            try {
                $this->selContrato->empleado_id = $this->empleado->id;
                $this->selContrato->rrhhtipocontrato_id = $this->rrhhtipocontratoid;
                $this->selContrato->fecha_inicio = $this->fecha_inicio;
                $this->selContrato->fecha_fin = $this->fecha_fin ? $this->fecha_fin : NULL;
                $this->selContrato->salario_basico = $this->salario_basico;
                $this->selContrato->rrhhcargo_id = $this->rrhhcargo_id;
                $this->selContrato->moneda = $this->moneda;
                $this->selContrato->activo = $this->activo;
                $this->selContrato->motivo_fin = $this->motivo_fin ? $this->motivo_fin : NULL;
                $this->selContrato->save();
                DB::commit();
                $this->limpiar();
                $this->empleado->refresh();
                $this->emit('success', 'Contrato actualizado correctamente.');
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->procesando = false;
                $this->emit('error', $th->getMessage());
            }
        }
    }
    public function registrarContrato()
    {
        if ($this->procesando) {
            return;
        } else {
            $this->validate();

            $this->procesando = true;
            DB::beginTransaction();
            try {
                $contrato = Rrhhcontrato::create([
                    "empleado_id" => $this->empleado->id,
                    "rrhhtipocontrato_id" => $this->rrhhtipocontratoid,
                    "fecha_inicio" => $this->fecha_inicio,
                    "fecha_fin" => $this->fecha_fin ? $this->fecha_fin : NULL,
                    "salario_basico" => $this->salario_basico,
                    "rrhhcargo_id" => $this->rrhhcargo_id,
                    "moneda" => $this->moneda
                ]);
                DB::commit();
                $this->limpiar();
                $this->empleado->refresh();
                $this->emit('success', 'Contrato registrado correctamente.');
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->procesando = false;
                $this->emit('error', $th->getMessage());
            }
        }
    }

    public function updatedRrhhtipocontratoid()
    {
        $tipocontrato = Rrhhtipocontrato::find($this->rrhhtipocontratoid);
        $this->salario_basico = $tipocontrato->sueldo_referencial;
    }
}
