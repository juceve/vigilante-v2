<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Propietario;
use App\Models\Residencia;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class RegistroPropietario extends Component
{
    public $clienteId = null;

    // Propietario
    public $nombre = '';
    public $cedula = '';
    public $telefono = '';
    public $email = '';
    public $direccion = '';
    public $ciudad = '';
    // 'activo' no se muestra: lo seteamos en false al guardar

    // Residencias dinámicas (JSON desde la vista)
    public $residencias_json = '';

    public function mount($clienteId = null)
    {
        $this->clienteId = $clienteId;
        $this->residencias_json = json_encode([[
            'numeropuerta' => '',
            'piso'         => '',
            'calle'        => '',
            'nrolote'      => '',
            'manzano'      => '',
            'notas'        => '',
        ]]);
    }

    public function save()
    {
        $this->validate([
            'nombre'    => 'required|string|max:100',
            'cedula'    => ['required', 'string', 'max:20', Rule::unique('propietarios', 'cedula')],
            'telefono'  => 'nullable|string|max:15',
            'email'     => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'ciudad'    => 'nullable|string|max:100',
        ]);

        $residencias = json_decode($this->residencias_json, true) ?? [];

        $residenciasValidas = array_filter($residencias, function ($res) {
            return !empty($res['numeropuerta']) ||
                !empty($res['piso']) ||
                !empty($res['calle']) ||
                !empty($res['nrolote']) ||
                !empty($res['manzano']) ||
                !empty($res['notas']);
        });

        if (count($residenciasValidas) === 0) {
            $this->addError('residencias', 'Debes llenar al menos una residencia con datos válidos.');
            return;
        }

        DB::beginTransaction();
        try {
            $propietario = Propietario::create([
                'nombre'    => $this->nombre,
                'cedula'    => $this->cedula,
                'telefono'  => $this->telefono ?: null,
                'email'     => $this->email ?: null,
                'direccion' => $this->direccion ?: null,
                'ciudad'    => $this->ciudad ?: null,
                'activo'    => false,
            ]);

            $residenciasIds = [];
            foreach ($residenciasValidas as $r) {
                $residencia = Residencia::create([
                    'cliente_id'         => $this->clienteId,
                    'propietario_id'     => $propietario->id,
                    'cedula_propietario' => $this->cedula,
                    'numeropuerta'       => $r['numeropuerta'] ?: null,
                    'piso'               => $r['piso'] ?: null,
                    'calle'              => $r['calle'] ?: null,
                    'nrolote'            => $r['nrolote'] ?: null,
                    'manzano'            => $r['manzano'] ?: null,
                    'notas'              => $r['notas'] ?: null,
                ]);
                $residenciasIds[] = $residencia->id;
            }

            DB::commit();

            // Guardar los IDs en la sesión
            Session::put('residencias_registradas', $residenciasIds);
            $encryptedId = Crypt::encryptString($propietario->id);
            // Redirigir al resumen del propietario
            return redirect()->route('propietario.resumen', $encryptedId);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            $this->addError('general', 'Ocurrió un error al guardar. Intenta de nuevo.');
        }
    }

    public function render()
    {
        return view('livewire.admin.registro-propietario')->extends('layouts.registros');
    }
}
