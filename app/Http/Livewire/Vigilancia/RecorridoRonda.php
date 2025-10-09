<?php

namespace App\Http\Livewire\Vigilancia;

use App\Models\Rondapunto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RecorridoRonda extends Component
{
    public $ronda_ejecutada, $ronda, $ronda_id, $cliente;

    public $puntos = [];
    public $puntosJs; // JSON preparado para la vista

    public function mount($rondaejecutada_id)
    {
        $this->ronda_ejecutada = \App\Models\Rondaejecutada::find($rondaejecutada_id);
        $this->ronda = $this->ronda_ejecutada->ronda;
        if ($this->ronda && $this->ronda->cliente) {
            $this->puntos = Rondapunto::where('ronda_id', $this->ronda->id)->get();
            $this->cliente = $this->ronda->cliente;
        }

        // Preparar JSON seguro de puntos para la plantilla (evita closures en Blade)
        $this->puntosJs = $this->puntos->map(function ($p) {
            return [
                'id' => $p->id,
                'lat' => (float) $p->latitud,
                'lng' => (float) $p->longitud,
                'desc' => $p->descripcion,
            ];
        })->values()->toJson();
    }

    public function render()
    {
        return view('livewire.vigilancia.recorrido-ronda')->extends('layouts.app');
    }

    protected $listeners = ['finalizarRonda', 'registrarPunto'];

    public function finalizarRonda($latitud, $longitud)
    {
        DB::beginTransaction();

        try {
            // Lógica para finalizar la ronda
            $this->ronda_ejecutada->fin = now();
            $this->ronda_ejecutada->latitud_fin = $latitud;
            $this->ronda_ejecutada->longitud_fin = $longitud;
            $this->ronda_ejecutada->status = 'FINALIZADA';
            $this->ronda_ejecutada->save();
            DB::commit();
            return redirect()->route('home')->with('success', 'Ronda finalizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error', $e->getMessage());
            return;
        }

    }

    // Nuevo: recibir el marcado de un punto desde el cliente (sin asumir esquema)
    public function registrarPunto($puntoId, $latitud, $longitud)
    {
        // Aquí puedes persistir la información según tu modelo (por ejemplo crear un registro de paso).
        // Para no romper si la base de datos no tiene la estructura esperada, de momento notificamos al cliente.
        // Si deseas guardar: buscar $this->ronda_ejecutada->id y crear el registro correspondiente.
        $this->emit('puntoRegistradoCliente', ['id' => $puntoId, 'lat' => $latitud, 'lng' => $longitud]);
    }
}
