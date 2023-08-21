<?php

namespace App\Http\Controllers;

use App\Models\User;
use ArrayObject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //user view
        $users = User::all();
        $user_array = $users->toArray();
        foreach ($users as $key => $value) {
            $arr_val = $value->toArray();
            $user_array[$key]['password']=$value->password; 

        }
        return Inertia::render('Users/UsersView', [
            'users' => $users,
            'usersWithPassword' => $user_array,
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
        //store request to user
        $user = User::create($request->all());
        return redirect(route('users.index'));

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
