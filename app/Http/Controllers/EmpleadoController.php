<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Empleado;
use App\Models\Oficina;
use App\Models\Rrhhcontrato;
use App\Models\Tipodocumento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class EmpleadoController
 * @package App\Http\Controllers
 */
class EmpleadoController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:empleados.index')->only('index');
        $this->middleware('can:empleados.create')->only('create', 'store');
        $this->middleware('can:empleados.edit')->only('edit', 'update');
        $this->middleware('can:empleados.destroy')->only('destroy');
    }

    public function index()
    {

        return view('admin.empleado.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleado = new Empleado();
        $areas = Area::all()->pluck('nombre', 'id');
        $tipodocs = Tipodocumento::all()->pluck('name', 'id');
        $oficinas = Oficina::all()->pluck('nombre', 'id');
        return view('admin.empleado.create', compact('empleado', 'areas', 'tipodocs', 'oficinas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Empleado::$rules);

        $empleado = Empleado::create($request->all());

        if ($request->generarusuario == 'on') {
            $area = Area::find($request->area_id);
            $usuario = User::create([
                "name" => $empleado->nombres . " " . $empleado->apellidos,
                "email" => $empleado->email,
                "password" => bcrypt($empleado->cedula),
                "template" => $area->template,
                "status" => true
            ]);
            $empleado->user_id = $usuario->id;
            $empleado->save();
        }


        //CONVERSION DE IMG64
        $perfilData = explode(';base64,', $request->perfil64);

        if (count($perfilData) == 2) {
            $image = base64_decode($perfilData[1]);
            $filename = 'perfil' . $empleado->id . '.png';
            $path = storage_path('app/public/images/empleados/' . $filename);
            $img = Image::make($image)->save($path);
            $empleado->imgperfil = 'images/empleados/' . $filename;
        }

        $perfilData = explode(';base64,', $request->anverso64);
        if (count($perfilData) == 2) {
            $image = base64_decode($perfilData[1]);
            $filename = 'anverso' . $empleado->id . '.png';
            $path = storage_path('app/public/images/empleados/' . $filename);
            $img = Image::make($image)->save($path);
            $empleado->cedulaanverso = 'images/empleados/' . $filename;
        }

        $perfilData = explode(';base64,', $request->reverso64);
        if (count($perfilData) == 2) {
            $image = base64_decode($perfilData[1]);
            $filename = 'reverso' . $empleado->id . '.png';
            $path = storage_path('app/public/images/empleados/' . $filename);
            $img = Image::make($image)->save($path);
            $empleado->cedulareverso = 'images/empleados/' . $filename;
        }

        $empleado->save();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empleado = Empleado::find($id);

        return view('admin.empleado.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado = Empleado::find($id);
        $areas = Area::all()->pluck('nombre', 'id');
        $tipodocs = Tipodocumento::all()->pluck('name', 'id');
        $oficinas = Oficina::all()->pluck('nombre', 'id');
        return view('admin.empleado.edit', compact('empleado', 'areas', 'tipodocs', 'oficinas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        request()->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'cedula' => 'required|min:3',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => ['required', Rule::unique('empleados')->ignore($empleado)],
        ]);
        $area = Area::find($request->area_id);
        $empleado->update($request->all());
        if ($request->generarusuario == 'on') {

            $usuario = User::create([
                "name" => $empleado->nombres . " " . $empleado->apellidos,
                "email" => $empleado->email,
                "password" => bcrypt($empleado->cedula),
                "template" => $area->template,
                "status" => true
            ]);
            $empleado->user_id = $usuario->id;
            $empleado->save();
        } else {
            if ($empleado->user_id) {
                $user = User::find($empleado->user_id);
                $user->template = $area->template;
                $user->save();
            }
        }


        //CONVERSION DE IMG64
        $perfilData = explode(';base64,', $request->perfil64);

        if (count($perfilData) == 2) {
            $image = base64_decode($perfilData[1]);
            $filename = 'perfil' . $empleado->id . '.png';
            $path = storage_path('app/public/images/empleados/' . $filename);
            $img = Image::make($image)->save($path);
            $empleado->imgperfil = 'images/empleados/' . $filename;
        }

        $perfilData = explode(';base64,', $request->anverso64);
        if (count($perfilData) == 2) {
            $image = base64_decode($perfilData[1]);
            $filename = 'anverso' . $empleado->id . '.png';
            $path = storage_path('app/public/images/empleados/' . $filename);
            $img = Image::make($image)->save($path);
            $empleado->cedulaanverso = 'images/empleados/' . $filename;
        }

        $perfilData = explode(';base64,', $request->reverso64);
        if (count($perfilData) == 2) {
            $image = base64_decode($perfilData[1]);
            $filename = 'reverso' . $empleado->id . '.png';
            $path = storage_path('app/public/images/empleados/' . $filename);
            $img = Image::make($image)->save($path);
            $empleado->cedulareverso = 'images/empleados/' . $filename;
        }

        $empleado->save();

        return redirect()->route('empleados.edit',$empleado->id)
            ->with('success', 'Empleado editado correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $empleado = Empleado::find($id);

            if ($empleado->user_id) {
                $usuario = User::find($empleado->user_id)->delete();
            }
            $empleado->delete();
            DB::commit();
            return redirect()->route('empleados.index')
                ->with('success', 'Empleado eliminado correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('empleados.index')
                ->with('error', 'Ha ocurrido un error');
        }
    }

    
}
