<?php

namespace App\Http\Controllers;

use App\Models\Rrhhpermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class RrhhpermisoController
 * @package App\Http\Controllers
 */
class RrhhpermisoController extends Controller
{

    public function data($contrato_id)
    {
        $permisos = Rrhhpermiso::with('Rrhhtipopermiso:id,nombre') // Ajustá según tu modelo
            ->select('id', 'rrhhtipopermiso_id', 'fecha_inicio', 'fecha_fin', 'activo','documento_adjunto')
            ->where('rrhhcontrato_id', $contrato_id)
            ->get();


        return response()->json([
            'data' => $permisos->map(function ($permiso) {
                $button = '<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalPermisos" onclick="editar(' . $permiso->id . ')"><i class="fas fa-edit"></i></button> ';
                
                if (!is_null($permiso->documento_adjunto)) {
                    $button.='<a href="'.Storage::url($permiso->documento_adjunto).'"
                                                    class="btn btn-sm btn-success" download title="Descargar" target="_blank">
                                                    <i class="fas fa-cloud-download-alt"></i>
                                                </a>';
                }else{
                    $button.='<button class="btn btn-sm btn-success" disabled><i class="fas fa-cloud-download-alt"></i>
                                                </a>';
                }
                return [
                    'id' => $permiso->id,
                    'tipopermiso' => $permiso->rrhhtipopermiso->nombre ?? '—',
                    'fecha_inicio' => $permiso->fecha_inicio,
                    'fecha_fin' => $permiso->fecha_fin,
                    'activo' => $permiso->activo ? '<span class="badge badge-success badge-pill">SI</span>' : '<span class="badge badge-secondary badge-pill">NO</span>',
                    'boton' => $button,
                    'documento_adjunto' => $permiso->documento_adjunto,
                ];
            }),
        ]);
    }

    public function edit(Request $request)
    {
        $permiso = Rrhhpermiso::find($request->rrhhpermiso_id);
        return response()->json(['success' => true, 'message' => $permiso]);
    }

    public function update(Request $request)
    {
        $permiso = Rrhhpermiso::find($request->rrhhpermiso_id);

        $request->validate([
            'rrhhtipopermiso_id' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'nullable|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $permiso->rrhhtipopermiso_id = $request->rrhhtipopermiso_id;
            $permiso->fecha_inicio = $request->fecha_inicio;
            $permiso->fecha_fin = $request->fecha_fin;
            $permiso->motivo = $request->motivo;
            $permiso->activo = $request->activo;

            if ($request->hasFile('documento_adjunto')) {

                if (Storage::disk('public')->exists($permiso->documento_adjunto)) {
                    Storage::disk('public')->delete($permiso->documento_adjunto);
                    // Archivo eliminado
                }
                $archivo = $request->file('documento_adjunto');
                // $permiso->documento_adjunto = $request->file('documento_adjunto')->store('permisos', 'public');
                $rutaDestino = "storage/documentos/permisos/";
                if (!File::exists($rutaDestino)) {
                    File::makeDirectory($rutaDestino, 0755, true);
                }
                $nombre = $request->rrhhcontrato_id . '_' . Auth::user()->id . "_" . date('Ymd_His');
                // Obtiene la extensión original
                $extension = $archivo->getClientOriginalExtension();
                $archivo->move($rutaDestino, $nombre . '.' . $extension);
                $permiso->documento_adjunto = "documentos/permisos/" . $nombre . '.' . $extension;
            }
            $permiso->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Permiso actualizado correctamente.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
    public function store(Request $request)
    {

        $request->validate([
            'rrhhtipopermiso_id' => 'required',
            'rrhhcontrato_id' => 'required',
            'empleado_id' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'nullable|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $permiso = Rrhhpermiso::create([
                "rrhhtipopermiso_id" => $request->rrhhtipopermiso_id,
                "rrhhcontrato_id" => $request->rrhhcontrato_id,
                "empleado_id" => $request->empleado_id,
                "fecha_inicio" => $request->fecha_inicio,
                "fecha_fin" => $request->fecha_fin,
                "motivo" => $request->motivo,
                "activo" => 1,
            ]);
            if ($request->hasFile('documento_adjunto')) {
                $archivo = $request->file('documento_adjunto');
                // $permiso->documento_adjunto = $request->file('documento_adjunto')->store('permisos', 'public');
                $rutaDestino = "storage/documentos/permisos/";
                if (!File::exists($rutaDestino)) {
                    File::makeDirectory($rutaDestino, 0755, true);
                }
                $nombre = $request->rrhhcontrato_id . '_' . Auth::user()->id . "_" . date('Ymd_His');
                // Obtiene la extensión original
                $extension = $archivo->getClientOriginalExtension();
                $archivo->move($rutaDestino, $nombre . '.' . $extension);
                $permiso->documento_adjunto = "documentos/permisos/" . $nombre . '.' . $extension;
                $permiso->save();
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Permiso guardado correctamente.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
