<?php

namespace App\Http\Livewire\Vigilancia;

use App\Models\Ctrlpunto;
use App\Models\Designaciondia;
use App\Models\Designacione;
use App\Models\Imgregistro;
use App\Models\Imgronda;
use App\Models\Regronda;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Ronda extends Component
{
    use WithFileUploads;

    public $lat = "", $lng = "", $nombre = "", $proxpunto = null, $base = "", $files = [], $diaLaboral = false;
    public $latA = "", $lngA = "", $anotaciones = "", $empleado_id = "", $designacion = null;

    protected $listeners = ['lecturaQr', 'ubicacionAprox'];

    public function updatedFiles()
    {
        $this->emit('resultadoQr');
    }

    public function render()
    {
        $empleado_id = Auth::user()->empleados[0]->id;
        $designacion = null;
        $puntos = null;

        $cliente = null;
        if ($empleado_id) {
            $this->empleado_id = $empleado_id;
            $designacion = Designacione::where('fechaFin', '>=', date('Y-m-d'))->where('empleado_id', $empleado_id)->orderBy('fechaInicio', 'ASC')->first();
            if ($designacion) {
                $this->designacion = $designacion;
                $puntos = Ctrlpunto::where('turno_id', $designacion->turno_id)->orderBy('hora', 'ASC')->get();

                $diasLaborales = Designaciondia::where('designacione_id', $designacion->id)->select('domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado')->first()->toArray();
                // dd($diasLaborales);
                $this->validaDia($diasLaborales);
                $puntoRegistrado = null;
                foreach ($puntos as $punto) {
                    $this->base = date('Y-m-d ') . $punto->hora;
                    $this->base = new DateTime($this->base);

                    $this->base->modify('+5 minute');
                    $this->base = $this->base->format('H:i');

                    if ($this->base >= date('H:i')) {
                        $this->proxpunto = $punto;
                        $puntoRegistrado = Regronda::where('fecha', date('Y-m-d'))->where('ctrlpunto_id', $this->proxpunto->id)->first();
                        break;
                    }
                }
                $cliente = $designacion->turno->cliente;
            }
        }
        return view('livewire.vigilancia.ronda', compact('designacion', 'cliente', 'puntoRegistrado'))->extends('layouts.app');
    }

    protected $rules = [
        'latA' => 'required',
        'lngA' => 'required',
        'proxpunto' => 'required'
    ];

    public function regRonda()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $registro = Regronda::create([
                "empleado_id" => $this->empleado_id,
                "designacione_id" => $this->designacion->id,
                "ctrlpunto_id" => $this->proxpunto->id,
                "fecha" => date('Y-m-d'),
                "hora" => date('H:i'),
                "anotaciones" => $this->anotaciones,
                "latA" => $this->latA,
                "lngA" => $this->lngA,
            ]);

            $x = 1;
            foreach ($this->files as $key => $file) {
                $arrF = explode('.', $file->getFilename());
                $name = date('YmdHis') . $x;
                // if ($arrF[1] != "jpg" && $arrF[1] != "png" && $arrF[1] != "jpeg" && $arrF[1] != "gif") {
                //     DB::rollBack();
                //     $this->emit('error', 'Solo son permitidos archivos de imagen.');
                //     return;
                // }
                $x++;
                $path = $file->storeAs('images/registros/ronda', $name . '.' . $arrF[1]);

                $imgreg = Imgronda::create([
                    "regronda_id" => $registro->id,
                    "url" => $path,
                    "tipo" => $arrF[1],
                ]);
            }

            DB::commit();
            redirect()->route('home')->with('success', 'Ronda registrada correctamente.');
        } catch (\Throwable $th) {

            DB::rollBack();
            $this->emit('error', 'Ha ocurrido un error');
            // $this->emit('error',$th->getMessage());
        }
    }

    public function lecturaQr($resultado)
    {
        // dd($resultado);
        $punto = Ctrlpunto::find($resultado);
        $this->lat = $punto->latitud;
        $this->lng = $punto->longitud;
        $this->nombre = $punto->nombre;

        if ($this->validarHora()) {
            $this->emit('resultadoQr');
        } else {
            $this->emit('error', 'Fuera de margen de horario.');
        }
    }

    public function validaDia($dias)
    {
        $diasL = array("domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $diaL = $diasL[date('w')];

        if ($dias[$diaL]) {
            $this->diaLaboral = true;
        }
    }

    public function ubicacionAprox($data)
    {
        $this->latA = $data[0];
        $this->lngA = $data[1];
    }

    public function validarHora()
    {
        $hora_actual = date('H:i');

        $hora_ingresada = $this->base;


        if (preg_match("/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $hora_ingresada)) {

            $hora_ingresada_obj = DateTime::createFromFormat('H:i', $hora_ingresada);
            $hora_actual_obj = DateTime::createFromFormat('H:i', $hora_actual);

            $diferencia = $hora_ingresada_obj->getTimestamp() - $hora_actual_obj->getTimestamp();
            $diferencia_en_minutos = $diferencia / 60;

            if ($diferencia_en_minutos >= -5 && $diferencia_en_minutos <= 5) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
