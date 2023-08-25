<?php

namespace App\Http\Controllers;

use App\Models\DataPribadi;
use App\Models\User;
use ArrayObject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',

        ]);
        if ($validator->fails()) {return back()->withErrors($validator);}

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
        // edit user
        $user = User::find($id);
        return Inertia::render('Users/UserEdit', [
            'user' => $user,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        // dd($request->all(), $user);

        //update user
        $user->update($request->all());
        return redirect(route('users.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //setDataPribadi
    public function setDataPribadi(Request $request, User $id): RedirectResponse
    {        
        dd($request->all(),$request->alamat);
        $validator = Validator::make($request->all(), [
            'no_ktp' => 'required|numeric',
            'nisn' => 'required|numeric',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'ig' => '',
            'facebook' => '',
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);
        if ($validator->fails()) {return back()->withErrors($validator);}

        $user = $id;
        $request_without_foto = $request->except('avatar');
        unset($request_without_foto['foto']);

        $foto = $request->file('avatar');
        $foto_name = date('Y-m-d').$foto->getClientOriginalName();
        $path = 'avatar/'.$foto_name; 
        Storage::disk('public')->put($path, file_get_contents($foto));


        $request_without_foto['foto'] = $foto_name;
        $dataPribadi = new DataPribadi($request_without_foto);
        $user->dataPribadi()->save($dataPribadi);
        $user->done_setup = 'jalur';
        $user->save();
        return redirect(route('user.data-jalur'));
    }

    //showDataPribadi
    public function dataPribadi()
    {
        if (Auth()->user()->done_setup == 'jalur') {
            return redirect(route('user.data-jalur'));
        }
        $user = Auth()->user();
        return inertia('User/UserDataPribadi', [
            'user' => $user
        ]);
    }

    public function dataJalur()
    {
        if (Auth()->user()->done_setup == 'not_done') {
            return redirect(route('user.data-pribadi'));
        }
        
        $user = Auth()->user();
        return inertia('User/UserDataJalur', [
            'user' => $user
        ]);
    }
}
