<?php

namespace App\Http\Controllers;

use App\Models\JalurDaftar;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        
    $shifts = Shift::orderBy('created_at', 'desc')->get();
    $shifts->load('jalurdaftars');
        return Inertia::render('Shifts/ShiftsView', [
            'shifts' => $shifts,
            'jalurs' => JalurDaftar::all(),
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

        
        $shift = Shift::create($request->shift);
        
        foreach ($request->jalur['id'] as $key => $value) {
            $shift->jalurdaftars()->attach(JalurDaftar::find($value));
        }

        return redirect(route('shifts.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        //
        
            //edit page
            $shift->load('jalurdaftars');
            return Inertia::render('Shifts/ShiftEdit', [
                'shift' => $shift,
                'jalurs' => JalurDaftar::all()
            ]);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        //
           //update shift
           $shift->update($request->shift);
           $shift->jalurdaftars()->detach();
           foreach ($request->jalur['id'] as $key => $value) {
               $shift->jalurdaftars()->attach(JalurDaftar::find($value));
           }
           return redirect(route('shifts.index'));
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        //
    }

    //delete one 
    public function deleteOne(Shift $id): RedirectResponse
    {
        // dd($id);
        $id->delete();
        return redirect(route('shifts.index'));
    }

    public function deleteMultiple($id): RedirectResponse
    {
        $shifts = [];
        $ids = json_decode($id);
        foreach ($ids as $key => $value_id) {
            $shifts[$key] = Shift::find($value_id);
            $shifts[$key]->delete();
        }
        
        return redirect(route('shifts.index'));
        
    }
}
