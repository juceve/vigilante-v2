<?php

namespace App\Http\Controllers;

use App\Models\Tipopase;
use Illuminate\Http\Request;

/**
 * Class TipopaseController
 * @package App\Http\Controllers
 */
class TipopaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipopases = Tipopase::paginate();

        return view('tipopase.index', compact('tipopases'))
            ->with('i', (request()->input('page', 1) - 1) * $tipopases->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipopase = new Tipopase();
        return view('tipopase.create', compact('tipopase'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Tipopase::$rules);

        $tipopase = Tipopase::create($request->all());

        return redirect()->route('tipopases.index')
            ->with('success', 'Tipopase created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipopase = Tipopase::find($id);

        return view('tipopase.show', compact('tipopase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipopase = Tipopase::find($id);

        return view('tipopase.edit', compact('tipopase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tipopase $tipopase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipopase $tipopase)
    {
        request()->validate(Tipopase::$rules);

        $tipopase->update($request->all());

        return redirect()->route('tipopases.index')
            ->with('success', 'Tipopase updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tipopase = Tipopase::find($id)->delete();

        return redirect()->route('tipopases.index')
            ->with('success', 'Tipopase deleted successfully');
    }
}
