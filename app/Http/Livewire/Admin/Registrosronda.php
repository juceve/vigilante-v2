<?php

namespace App\Http\Livewire\Admin;

use App\Exports\RondasExport;
use App\Exports\VisitasExport;
use App\Models\Cliente;
use App\Models\Regronda;
use App\Models\Rondaejecutada;
use App\Models\Vwronda;
use App\Models\Vwvisita;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Registrosronda extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $clientes, $cliente_id = "",  $inicio, $final, $search = "";
    public $rondaejecutada;

     public $modalUrl = '';

    public function openModal($id)
    {
        $this->modalUrl = route('admin.recorrido_ronda', $id);

        // Disparar evento JS para abrir modal
        $this->dispatchBrowserEvent('openModal');
    }

    public function closeModal()
    {
        $this->modalUrl = '';
    }

    public function mount()
    {
        $this->inicio = date('Y-m-d');
        $this->final = date('Y-m-d');
        $this->clientes = Cliente::all()->pluck('nombre', 'id');
    }

    public function render()
    {
        $this->emit('showLoading');
        $resultados = Rondaejecutada::with('ronda', 'cliente', 'user')
            ->when($this->cliente_id, function ($query) {
                $query->where('cliente_id', $this->cliente_id);
            })
            ->when($this->inicio, function ($query) {
                $query->whereDate('inicio', '>=', $this->inicio);
            })
            ->when($this->final, function ($query) {
                $query->whereDate('inicio', '<=', $this->final);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereHas('ronda', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    })
                        ->orWhereHas('user', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);

            $this->emit('hideLoading');
        return view('livewire.admin.registrosronda', compact('resultados'))->extends('adminlte::page');
    }


    public function verInfo($id)
    {
        // $this->rondaejecutada = Rondaejecutada::find($id);
        return redirect()->route('admin.recorrido_ronda', $id);
    }

    public function exporExcel()
    {
        $cliente = Cliente::find($this->cliente_id);
        return Excel::download(new RondasExport(), 'Rondas_' . $cliente->nombre . '_' . date('His') . '.xlsx');
    }

    public function updatedCliente_id()
    {
        $this->resetPage();
    }
    public function updatedEstado()
    {
        $this->resetPage();
    }
    public function updatedInicio()
    {
        $this->resetPage();
    }
    public function updatedFinal()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
}
