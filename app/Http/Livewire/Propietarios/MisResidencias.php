<?php

namespace App\Http\Livewire\Propietarios;

use App\Models\Residencia;
use App\Models\Tipopase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MisResidencias extends Component
{
    public $residencia;

    public function render()
    {
        $tipopases = Tipopase::all();
        $residencias = \App\Models\Residencia::where('propietario_id', auth()->user()->propietario->id)->get();
        return view('livewire.propietarios.mis-residencias', compact('residencias', 'tipopases'))->extends('layouts.propietarios');
    }

    public function verDetalles($id)
    {
        $this->residencia = Residencia::find($id);
        $this->emit('openModal');
    }

    public function resetearCampos()
    {
        $this->reset('residencia', 'nombre', 'cedula', 'tipopase_id', 'fecha_inicio', 'fecha_fin', 'detalles');
    }

    public function nuevoPase($residencia_id)
    {

        $this->residencia = Residencia::find($residencia_id);
        if ($this->residencia->estado != 'VERIFICADO') {
            return;
        }
        $this->emit('openModalNuevo');
    }

    public $nombre = "", $cedula = "", $tipopase_id = "", $fecha_inicio = "", $fecha_fin = "", $detalles = "";

    public function registrarPase()
    {
        if ($this->residencia->estado != 'VERIFICADO') {
            return;
        }

        $this->validate([
            'nombre' => 'required',
            'cedula' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipopase_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            if (!$this->residencia) {
                $this->emit('error', 'No tienes una residencia verificada.');
                return;
            }

            $paseingreso = new \App\Models\Paseingreso();
            $paseingreso->residencia_id = $this->residencia->id;
            $paseingreso->nombre = $this->nombre;
            $paseingreso->cedula = $this->cedula;
            $paseingreso->fecha_inicio = $this->fecha_inicio;
            $paseingreso->fecha_fin = $this->fecha_fin;
            $paseingreso->tipopase_id = $this->tipopase_id;
            $paseingreso->detalles = $this->detalles;
            $paseingreso->save();

            DB::commit();

            $this->resetearCampos();

            $this->emit('closeModalNuevo');

            $encryptedId = Crypt::encrypt($paseingreso->id);
            $this->emit('resumenpase', $encryptedId);

            $this->emit('success', 'Pase registrado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('closeModalNuevo');
            $this->emit('error', 'Error al registrar el pase: ' . $e->getMessage());
        }
    }
}
