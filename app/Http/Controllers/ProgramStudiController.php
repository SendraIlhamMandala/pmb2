<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // dd(123123);
        $prodis = ProgramStudi::orderBy('created_at', 'desc')->get();

        return Inertia::render('Prodis/ProdisView', [
            'prodis' => $prodis,
            'status' => session('status'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //store program studi
        ProgramStudi::create($request->all());
        return redirect(route('prodis.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramStudi $programStudi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $programStudi = ProgramStudi::find($id);

        //edit page
        return Inertia::render('Prodis/ProdiEdit', [
            'programStudi' => $programStudi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $programStudi = ProgramStudi::find($id);

        $programStudi->update($request->all());
        return redirect(route('prodis.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudi $programStudi)
    {
        //
    }

    public function deleteOne(ProgramStudi $id): RedirectResponse
    {
        // dd($id);
        $id->delete();
        return redirect(route('prodis.index'));
    }

    public function deleteMultiple($id): RedirectResponse
    {
        $prodis = [];
        $ids = json_decode($id);
        foreach ($ids as $key => $value_id) {
            $prodis[$key] = ProgramStudi::find($value_id);
            $prodis[$key]->delete();
        }

        return redirect(route('prodis.index'));
    }
}
