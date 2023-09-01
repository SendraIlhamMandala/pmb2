<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\AsalSekolah;
use App\Models\DataDaftar;
use App\Models\DataPribadi;
use App\Models\Orangtua;
use App\Models\Pindahan;
use App\Models\ProgramStudi;
use App\Models\Shift;
use App\Models\Tambahan;
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
            $user_array[$key]['password'] = $value->password;
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
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

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
        $validator = Validator::make($request->dataPribadi, [
            'no_ktp' => 'required|numeric',
            'nisn' => 'required|numeric',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'ig' => '',
            'facebook' => '',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);
        $validator2 = Validator::make($request->alamat, [
            'alamat' => 'required', 'kelurahan' => 'required', 'kecamatan' => 'required', 'kabupaten' => 'required', 'provinsi' => 'required', 'kodepos' => 'required',
        ]);

        $validator3 = Validator::make($request->sekolah, [
            'nama_sekolah' => 'required', 'alamat_sekolah' => 'required', 'tahun_lulus' => 'required',
            'ijazah' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'skhun' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'nilai_skhun' => 'required',
        ]);
        $validator4 = Validator::make($request->orangtua, [
            'nama_ayah' => 'required', 'nama_ibu' => 'required', 'ktp_ayah' => 'required', 'ktp_ibu' => 'required', 'tempat_lahir_ayah' => 'required', 'tempat_lahir_ibu' => 'required', 'tanggal_lahir_ayah' => 'required', 'tanggal_lahir_ibu' => 'required', 'no_hp_ayah' => 'required', 'no_hp_ibu' => 'required', 'pekerjaan_ayah' => 'required', 'pekerjaan_ibu' => 'required', 'penghasilan_ayah' => 'required', 'penghasilan_ibu' => 'required',
        ]);


        if ($validator->fails() || $validator2->fails() || $validator3->fails() || $validator4->fails()) {
            $errors = [];
            $validators = [$validator, $validator2, $validator3, $validator4];
            foreach ($validators as $validator) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
            return !empty($errors) ? back()->withErrors($errors) : null;
        }


        if (Auth()->user()->dataDaftar->status == 'Pindahan') {
            $validator5 = Validator::make($request->pindahan, [
                'perguruan_tinggi' => 'required', 'program_studi' => 'required', 'nomor_induk_mahasiswa' => 'required',
            ]);
            if ($validator5->fails()) {
                return back()->withErrors($validator5);
            }
        }
        $jaluruser = Auth()->user()->dataDaftar->jalur;

        $validJalur = ['Jalur ranking', 'Prestasi non akademik'];
        if (in_array($jaluruser, $validJalur)) {
            $validator6 = Validator::make($request->tambahan, [
                "isi_data" => 'required', "foto_bukti" => 'required|image|mimes:jpeg,png,jpg|max:4096',]);
            if ($validator6->fails()) {
                return back()->withErrors($validator6);
            }
        }


        // dd($request->all(),$request->alamat);

        $user = $id;

        $dataPribadi = $request->dataPribadi;
        $alamat = $request->alamat;
        $sekolah = $request->sekolah;
        $orangtua = $request->orangtua;
        $pindahan = $request->pindahan;
        $tambahan = $request->tambahan;

        $fotopribadi = $dataPribadi['foto'];
        $fotopribadi_name = date('Y-m-d') . $fotopribadi->getClientOriginalName();
        $foto_path = 'avatar/' . $fotopribadi_name;
        Storage::disk('public')->put($foto_path, file_get_contents($fotopribadi));
        $dataPribadi['foto'] =  $fotopribadi_name;

        $skhun = $sekolah['skhun'];
        $skhun_name = date('Y-m-d') . $skhun->getClientOriginalName();
        $skhun_path = 'skhun/' . $skhun_name;
        Storage::disk('public')->put($skhun_path, file_get_contents($skhun));
        $sekolah['skhun'] =  $skhun_name;

        $ijazah = $sekolah['ijazah'];
        $ijazah_name = date('Y-m-d') . $ijazah->getClientOriginalName();
        $ijazah_path = 'ijazah/' . $ijazah_name;
        Storage::disk('public')->put($ijazah_path, file_get_contents($ijazah));
        $sekolah['ijazah'] =  $ijazah_name;

        if (in_array($jaluruser, $validJalur)) {

        $foto_bukti = $tambahan['foto_bukti'];
        $foto_bukti_name = date('Y-m-d') . $foto_bukti->getClientOriginalName();
        $foto_bukti_path = 'foto_bukti/' . $foto_bukti_name;
        Storage::disk('public')->put($foto_bukti_path, file_get_contents($foto_bukti));
        $tambahan['foto_bukti'] =  $foto_bukti_name;
        $tambahan_input = new Tambahan($tambahan);
        $user->tambahan()->save($tambahan_input);
        }
        $sekolah_input = new AsalSekolah($sekolah);
        $dataPribadi_input = new DataPribadi($dataPribadi);
        $alamat_input = new Alamat($alamat);
        $orangtua_input = new Orangtua($orangtua);
        $pindahan_input = new Pindahan($pindahan);
        $user->dataPribadi()->save($dataPribadi_input);
        $user->asalSekolah()->save($sekolah_input);
        $user->alamat()->save($alamat_input);
        $user->orangtua()->save($orangtua_input);
        if ($user->dataDaftar->status == 'Pindahan') {
            $user->pindahan()->save($pindahan_input);
        }
        $user->done_setup = 'done';
        $user->save();
        return redirect(route('usercek'));
    }

    //set data jalur
    public function setDataJalur(Request $request, User $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'shift' => 'required',
            'jalur' => 'required',
            'program_studi' => 'required',

        ], [
            'required' => ' Harap pilih :attribute .'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = $id;
        $user->dataDaftar->status = $request->status;
        $user->dataDaftar->shift = $request->shift;
        $user->dataDaftar->jalur = $request->jalur;
        $user->dataDaftar->program_studi = $request->program_studi;
        // dd($request->all(),$user->dataDaftar,$user);
        $user->done_setup = 'pribadi';
        $user->dataDaftar->save();
        $user->save();
        return redirect(route('user.data-pribadi'));
    }


    //showDataPribadi
    public function dataPribadi()
    {
        if (Auth()->user()->done_setup == 'not_done') {
            return redirect(route('user.data-jalur'));
        } elseif (Auth()->user()->done_setup == 'done') {
            return redirect(route('user-dashboard'));
        }
        $user = Auth()->user();
        $user->dataDaftar;
        return inertia('User/UserDataPribadi', [
            'user' => $user
        ]);
    }

    public function dataJalur()
    {
        if (Auth()->user()->done_setup == 'pribadi') {
            return redirect(route('user.data-pribadi'));
        } elseif (Auth()->user()->done_setup == 'done') {
            return redirect(route('user-dashboard'));
        }

        $user = Auth()->user();
        $shifts = Shift::all();
        $shifts->load('jalurDaftars');
        $prodi = ProgramStudi::all();
        return inertia('User/UserDataJalur', [
            'user' => $user,
            'shifts' => $shifts,
            'prodi' => $prodi
        ]);
    }
}
