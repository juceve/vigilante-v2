<?php

namespace App\Http\Controllers;

use App\Models\Rrhhcontrato;
use Illuminate\Http\Request;

/**
 * Class RrhhcontratoController
 * @package App\Http\Controllers
 */
class RrhhcontratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rrhhcontratos = Rrhhcontrato::paginate();

        return view('rrhhcontrato.index', compact('rrhhcontratos'))
            ->with('i', (request()->input('page', 1) - 1) * $rrhhcontratos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rrhhcontrato = new Rrhhcontrato();
        return view('rrhhcontrato.create', compact('rrhhcontrato'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Rrhhcontrato::$rules);

        $rrhhcontrato = Rrhhcontrato::create($request->all());

        return redirect()->route('rrhhcontratos.index')
            ->with('success', 'Rrhhcontrato created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rrhhcontrato = Rrhhcontrato::find($id);

        return view('rrhhcontrato.show', compact('rrhhcontrato'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rrhhcontrato = Rrhhcontrato::find($id);

        return view('rrhhcontrato.edit', compact('rrhhcontrato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Rrhhcontrato $rrhhcontrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rrhhcontrato $rrhhcontrato)
    {
        request()->validate(Rrhhcontrato::$rules);

        $rrhhcontrato->update($request->all());

        return redirect()->route('rrhhcontratos.index')
            ->with('success', 'Rrhhcontrato updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $rrhhcontrato = Rrhhcontrato::find($id)->delete();

        return redirect()->route('rrhhcontratos.index')
            ->with('success', 'Rrhhcontrato deleted successfully');
    }
}
