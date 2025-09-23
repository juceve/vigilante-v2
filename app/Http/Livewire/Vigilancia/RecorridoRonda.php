<?php

namespace App\Http\Livewire\Vigilancia;

use App\Models\Rondapunto;
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

}
