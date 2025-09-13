<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Propietario;
use App\Models\Usercliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ListadoPropietarios extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $propietario_id, $nombre, $cedula, $telefono, $email, $direccion, $ciudad, $activo = true;
    public $search = '', $perPage = 5, $perPageOptions = [5, 10, 15, 25, 50];
    public $modalMode = 'create'; // create | edit | show

    public $cliente_id;

    protected function rules()
    {
        return [
            'nombre'    => 'required|string|max:100',
            'cedula'    => [
                'required',
                'string',
                'max:20',
                Rule::unique('propietarios', 'cedula')->ignore($this->propietario_id),
            ],
            'telefono'  => 'nullable|string|max:15',
            'email'     => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'ciudad'    => 'nullable|string|max:100',
            'activo'    => 'boolean',
        ];
    }

    public function mount()
    {
        $usercliente = Usercliente::where('user_id', auth()->id())->first();
        $this->cliente_id = $usercliente ? $usercliente->cliente_id : null;
    }

    public function render()
    {
        $propietarios = Propietario::whereHas('residencias', function ($query) {
            $query->where('cliente_id', $this->cliente_id);
        })
            ->where(function ($query) {
                $query->where('nombre', 'like', "%{$this->search}%")
                    ->orWhere('cedula', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.customer.listado-propietarios', compact('propietarios'))->extends('layouts.clientes');
    }

    public function edit($id)
    {
        $this->resetInput();
        $prop = Propietario::find($id);
        $this->propietario_id = $prop->id;
        $this->nombre = $prop->nombre;
        $this->cedula = $prop->cedula;
        $this->telefono = $prop->telefono;
        $this->email = $prop->email;
        $this->direccion = $prop->direccion;
        $this->ciudad = $prop->ciudad;
        $this->activo = $prop->activo;

        $this->modalMode = 'edit';
        $this->emit('openModal');
    }
    public function show($id)
    {
        $this->resetInput();
        $prop = Propietario::find($id);
        $this->propietario_id = $prop->id;
        $this->nombre = $prop->nombre;
        $this->cedula = $prop->cedula;
        $this->telefono = $prop->telefono;
        $this->email = $prop->email;
        $this->direccion = $prop->direccion;
        $this->ciudad = $prop->ciudad;
        $this->activo = $prop->activo;

        $this->modalMode = 'show';
        $this->emit('openModal');
    }

    public function create()
    {
        $this->modalMode = 'create';
        $this->resetInput();
        $this->emit('openModal');
    }

    public function resetInput()
    {
        $this->reset(['propietario_id', 'nombre', 'cedula', 'telefono', 'email', 'direccion', 'ciudad', 'activo']);
        $this->activo = true;
    }

    public function openModal($mode, $id = null)
    {
        $this->resetInput();
        $this->modalMode = $mode;

        if ($id) {
            $prop = Propietario::findOrFail($id);
            $this->propietario_id = $prop->id;
            $this->nombre = $prop->nombre;
            $this->cedula = $prop->cedula;
            $this->telefono = $prop->telefono;
            $this->email = $prop->email;
            $this->direccion = $prop->direccion;
            $this->ciudad = $prop->ciudad;
            $this->activo = $prop->activo;
            if ($mode == 'edit') {
                $this->rules['cedula'] = "required|string|max:20|unique:propietarios,cedula,{$this->propietario_id}";
            }
        }

        $this->emit('openModal');
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            if ($this->modalMode === 'edit') {
                $propietario = Propietario::find($this->propietario_id);
                $propietario->nombre = $this->nombre;
                $propietario->cedula = $this->cedula;
                $propietario->telefono = $this->telefono;
                $propietario->email = $this->email;
                $propietario->direccion = $this->direccion;
                $propietario->ciudad = $this->ciudad;
                $propietario->activo = $this->activo;
                $propietario->save();
            } else {
                Propietario::create([
                    'nombre'    => $this->nombre,
                    'cedula'    => $this->cedula,
                    'telefono'  => $this->telefono,
                    'email'     => $this->email,
                    'direccion' => $this->direccion,
                    'ciudad'    => $this->ciudad,
                    'activo'    => $this->activo,
                ]);
            }
            DB::commit();
            $this->emit('closeModal');
            $this->resetInput();
            $this->emit('success', 'Propietario guardado correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('error', $th->getMessage());
        }
    }

    protected $listeners = ['delete'];

    public function delete($id)
    {
        Propietario::findOrFail($id)->delete();
        $this->emit('success', 'Propietario eliminado correctamente.');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
