<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DataDaftar;
use App\Models\Tahun;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $users = User::latest()->first();
        
            $tahun = Tahun::latest()->where('status', 'aktif')->first();
            if ($tahun == null) {
                # code...
                return redirect()->back()->withErrors('maaf pendaftaran belum dibuka');
            }
            // dd($tahun);
        
            $userTahun = User::orderBy('created_at', 'desc')->with(['dataDaftar.tahun'])->whereHas('dataDaftar.tahun', function ($query) {
                $query->where('status', 'aktif');
            })->first();


        // dd($users->dataDaftar->tahun,$tahun,$tahun->no_utama+1);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        // dd($users->dataDaftar->tahun,$tahun,$users->dataDaftar->tahun == $tahun);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles(['user']);

        if (!empty($userTahun)) {

        $user->nim = $userTahun->nim+1;

        }else{
            $user->nim = $tahun->no_utama+1;
        }

        $data_daftar_list= [
            'shift' => '-',
            'jalur' => '-',
            'status' => '-',
            'program_studi' => '-',
            'user_id' => $user->id
        ];
        $data_daftar = new DataDaftar($data_daftar_list);
    
        $tahun->dataDaftars()->save($data_daftar);
        $user->dataDaftar()->save($data_daftar);
        $data_daftar->save();
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
