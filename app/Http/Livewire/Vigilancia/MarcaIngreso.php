<?php

namespace App\Http\Livewire\Vigilancia;

use App\Models\Asistencia;
use App\Models\Designacione;
use Livewire\Component;

class MarcaIngreso extends Component
{
    public $lat = "", $lng = "", $designacione_id = "", $designacione = null;
    public $bloqueado = false;

    protected $listeners = ['cargaPosicion'];

    public function render()
    {
        $this->designacione = Designacione::find($this->designacione_id);
        return view('livewire.vigilancia.marca-ingreso');
    }

    public function marcar()
    {
        if ($this->bloqueado) return;
        $this->bloqueado = true;

        Asistencia::create([
            'designacione_id' => $this->designacione_id,
            'fecha' => now()->toDateString(),
            'ingreso' => now(),
            'latingreso' => $this->lat,
            'lngingreso' => $this->lng,
        ]);

        return redirect()->route('home');
    }

    public function cargaPosicion($data)
    {
        $this->lat = $data[0];
        $this->lng = $data[1];

        // Una vez recibida la posición, recién marcar
        $this->marcar();
    }
}
