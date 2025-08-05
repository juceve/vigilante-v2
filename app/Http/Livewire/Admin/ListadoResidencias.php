<?php

namespace App\Http\Livewire\Admin;

use App\Models\Residencia;
use App\Models\Cliente;
use App\Models\Propietario;
use Livewire\Component;
use Livewire\WithPagination;

class ListadoResidencias extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $confirmingDelete = false;
    public $residenciaToDelete = null;

    // Form fields
    public $residencia_id;
    public $cliente_id;
    public $propietario_id;
    public $cedula_propietario;
    public $numeropuerta;
    public $calle;
    public $nrolote;
    public $manzano;
    public $notas;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'cliente_id' => 'required|exists:clientes,id',
        'propietario_id' => 'nullable|exists:propietarios,id',
        'cedula_propietario' => 'nullable|string|max:20',
        'numeropuerta' => 'required|string|max:10',
        'calle' => 'nullable|string|max:100',
        'nrolote' => 'nullable|string|max:10',
        'manzano' => 'nullable|string|max:10',
        'notas' => 'nullable|string',
    ];

    public function mount($cliente_id)
    {
        $this->cliente_id = $cliente_id;
        $this->resetForm();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function edit($id)
    {
        $residencia = Residencia::findOrFail($id);
        $this->residencia_id = $residencia->id;
        $this->cliente_id = $residencia->cliente_id;
        $this->propietario_id = $residencia->propietario_id;
        $this->cedula_propietario = $residencia->cedula_propietario;
        $this->numeropuerta = $residencia->numeropuerta;
        $this->calle = $residencia->calle;
        $this->nrolote = $residencia->nrolote;
        $this->manzano = $residencia->manzano;
        $this->notas = $residencia->notas;
        $this->showModal = true;
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->residencia_id) {
            $residencia = Residencia::findOrFail($this->residencia_id);
            $residencia->update([
                'cliente_id' => $this->cliente_id,
                'propietario_id' => $this->propietario_id,
                'cedula_propietario' => $this->cedula_propietario,
                'numeropuerta' => $this->numeropuerta,
                'calle' => $this->calle,
                'nrolote' => $this->nrolote,
                'manzano' => $this->manzano,
                'notas' => $this->notas,
            ]);
            session()->flash('message', 'Residencia actualizada correctamente.');
        } else {
            Residencia::create([
                'cliente_id' => $this->cliente_id,
                'propietario_id' => $this->propietario_id,
                'cedula_propietario' => $this->cedula_propietario,
                'numeropuerta' => $this->numeropuerta,
                'calle' => $this->calle,
                'nrolote' => $this->nrolote,
                'manzano' => $this->manzano,
                'notas' => $this->notas,
            ]);
            session()->flash('message', 'Residencia creada correctamente.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function confirmDelete($id)
    {
        $this->residenciaToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        if ($this->residenciaToDelete) {
            Residencia::findOrFail($this->residenciaToDelete)->delete();
            session()->flash('message', 'Residencia eliminada correctamente.');
            $this->residenciaToDelete = null;
            $this->confirmingDelete = false;
        }
    }

    public function resetForm()
    {
        $this->residencia_id = null;
        $this->cliente_id = null;
        $this->propietario_id = null;
        $this->cedula_propietario = '';
        $this->numeropuerta = '';
        $this->calle = '';
        $this->nrolote = '';
        $this->manzano = '';
        $this->notas = '';
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->confirmingDelete = false;
        $this->resetForm();
    }

    public function render()
    {
        $residencias = Residencia::with(['propietario'])
            ->when($this->search, function ($query) {
                $query->where('numeropuerta', 'like', '%' . $this->search . '%')
                    ->orWhere('calle', 'like', '%' . $this->search . '%')
                    ->orWhere('manzano', 'like', '%' . $this->search . '%')
                    ->orWhere('nrolote', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $clientes = Cliente::where('status', 1)->orderBy('nombre')->get();
        $propietarios = Propietario::orderBy('nombre')->get();

        return view('livewire.admin.listado-residencias', [
            'residencias' => $residencias,
            'clientes' => $clientes,
            'propietarios' => $propietarios,
        ])->extends('adminlte::page');
    }
}
