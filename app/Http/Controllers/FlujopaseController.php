<?php

namespace App\Http\Controllers;

use App\Models\Flujopase;
use Illuminate\Http\Request;

/**
 * Class FlujopaseController
 * @package App\Http\Controllers
 */
class FlujopaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flujopases = Flujopase::paginate();

        return view('flujopase.index', compact('flujopases'))
            ->with('i', (request()->input('page', 1) - 1) * $flujopases->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $flujopase = new Flujopase();
        return view('flujopase.create', compact('flujopase'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Flujopase::$rules);

        $flujopase = Flujopase::create($request->all());

        return redirect()->route('flujopases.index')
            ->with('success', 'Flujopase created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flujopase = Flujopase::find($id);

        return view('flujopase.show', compact('flujopase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flujopase = Flujopase::find($id);

        return view('flujopase.edit', compact('flujopase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Flujopase $flujopase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flujopase $flujopase)
    {
        request()->validate(Flujopase::$rules);

        $flujopase->update($request->all());

        return redirect()->route('flujopases.index')
            ->with('success', 'Flujopase updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $flujopase = Flujopase::find($id)->delete();

        return redirect()->route('flujopases.index')
            ->with('success', 'Flujopase deleted successfully');
    }
}
