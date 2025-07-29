<?php

namespace App\Http\Controllers;

use App\Models\Detallecotizacione;
use Illuminate\Http\Request;

/**
 * Class DetallecotizacioneController
 * @package App\Http\Controllers
 */
class DetallecotizacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detallecotizaciones = Detallecotizacione::paginate();

        return view('detallecotizacione.index', compact('detallecotizaciones'))
            ->with('i', (request()->input('page', 1) - 1) * $detallecotizaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $detallecotizacione = new Detallecotizacione();
        return view('detallecotizacione.create', compact('detallecotizacione'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Detallecotizacione::$rules);

        $detallecotizacione = Detallecotizacione::create($request->all());

        return redirect()->route('detallecotizaciones.index')
            ->with('success', 'Detallecotizacione created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detallecotizacione = Detallecotizacione::find($id);

        return view('detallecotizacione.show', compact('detallecotizacione'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detallecotizacione = Detallecotizacione::find($id);

        return view('detallecotizacione.edit', compact('detallecotizacione'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Detallecotizacione $detallecotizacione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detallecotizacione $detallecotizacione)
    {
        request()->validate(Detallecotizacione::$rules);

        $detallecotizacione->update($request->all());

        return redirect()->route('detallecotizaciones.index')
            ->with('success', 'Detallecotizacione updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $detallecotizacione = Detallecotizacione::find($id)->delete();

        return redirect()->route('detallecotizaciones.index')
            ->with('success', 'Detallecotizacione deleted successfully');
    }
}
