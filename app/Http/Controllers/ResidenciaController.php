<?php

namespace App\Http\Controllers;

use App\Models\Residencia;
use Illuminate\Http\Request;

/**
 * Class ResidenciaController
 * @package App\Http\Controllers
 */
class ResidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $residencias = Residencia::paginate();

        return view('residencia.index', compact('residencias'))
            ->with('i', (request()->input('page', 1) - 1) * $residencias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $residencia = new Residencia();
        return view('residencia.create', compact('residencia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Residencia::$rules);

        $residencia = Residencia::create($request->all());

        return redirect()->route('residencias.index')
            ->with('success', 'Residencia created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $residencia = Residencia::find($id);

        return view('residencia.show', compact('residencia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $residencia = Residencia::find($id);

        return view('residencia.edit', compact('residencia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Residencia $residencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Residencia $residencia)
    {
        request()->validate(Residencia::$rules);

        $residencia->update($request->all());

        return redirect()->route('residencias.index')
            ->with('success', 'Residencia updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $residencia = Residencia::find($id)->delete();

        return redirect()->route('residencias.index')
            ->with('success', 'Residencia deleted successfully');
    }
}
