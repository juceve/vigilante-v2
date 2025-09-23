<?php

namespace App\Http\Livewire\Vigilancia;

use App\Models\Designacione;
use App\Models\Rondaejecutadaubicacione;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class RondaEnProgreso extends Component
{
    public $rondaejecutada_id = 0;
    public $latitud;
    public $longitud;

    // Última ubicación registrada
    protected $ultima_latitud = null;
    protected $ultima_longitud = null;
    protected $ultimo_registro = null;

    protected $listeners = ['registrarUbicacion' => 'registrarUbicacion'];

    public function mount()
    {
        $this->verificarRonda();
    }

    public function verificarRonda()
    {
        $cliente_id = Session::get('cliente_id-oper');
        $this->rondaejecutada_id = tengoRondaIniciada(Auth::id(), $cliente_id);
    }

    public function registrarUbicacion()
    {
        $this->verificarRonda();

        if (!$this->rondaejecutada_id || !$this->latitud || !$this->longitud) {
            return;
        }

        $ahora = Carbon::now();
        $registrar = false;

        if (!$this->ultimo_registro) {
            // Primer registro
            $registrar = true;
        } else {
            $tiempo_diff = $ahora->diffInSeconds($this->ultimo_registro);
            $distancia = $this->calcularDistancia($this->ultima_latitud, $this->ultima_longitud, $this->latitud, $this->longitud);

            if ($tiempo_diff >= 60 || $distancia >= 0.15) { // 1 min o 150 metros
                $registrar = true;
            }
        }

        if ($registrar) {
            Rondaejecutadaubicacione::create([
                'rondaejecutada_id' => $this->rondaejecutada_id,
                'latitud' => $this->latitud,
                'longitud' => $this->longitud,
                'fecha_hora' => $ahora,
            ]);

            $this->ultima_latitud = $this->latitud;
            $this->ultima_longitud = $this->longitud;
            $this->ultimo_registro = $ahora;
        }
    }

    // Calcula distancia en km entre dos coordenadas
    protected function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth_radius * $c; // distancia en km
    }

    public function render()
    {
        return view('livewire.vigilancia.ronda-en-progreso');
    }
}
