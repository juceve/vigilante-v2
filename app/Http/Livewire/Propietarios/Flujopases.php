<?php

namespace App\Http\Livewire\Propietarios;

use Livewire\Component;
use Livewire\WithPagination;

class Flujopases extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function render()
    {
        $paseingresos = \App\Models\Paseingreso::whereHas('residencia', function ($query) {
            $query->where('estado', 'VERIFICADO')
                ->where('propietario_id', auth()->user()->propietario->id);
        })
            ->where('nombre', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->pluck('id') // 👈 solo trae la columna id
            ->toArray();

        
        return view('livewire.propietarios.flujopases')->extends('layouts.propietarios');
    }
}
