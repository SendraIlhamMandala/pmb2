<?php

namespace App\Http\Controllers;

use App\Models\JalurDaftar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JalurDaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        // dd(123123);
    $jalurs = JalurDaftar::orderBy('created_at', 'desc')->get();

        return Inertia::render('Jalurs/JalursView', [
            'jalurs' => $jalurs,
            'status' => session('status'),]);
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
        //store shift data

        JalurDaftar::create($request->all());
        return redirect(route('jalurs.index'));

    }


    /**
     * Display the specified resource.
     */
    public function show(JalurDaftar $jalurDaftar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jalurDaftar = JalurDaftar::find($id);
        
            //edit page
            return Inertia::render('Jalurs/JalurEdit', [
                'jalurDaftar' => $jalurDaftar
            ]);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JalurDaftar $jalurDaftar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JalurDaftar $jalurDaftar)
    {
        //
    }
    
    public function deleteMultiple($id): RedirectResponse
    {
        $jalurs = [];
        $ids = json_decode($id);
        foreach ($ids as $key => $value_id) {
            $jalurs[$key] = JalurDaftar::find($value_id);
            $jalurs[$key]->delete();
        }
        
        return redirect(route('jalurs.index'));
        
    }

}
