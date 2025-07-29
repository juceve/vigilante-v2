<?php

namespace App\Http\Livewire\Vigilancia;

use App\Models\Asistencia;
use App\Models\Designacione;
use App\Models\Marcacione;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MarcaSalida extends Component
{
    public $lat = "", $lng = "", $designacione_id = "", $designacione = null;

    public function render()
    {
        $this->designacione = Designacione::find($this->designacione_id);
        return view('livewire.vigilancia.marca-salida');
    }

    protected $listeners = ['cargaPosicion', 'marcar'];

    public function marcar()
    {
        $hoy = date('Y-m-d');
        $ayer = new DateTime($hoy);
        $ayer = $ayer->modify('-1 days');
        $ayer = $ayer->format('Y-m-d');

        if ($this->designacione->turno->horainicio < $this->designacione->turno->horafin) {
            $asistencia = Asistencia::where([['fecha', $hoy], ['designacione_id', $this->designacione->id]])->first();
            $asistencia->salida = date('Y-m-d H:i:s');
            $asistencia->save();
            return redirect()->route('home')->with('success', 'Salida registrada correctamente');
        } else {
            $horaingreso = new DateTime($hoy . " " . $this->designacione->turno->horainicio);
            $horaingreso = $horaingreso->modify('-1 hours');
            $horaactual = date('H:i');
            $asistencia = [];
            if ($horaactual > $horaingreso->format('H:i')) {
                $asistencia = Asistencia::where([['fecha', $hoy], ['designacione_id', $this->designacione->id]])->first();
            } else {
                $asistencia = Asistencia::where([['fecha', $ayer], ['designacione_id', $this->designacione->id]])->first();
            }

            if ($asistencia->count()) {
                $asistencia->salida = date('Y-m-d H:i:s');
                $asistencia->save();
                return redirect()->route('home')->with('success', 'Salida registrada correctamente');
            } else {
                $this->emit('error', 'Error: No tiene un marcado de ingreso previo');
            }
        }
    }

    public function cargaPosicion($data)
    {
        $this->lat = $data[0];
        $this->lng = $data[1];
    }
}
