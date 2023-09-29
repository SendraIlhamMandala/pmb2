<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        
    $pengumuman = Pengumuman::orderBy('created_at', 'desc')->get();

        return Inertia::render('Pengumuman/PengumumansView', [
            'pengumuman' => $pengumuman,
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
        
        
        $gambar = $request->gambar;
        $gambar_name = date('Y-m-d') . $gambar->getClientOriginalName();
        $gambar_path = 'gambar/' . $gambar_name;
        Storage::disk('public')->put($gambar_path, file_get_contents($gambar));
        $data_pengumuman = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambar_name
        ];
        
        //store pengumuman
        Pengumuman::create($data_pengumuman);


        


        return redirect(route('pengumumans.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        //
    }
  //delete one 
  public function deleteOne(Pengumuman $id): RedirectResponse
  {
      // dd($id);
      $id->delete();
      return redirect(route('pengumumans.index'));
  }

  public function deleteMultiple($id): RedirectResponse
  {
      $pengumumans = [];
      $ids = json_decode($id);
      foreach ($ids as $key => $value_id) {
          $pengumumans[$key] = Pengumuman::find($value_id);
          $pengumumans[$key]->delete();
      }
      
      return redirect(route('pengumumans.index'));
      
  }

}
