<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TahunController extends Controller
{
   
        /**
         * Display a listing of the resource.
         */
        public function index():Response
        {
            
        $tahun = Tahun::orderBy('created_at', 'desc')->get();
    
            return Inertia::render('Tahun/TahunView', [
                'tahun' => $tahun,
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

        $no_utama = "".$request->tahun."".$request->gelombang."0000";
        $no_utama_int = intval($no_utama);
        $data_tahun = $request->all();
        $data_tahun["no_utama"] = $no_utama;
            
        try {
            $tahun = Tahun::create($data_tahun);
            $tahun->save();
        } catch (Throwable $e) {
            report($e);
            return redirect()->back()->withErrors($e->getMessage());
        }
            
        // return back();
        return redirect(route('tahuns.index'));
        // return Inertia::location('/tahuns');

    }

    /**
     * Display the specified resource.
     */
    public function show(Tahun $tahun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tahun $tahun)
    {
        //edit tahun
        return Inertia::render('Tahun/TahunEdit', [
            'tahun' => $tahun
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tahun $tahun) : RedirectResponse
    {   
        //update tahun
        $tahun->update($request->all());
        return redirect(route('tahuns.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tahun $tahun)
    {
        //
    }

    public function deleteOne(Tahun $id): RedirectResponse
    {
        $id->delete();
        return redirect(route('tahuns.index'));
  
    }
}
