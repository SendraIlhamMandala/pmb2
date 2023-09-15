<?php

namespace App\Http\Controllers;

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

        return Inertia::render('Shifts/ShiftsView', [
            'shifts' => $shifts,
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

        Shift::create($request->all());
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
            return Inertia::render('Shifts/ShiftEdit', [
                'shift' => $shift
            ]);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        //
           //update shift
           $shift->update($request->all());
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
