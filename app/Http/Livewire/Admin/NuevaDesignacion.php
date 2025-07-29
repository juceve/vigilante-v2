<?php

namespace App\Http\Livewire\Admin;

use App\Models\Cliente;
use App\Models\Designaciondia;
use App\Models\Designacione;
use App\Models\Empleado;
use App\Models\Intervalo;
use App\Models\Turno;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NuevaDesignacion extends Component
{
    public $designacione = null;
    public $empleadoid = "", $empleado = null, $nombres = "",  $clienteid = "", $clienteSeleccionado = null;
    public $turnoid = "", $fechaInicio = "", $fechaFin = "", $intervalo_hv = 0, $observaciones = "";
    public $lunes = false, $martes = false, $miercoles = false, $jueves = false, $viernes = false, $sabado = false, $domingo = false;

    protected $rules = [
        'empleadoid' => 'required',
        'clienteid' => 'required',
        'turnoid' => 'required',
        'fechaInicio' => 'required',
        'fechaFin' => 'required',
    ];

    public function mount($designacione)
    {
        $this->designacione = $designacione;
        // $this->empleado = new Empleado();
    }

    public function seleccionaEmpleado($id)
    {
        $this->empleadoid = $id;
        $this->empleado = Empleado::find($id);
        $this->nombres = $this->empleado->nombres . " " . $this->empleado->apellidos;
    }

    public function updatedClienteid()
    {
        $this->clienteSeleccionado = Cliente::find($this->clienteid);
    }

    public function render()
    {
        $empleados = DB::table('empleados')
            ->join('areas', 'areas.id', '=', 'empleados.area_id')
            ->join('oficinas', 'oficinas.id', '=', 'empleados.oficina_id')
            ->join('users', 'users.id', '=', 'empleados.user_id')
            ->where('areas.template', '=', 'OPER')
            ->where('users.status', '=', 1)
            ->select('empleados.*', 'oficinas.nombre as oficina')->get();
        $clientes = Cliente::all();
        $clientes->pluck('nombre', 'id');

        $this->emit('dataTableNormal');

        return view('livewire.admin.nueva-designacion', compact('empleados', 'clientes'));
    }

    protected $listeners = ['seleccionaEmpleado'];

    public function registrar()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $designacion = Designacione::create([
                "empleado_id" => $this->empleadoid,
                "turno_id" => $this->turnoid,
                "fechaInicio" => $this->fechaInicio,
                "fechaFin" => $this->fechaFin,
                "intervalo_hv" => $this->intervalo_hv,
                "observaciones" => $this->observaciones,
            ]);
            $turno = Turno::find($this->turnoid);

            $intervalo = crearIntervalo($turno->horainicio, $turno->horafin, $this->intervalo_hv);
            foreach ($intervalo as $item) {
                Intervalo::create([
                    "designacione_id" => $designacion->id,
                    "hora" => $item,
                ]);
            }

            $dias = Designaciondia::create([
                "designacione_id" => $designacion->id,
                "lunes" => $this->lunes,
                "martes" => $this->martes,
                "miercoles" => $this->miercoles,
                "jueves" => $this->jueves,
                "viernes" => $this->viernes,
                "sabado" => $this->sabado,
                "domingo" => $this->domingo,
            ]);



            DB::commit();
            redirect()->route('designaciones.index')->with('success', 'Designación registrada correctamente.');
        } catch (\Throwable $th) {
            // $this->emit('error', $th->getMessage());
            $this->emit('error', 'Ha ocurrido un error');
            DB::rollBack();
        }
    }
}
