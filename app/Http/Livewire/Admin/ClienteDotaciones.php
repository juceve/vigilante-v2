<?php

namespace App\Http\Livewire\Admin;

use App\Models\Cldotacion;
use App\Models\Cldotaciondetalle;
use App\Models\Cliente;
use App\Models\Propietario;
use App\Models\Residencia;
use App\Models\Rrhhestadodotacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ClienteDotaciones extends Component
{
    use WithPagination;

    public $cliente_id, $cliente;
    public $search = '';
    public $perPage = 5;
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPageOptions = [5, 10, 15, 25, 50];
    public $filtro_estado = ''; // Nuevo filtro de estado

    public $fecha, $status = 1, $detalle = "", $cantidad = 1, $rrhhestadodotacion_id;
    public $detalles = [];

    public $dotacionSelect = null;

    public $mode = 'create', $procesando = false;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteDotacion'];

    public function mount($cliente_id = null)
    {
        $this->fecha = date('Y-m-d');
        $this->cliente_id = $cliente_id;
        $this->cliente = $cliente_id ? Cliente::find($cliente_id) : null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingfiltro_estado()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $resultados = Cldotacion::where('cliente_id', $this->cliente_id)
            ->where(function ($query) {
                if ($this->filtro_estado !== '') {
                    $query->where('status', $this->filtro_estado);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        $estados = Rrhhestadodotacion::all();

        return view('livewire.admin.cliente-dotaciones', compact('resultados', 'estados'))
            ->with('i', 0)
            ->extends('adminlte::page');
    }

    public function resetAll()
    {
        $this->reset('fecha', 'status', 'detalle', 'cantidad', 'rrhhestadodotacion_id', 'detalles', 'mode', 'procesando');
    }

    public function edit($cldotacion_id, $mode)
    {
        $this->resetAll();

        $this->mode = $mode;
        $dotacion = Cldotacion::find($cldotacion_id);
        // guardar instancia en la propiedad para usarla luego en update()
        $this->dotacionSelect = $dotacion;
        if ($dotacion) {
            $this->fecha = $dotacion->fecha;
            $this->status = $dotacion->status;
            foreach ($dotacion->cldotaciondetalles as $detalle) {
                $rrhhestadodotacion = Rrhhestadodotacion::find($detalle->rrhhestadodotacion_id);
                $this->detalles[] = [
                    'detalle' => $detalle->detalle,
                    'cantidad' => $detalle->cantidad,
                    'rrhhestadodotacion_id' => $detalle->rrhhestadodotacion_id,
                    'estado' => $rrhhestadodotacion->nombre,
                ];
            }
        }

        $this->emit('openModal');
    }

    public function update()
    {
        $this->validate([
            'fecha' => 'required|date',
            'status' => 'required|in:0,1',
            'detalles' => 'required|array|min:1',
        ]);

        if ($this->procesando) {
            return;
        }
        $this->procesando = true;
        DB::beginTransaction();
        try {
            if (! $this->dotacionSelect || ! $this->dotacionSelect->exists) {
                throw new \Exception('Dotación no cargada para editar.');
            }

            // Actualizar modelo principal
            $this->dotacionSelect->update([
                'fecha' => $this->fecha,
                'status' => $this->status,
            ]);

            // Reemplazar detalles
            $this->dotacionSelect->cldotaciondetalles()->delete();
            foreach ($this->detalles as $detalle) {
                $this->dotacionSelect->cldotaciondetalles()->create([
                    'detalle' => $detalle['detalle'],
                    'cantidad' => $detalle['cantidad'],
                    'rrhhestadodotacion_id' => $detalle['rrhhestadodotacion_id'] ?? null,
                ]);
            }

            DB::commit();

            $this->resetAll();
            $this->emit('closeModal');
            $this->emit('success', 'Dotación actualizada correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('error', $th->getMessage() ?: 'Error al actualizar la dotación');
        } finally {
            $this->procesando = false;
        }
    }

    public function create()
    {
        $this->validate([
            'fecha' => 'required|date',
            'status' => 'required|in:0,1',
            'detalles' => 'required|array|min:1',
        ]);


        if ($this->procesando) {
            return;
        }

        $this->procesando = true;

        DB::beginTransaction();
        try {
            $dotacion = Cldotacion::create([
                'cliente_id' => $this->cliente_id,
                'fecha' => $this->fecha ?? date('Y-m-d'),
                'status' => $this->status,
            ]);

            foreach ($this->detalles as $detalle) {
                $detalle = Cldotaciondetalle::create([
                    'cldotacion_id' => $dotacion->id,
                    'detalle' => $detalle['detalle'],
                    'cantidad' => $detalle['cantidad'],
                    'rrhhestadodotacion_id' => $detalle['rrhhestadodotacion_id'],
                ]);
            }

            DB::commit();

            // 🔥 Solo si se guardó bien se resetea y se cierra modal
            $this->resetAll();
            $this->emit('closeModal');
            $this->emit('success', 'Dotación creada correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->procesando = false;
            $this->emit('error', 'Error al crear la dotación');
        }
    }

    public function addDetalle()
    {
        // Validar solo los campos del detalle antes de agregar
        $this->validate([
            'detalle' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'rrhhestadodotacion_id' => 'required|exists:rrhhestadodotacions,id',
        ], [
            'detalle.required' => 'La descripción del detalle es obligatoria.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
            'rrhhestadodotacion_id.required' => 'Seleccione el estado del artículo.',
            'rrhhestadodotacion_id.exists' => 'El estado seleccionado no es válido.',
        ]);

        $estadoDotacion = Rrhhestadodotacion::find($this->rrhhestadodotacion_id);
        $row = [
            'detalle' => strtoupper($this->detalle),
            'cantidad' => $this->cantidad,
            'rrhhestadodotacion_id' => $estadoDotacion->id,
            'estado' => $estadoDotacion->nombre,
        ];
        $this->detalles[] = $row;
        // Resetear campos y errores específicos
        $this->reset('detalle', 'cantidad', 'rrhhestadodotacion_id');
        $this->resetValidation(['detalle', 'cantidad', 'rrhhestadodotacion_id']);
    }

    public function removeDetalle($i)
    {
        if (isset($this->detalles[$i])) {
            // elimina el elemento y reindexa el array
            array_splice($this->detalles, $i, 1);
        }
    }

    public function deleteDotacion($cldotacion_id)
    {
        $dotacion = Cldotacion::find($cldotacion_id);
        if ($dotacion) {
            DB::beginTransaction();
            try {
                // Eliminar detalles asociados
                $dotacion->cldotaciondetalles()->delete();
                // Eliminar dotación
                $dotacion->delete();

                DB::commit();
                $this->emit('success', 'Dotación eliminada correctamente');
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->emit('error', 'Error al eliminar la dotación');
            }
        } else {
            $this->emit('error', 'Dotación no encontrada');
        }
    }

    public function actaPDF($cldotacion_id)
    {
        $dotacion = Cldotacion::find($cldotacion_id);
        if ($dotacion) {
            Session::put('dotacion_acta', $dotacion);
           $this->emit('renderizarpdf');
        } else {
            $this->emit('error', 'Dotación no encontrada');
        }
    }
}
