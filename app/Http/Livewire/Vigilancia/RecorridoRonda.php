<?php

namespace App\Http\Livewire\Vigilancia;

use App\Models\Rondapunto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RecorridoRonda extends Component
{
    public $ronda_ejecutada, $ronda, $ronda_id, $cliente;

    public $puntos = [];

    public function mount($rondaejecutada_id)
    {
        $this->ronda_ejecutada = \App\Models\Rondaejecutada::find($rondaejecutada_id);
        $this->ronda = $this->ronda_ejecutada->ronda;
        if ($this->ronda && $this->ronda->cliente) {
            $this->puntos = Rondapunto::where('ronda_id', $this->ronda->id)->get();
            $this->cliente = $this->ronda->cliente;
        }
    }

    public function render()
    {
        return view('livewire.vigilancia.recorrido-ronda')->extends('layouts.app');
    }

    protected $listeners = ['finalizarRonda'];

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
            // $this->emit('error', 'Ocurrió un error al finalizar la ronda. Inténtalo de nuevo.');
            return;
        }

    }
}
