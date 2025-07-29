<?php

namespace App\Http\Controllers;

use App\Models\Motivo;
use Illuminate\Http\Request;

/**
 * Class MotivoController
 * @package App\Http\Controllers
 */
class MotivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motivos = Motivo::paginate();

        return view('motivo.index', compact('motivos'))
            ->with('i', (request()->input('page', 1) - 1) * $motivos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $motivo = new Motivo();
        return view('motivo.create', compact('motivo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Motivo::$rules);

        $motivo = Motivo::create($request->all());

        return redirect()->route('motivos.index')
            ->with('success', 'Motivo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $motivo = Motivo::find($id);

        return view('motivo.show', compact('motivo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $motivo = Motivo::find($id);

        return view('motivo.edit', compact('motivo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Motivo $motivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motivo $motivo)
    {
        request()->validate(Motivo::$rules);

        $motivo->update($request->all());

        return redirect()->route('motivos.index')
            ->with('success', 'Motivo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $motivo = Motivo::find($id)->delete();

        return redirect()->route('motivos.index')
            ->with('success', 'Motivo deleted successfully');
    }
}
