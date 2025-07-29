<?php

namespace App\Http\Livewire\Vigilancia;

use App\Models\Designacione;
use App\Models\Imgregistro;
use App\Models\Registroguardia;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManagerStatic as Image;

class Panico extends Component
{
    use WithFileUploads;

    public $files = [], $informe = "", $conUbicacion = true, $designacion = null;

    public function mount()
    {
        $empleado_id = Auth::user()->empleados[0]->id;
        if ($empleado_id) {
            $this->designacion = Designacione::where('fechaFin', '>=', date('Y-m-d'))->where('empleado_id', $empleado_id)->orderBy('fechaInicio', 'ASC')->first();
        }
    }

    public function render()
    {
        return view('livewire.vigilancia.panico')->extends('layouts.app');
    }

    protected $listeners = ['guardarRegistro', 'registroPanico'];

    public function guardarRegistro($data)
    {
        if ($data) {
            DB::beginTransaction();
            try {
                $registro = Registroguardia::create([
                    "fechahora" => date('Y-m-d H:i:s'),
                    "prioridad" => $data[2],
                    "user_id" => Auth::user()->id,
                    "detalle" => $data[3],
                    "latitud" => $data[0],
                    "longitud" => $data[1],
                    "visto" => true,
                    "cliente_id" => $this->designacion->turno->cliente->id
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th->getMessage());
            }
        }
    }


    public function registroPanico($coord)
    {
        if ($coord) {
            DB::beginTransaction();
            try {
                $registro = Registroguardia::create([
                    "fechahora" => date('Y-m-d H:i:s'),
                    "prioridad" => 'ALTA',
                    "user_id" => Auth::user()->id,
                    "detalle" => $this->informe,
                    "latitud" => $coord[0],
                    "longitud" => $coord[1],
                    "cliente_id" => $this->designacion->turno->cliente->id
                ]);

                $x = 1;
                foreach ($this->files as $key => $file) {
                    $arrF = explode('.', $file->getFilename());
                    $name = date('YmdHis') . $x;

                    $x++;
                    // $path = $file->storeAs('images/registros/panico', $name . '.' . $arrF[1]);

                    $path = storage_path() . '\app\public\images\registros\panico/' . $name . '.' . $arrF[1];
                    Image::make($file)
                        ->resize(600, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save($path);;

                    $imgreg = Imgregistro::create([
                        "registroguardia_id" => $registro->id,
                        "plataforma" => "panico",
                        "url" => 'images\registros\panico/' . $name . '.' . $arrF[1],
                        "tipo" => $arrF[1],
                    ]);
                }
                DB::commit();

                return redirect()->route('home')->with('success', 'Registro de Pánico guardado correctamente.');
            } catch (\Throwable $th) {
                DB::rollBack();
                // return redirect()->route('home')->with('error', 'Ha ocurrido un error');
                $this->emit('error', $th->getMessage());
            }
        }
    }
}
