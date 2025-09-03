<?php

namespace App\Http\Controllers;

use App\Models\Paseingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

/**
 * Class PaseingresoController
 * @package App\Http\Controllers
 */
class PaseingresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paseingresos = Paseingreso::paginate();

        return view('paseingreso.index', compact('paseingresos'))
            ->with('i', (request()->input('page', 1) - 1) * $paseingresos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paseingreso = new Paseingreso();
        return view('paseingreso.create', compact('paseingreso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Paseingreso::$rules);

        $paseingreso = Paseingreso::create($request->all());

        return redirect()->route('paseingresos.index')
            ->with('success', 'Paseingreso created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paseingreso = Paseingreso::find($id);

        return view('paseingreso.show', compact('paseingreso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paseingreso = Paseingreso::find($id);

        return view('paseingreso.edit', compact('paseingreso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Paseingreso $paseingreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paseingreso $paseingreso)
    {
        request()->validate(Paseingreso::$rules);

        $paseingreso->update($request->all());

        return redirect()->route('paseingresos.index')
            ->with('success', 'Paseingreso updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $paseingreso = Paseingreso::find($id)->delete();

        return redirect()->route('paseingresos.index')
            ->with('success', 'Paseingreso deleted successfully');
    }

    public function resumen($id){
        $decryptedId = Crypt::decrypt($id);
        $paseingreso = Paseingreso::find($decryptedId);
        return view('paseingreso.resumen-pase',compact('paseingreso'));
    }
}
