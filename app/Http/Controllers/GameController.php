<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        
        $games = Game::orderBy('created_at', 'desc')->get();
        return Inertia::render('Games/GamesView', [
            'games' => $games,
            'status' => session('status'),]);
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return back
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd($request->user(),User::all());
        //store all request to games 
        $game = Game::create($request->all());
        
        // return back();
        // return redirect(route('games.index'));
        return Inertia::location('/games');


    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
