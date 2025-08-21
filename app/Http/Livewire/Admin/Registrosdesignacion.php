<?php

namespace App\Http\Livewire\Admin;

use App\Models\Cliente;
use App\Models\Designacione;
use App\Models\Vwdesignacione;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Registrosdesignacion extends Component
{
    use WithPagination;

    public $clientes, $cliente_id = "", $estado = "1", $search = "";
    protected $paginationTheme = 'bootstrap'; // Activamos Bootstrap 4 para Livewire

    // Evitar reset de página al cambiar filtros
    protected $updatesQueryString = ['cliente_id', 'estado', 'search'];

    public function mount()
    {
        $this->clientes = Cliente::all()->pluck('nombre', 'id');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingClienteId()
    {
        $this->resetPage();
    }

    public function updatingEstado()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Vwdesignacione::query();

        // Filtro por cliente si se selecciona
        if ($this->cliente_id != "") {
            $query->where('cliente_id', $this->cliente_id);
        }

        // Filtro por estado si se selecciona
        if ($this->estado !== "") {
            $query->where('estado', $this->estado);
        }

        // Filtro por búsqueda en empleado o turno
        if ($this->search != "") {
            $query->where(function ($q) {
                $q->where('empleado', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('turno', 'LIKE', '%' . $this->search . '%');
            });
        }

        $resultados = $query->orderBy('id', 'ASC')->paginate(5); // Paginación 10 por página

        // Guardar parámetros en sesión
        $parametros = [$this->cliente_id, $this->estado, $this->search];
        Session::put('param-designacione', $parametros);

        $this->emit('dataTableRenderDes');

        return view('livewire.admin.registrosdesignacion', compact('resultados'))->with('i', 0);
    }

    protected $listeners = ['finalizar'];

    public function finalizar($id)
    {
        $designacione = Designacione::find($id);
        if ($designacione->estado == false) {
            $this->emit('error', 'La designación ya se encuentra finalizada.');
        } else {
            DB::beginTransaction();
            try {
                $designacione->fechaFin = date('Y-m-d');
                $designacione->estado = false;
                $designacione->save();
                DB::commit();
                $this->emit('success', 'Designación finalizada correctamente');
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->emit('error', 'Ha ocurrido un error');
            }
        }
    }

    public function exporExcel()
    {
        // Exportar Excel
    }
}
