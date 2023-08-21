<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
     
    use Illuminate\Http\RedirectResponse;

    use Inertia\Response;
    
    use Illuminate\Support\Facades\DB;
    use Inertia\Inertia;
    use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
  
        /**
         * Display a listing of the resource.
         */
        public function index():Response
        {
            
        $roles = Role::orderBy('created_at', 'desc')->get();
    
            return Inertia::render('Roles/RolesView', [
                'roles' => $roles,
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
        public function store(Request $request): RedirectResponse
        {
            // dd($request);
      
            
            $role = Role::create(['name' => $request->name]);
            
            // return back();
            return redirect(route('roles.index'));
            // return Inertia::location('/games');
    
    
        }
    
        /**
         * Display the specified resource.
         */
        public function show(Game $game)
        {
            //return response game
            return response($game, 200);
        }
    
        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Role $role ): Response
        {
            // dd($role);
            //edit page
            return Inertia::render('Roles/RoleEdit', [
                'role' => $role
            ]);
    
        }
    
        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Role $role): RedirectResponse
        {
            //update game
            $role->update($request->all());
            return redirect(route('roles.index'));
    
        }
    
        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Game $game): RedirectResponse
        {
            //delete game
            $game->delete();
            return redirect(route('games.index'));
    
        }
    
        public function deleteOne(Role $id): RedirectResponse
        {
            $id->delete();
            return redirect(route('roles.index'));
      
        }
    
        public function deleteMultiple($id): RedirectResponse
        {
            $roles = [];
            $ids = json_decode($id);
            foreach ($ids as $key => $value_id) {
                Role::find($value_id)->delete();
            }
            
            return redirect(route('roles.index'));
            
        }
    
    }
    