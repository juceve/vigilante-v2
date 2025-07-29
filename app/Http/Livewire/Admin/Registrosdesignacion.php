<?php

namespace App\Http\Livewire\Admin;

use App\Models\Cliente;
use App\Models\Designacione;
use App\Models\Vwdesignacione;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Registrosdesignacion extends Component
{
    public $clientes, $cliente_id = "", $estado = "1", $inicio, $final, $search = "";

    public function mount()
    {
        $this->inicio = date('Y-m-d');
        $this->final = date('Y-m-d');
        $this->clientes = Cliente::all()->pluck('nombre', 'id');
        // $this->visita = new Visita();
    }

    public function render()
    {
        $resultados = NULL;
        $sql = "";
        if ($this->cliente_id != "") {

            if ($this->estado == "") {

                $resultados = Vwdesignacione::where([
                    ["fechaInicio", ">=", $this->inicio],
                    ["fechaInicio", "<=", $this->final],
                    ["cliente_id", $this->cliente_id],
                    ['empleado', 'LIKE', '%' . $this->search . '%']
                ])->orWhere([
                    ["fechaInicio", ">=", $this->inicio],
                    ["fechaInicio", "<=", $this->final],
                    ["cliente_id", $this->cliente_id],
                    ['turno', 'LIKE', '%' . $this->search . '%']
                ])->orderBy('id', 'ASC')
                    ->get();
            } else {
                $resultados = Vwdesignacione::where([
                    ["fechaInicio", ">=", $this->inicio],
                    ["fechaInicio", "<=", $this->final],
                    ["cliente_id", $this->cliente_id],
                    ['empleado', 'LIKE', '%' . $this->search . '%'],
                    ["estado", $this->estado],
                ])->orWhere([
                    ["fechaInicio", ">=", $this->inicio],
                    ["fechaInicio", "<=", $this->final],
                    ["cliente_id", $this->cliente_id],
                    ['turno', 'LIKE', '%' . $this->search . '%'],
                    ["estado", $this->estado],
                ])->orderBy('id', 'ASC')
                    ->get();
            }

            $parametros = array($this->cliente_id, $this->estado, $this->inicio, $this->final, $this->search);
            Session::put('param-designacione', $parametros);
            $this->emit('dataTableRenderDes');
        }

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
        // $cliente = Cliente::find($this->cliente_id);
        // return Excel::download(new VisitasExport(), 'Visitas_' . $cliente->nombre . '_' . date('His') . '.xlsx');
    }
}
