<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\AsalSekolah;
use App\Models\Biaya;
use App\Models\DataDaftar;
use App\Models\DataPribadi;
use App\Models\Faktur;
use App\Models\JalurDaftar;
use App\Models\Orangtua;
use App\Models\Pekerjaan;
use App\Models\Pindahan;
use App\Models\ProgramStudi;
use App\Models\Shift;
use App\Models\Tahun;
use App\Models\Tambahan;
use App\Models\User;
use App\Models\Voucher;
use ArrayObject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\Ssr\Response as SsrResponse;
use mysqli;

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

    public function lihatuser(User $id)
    {

        $id->load('dataDaftar');
        $id->load('dataPribadi');
        $id->load('alamat');
        $id->load('asalSekolah');
        $id->load('orangtua');
        $id->load('tambahan');
        $id->load('pindahan');
        $id->load('pekerjaan');
        return Inertia::render('Users/UserShow', [
            'user' => $id,
        ]);
    }

    public function lihatuser2(User $id)
    {

        $id->load('dataDaftar');
        $id->load('dataPribadi');
        $id->load('alamat');
        $id->load('asalSekolah');
        $id->load('orangtua');
        $id->load('tambahan');
        $id->load('pindahan');
        $id->load('pekerjaan');
        return Inertia::render('Users/UserShow2', [
            'user' => $id,
        ]);
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
        ], [
            'required' => ' Harap masukkan :attribute .'
        ]);
        $validator2 = Validator::make($request->alamat, [
            'alamat' => 'required', 'kelurahan' => 'required', 'kecamatan' => 'required', 'kabupaten' => 'required', 'provinsi' => 'required', 'kodepos' => 'required',
        ], [
            'required' => ' Harap masukkan :attribute .'
        ]);

        $validator3 = Validator::make($request->sekolah, [
            'nama_sekolah' => 'required', 'alamat_sekolah' => 'required', 'tahun_lulus' => 'required',
            'ijazah' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'skhun' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'nilai_skhun' => 'required',
        ], [
            'required' => ' Harap masukkan :attribute .'
        ]);
        $validator4 = Validator::make($request->orangtua, [
            'nama_ayah' => 'required', 'nama_ibu' => 'required', 'ktp_ayah' => 'required', 'ktp_ibu' => 'required', 'tempat_lahir_ayah' => 'required', 'tempat_lahir_ibu' => 'required', 'tanggal_lahir_ayah' => 'required', 'tanggal_lahir_ibu' => 'required', 'no_hp_ayah' => 'required', 'no_hp_ibu' => 'required', 'pekerjaan_ayah' => 'required', 'pekerjaan_ibu' => 'required', 'penghasilan_ayah' => 'required', 'penghasilan_ibu' => 'required',
        ], [
            'required' => ' Harap masukkan :attribute .'
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
            ], [
                'required' => ' Harap masukkan :attribute .'
            ]);
            if ($validator5->fails()) {
                return back()->withErrors($validator5);
            }
        }
        $jaluruser = Auth()->user()->dataDaftar->jalur;

        $validJalur = ['Jalur ranking', 'Prestasi non akademik'];
        if (in_array($jaluruser, $validJalur)) {
            $validator6 = Validator::make($request->tambahan, [
                "isi_data" => 'required', "foto_bukti" => 'required|image|mimes:jpeg,png,jpg|max:4096',
                "pdf" => 'required|mimes:pdf|max:4096',
                "survey" => 'required',
            ], [
                'required' => ' Harap masukkan :attribute .'
            ]);
            if ($validator6->fails()) {
                return back()->withErrors($validator6);
            }
        }

        if (Auth()->user()->dataDaftar->jalur == 'Undangan') {
            $validator6 = Validator::make($request->tambahan, [
                "isi_data" => 'required',
                "foto_bukti" => 'required|image|mimes:jpeg,png,jpg|max:4096',
            ], [
                'required' => ' Harap masukkan :attribute .'
            ]);
            if ($validator6->fails()) {
                return back()->withErrors($validator6);
            }
        }

        if (Auth()->user()->dataDaftar->shift == 'Hybrid') {
            $validator7 = Validator::make($request->pekerjaan, [
                "nama_pekerjaan" => 'required',
                "nama_instansi" => 'required',
            ], [
                'required' => ' Harap masukkan :attribute .'
            ]);
            if ($validator7->fails()) {
                return back()->withErrors($validator7);
            }
        }

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


            $pdf = $tambahan['pdf'];
            $pdf_name = date('Y-m-d') . $pdf->getClientOriginalName();
            $pdf_path = 'pdf/' . $pdf_name;
            Storage::disk('public')->put($pdf_path, file_get_contents($pdf));
            $tambahan['pdf'] =  $pdf_name;


            $tambahan_input = new Tambahan($tambahan);

            $user->tambahan()->save($tambahan_input);
        }

        if (Auth()->user()->dataDaftar->jalur == 'Undangan') {

            $foto_bukti = $tambahan['foto_bukti'];
            $foto_bukti_name = date('Y-m-d') . $foto_bukti->getClientOriginalName();
            $foto_bukti_path = 'foto_bukti/' . $foto_bukti_name;
            Storage::disk('public')->put($foto_bukti_path, file_get_contents($foto_bukti));
            $tambahan['foto_bukti'] =  $foto_bukti_name;


            $tambahan_input = new Tambahan($tambahan);

            $user->tambahan()->save($tambahan_input);
        }

        if (Auth()->user()->dataDaftar->shift == 'Hybrid') {

            $pekerjaan_input = new Pekerjaan($request->pekerjaan);

            $user->pekerjaan()->save($pekerjaan_input);
        }

        $tambahan_input = new Tambahan($tambahan);

        $user->tambahan()->save($tambahan_input);

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
        $user->status = 'menunggu verifikasi';
        $user->save();
        return redirect(route('dashboard'));
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
        if (JalurDaftar::where('name', $request->jalur)->first()->test) {
            $user->done_setup = 'pembayaran';
        }

        $user->dataDaftar->save();
        $user->save();
        return redirect(route('user.data-pribadi'));
    }

    public function updateDataJalur(Request $request, User $user): RedirectResponse
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

        $user->dataDaftar()->update($request->all());

        $user->done_setup = 'pribadi';
        if (JalurDaftar::where('name', $request->jalur)->first()->test) {
            $user->done_setup = 'pembayaran';
        }
        $user->dataDaftar->save();
        $user->save();

        return redirect(route('user.data-pribadi'));
    }


    //showDataPribadi
    public function dataPribadi()
    {


        $conn = new mysqli("localhost", "root", "", "fisipol_cat");

        $id = Auth()->user();

        // Escape special characters in the input strings
        $name = $conn->real_escape_string($id->name);
        $npm = $conn->real_escape_string($id->nim);
        $password = md5($npm);
        $jurusan = $conn->real_escape_string($id->dataDaftar->program_studi);

        $sql_select_siswa = "SELECT * FROM m_siswa WHERE nim = '{$npm}'";
        $result_siswa = $conn->query($sql_select_siswa);
        $result_siswa_data = $result_siswa->fetch_assoc();

        if (isset($result_siswa_data)) {
            # code...
            $sql_select_user_ikut_ujian = "SELECT * FROM tr_ikut_ujian WHERE id_user = '{$result_siswa_data['id']}'";
            $result_siswa_ikut_ujian = $conn->query($sql_select_user_ikut_ujian);
            $result_siswa_ikut_ujian_data = $result_siswa_ikut_ujian->fetch_assoc();

            // get latest data from  tr_guru_tes table
            $sql_select_guru_tes = "SELECT * FROM tr_guru_tes ORDER BY id DESC LIMIT 1";
            $result_guru_tes = $conn->query($sql_select_guru_tes);
            $result_guru_tes_data = $result_guru_tes->fetch_assoc();
        } else {

            $result_siswa_ikut_ujian_data = '';
        }

        if (Auth()->user()->done_setup == 'pembayaran') {
            return redirect(route('HalamanVerifikasiPembayaran'));
        }

        if (Auth()->user()->done_setup == 'sedang mengikuti test') {
            return redirect(route('diterimaVerifikasi'));
        }

        if (Auth()->user()->done_setup == 'menunggu verifikasi') {
            return redirect(route('tungguVerifikasiPembayaran'));
        }

        if (Auth()->user()->done_setup == 'not_done') {
            return redirect(route('user.data-jalur'));
        } elseif (Auth()->user()->done_setup == 'done') {
            return redirect(route('tungguVerifikasi'));
        }
        $user = Auth()->user();
        $user->dataDaftar;
        return inertia('User/UserDataPribadi', [
            'user' => $user,
            'cat' => $result_siswa_ikut_ujian_data
        ]);
    }

    public function dataJalur()
    {
        $redirectRoutes = [
            'pembayaran' => 'HalamanVerifikasiPembayaran',
            'sedang mengikuti test' => 'HalamanVerifikasiPembayaran',
            'menunggu verifikasi' => 'HalamanVerifikasiPembayaran',
            'selesai test' => 'user.data-pribadi',
            'pribadi' => 'user.data-pribadi',
            'done' => 'welcome',
            'sedang mengikuti test' => 'diterimaVerifikasi',
        ];

        $doneSetup = Auth()->user()->done_setup;

        if (isset($redirectRoutes[$doneSetup])) {
            return redirect(route($redirectRoutes[$doneSetup]));
        } else {
            // Handle the case when $doneSetup is not found in the redirectRoutes array
            // You can redirect to a default page or show an error message

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

    public function dataJalurEdit(User $user)
    {

        $shifts = Shift::with('jalurDaftars')->get();
        $prodi = ProgramStudi::all();
        return inertia('User/UserDataJalurEdit', [
            'user' => $user,
            'shifts' => $shifts,
            'prodi' => $prodi
        ]);
    }

    //function verifikasiPembayaran
    public function halamanVerifikasiPembayaran()
    {


        if (Auth()->user()->done_setup != 'pembayaran') {
            return redirect(route('user.data-pribadi'));
        }
        if (Auth()->user()->done_setup == 'menunggu verifikasi') {
            return redirect(route('tungguVerifikasiPembayaran'));
        }


        if (Auth()->user()->done_setup == 'done') {
            return redirect(route('welcome'));
        }
        $user = Auth()->user();
        $shifts = Shift::all();
        $shifts->load('jalurDaftars');
        $user->dataDaftar;
        $prodi = ProgramStudi::all();
        $biaya = Biaya::all();
        // dd($user, $shifts, $prodi, $biaya);
        return inertia(
            'User/VerifikasiPembayaran',
            [
                'user' => $user,
                'shifts' => $shifts,
                'prodi' => $prodi,
                'biaya' => $biaya
            ]
        );
    }

    public function uploadVerifikasiPembayaran(Request $request, User $id): RedirectResponse
    {

        $validator = Validator::make($request->all(), [

            'no_rekening' => 'required',
            'tanggal_bayar' => 'required',
            'jumlah_bayar' => 'required',
            'foto_bukti' => 'required',

        ], [
            'required' => ' Harap masukkan :attribute .'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data_faktur_baru = $request->all();

        if (Voucher::where('code', $request->kode)->first()) {
            $data_faktur_baru['pakai_voucher'] = 1;
        }

        unset($data_faktur_baru['kode']);
        unset($data_faktur_baru['name']);
        unset($data_faktur_baru['nim']);
        // $data_faktur_baru['pakai_voucher'] = 0;
        // dd($request->all(), $data_faktur_baru);

        $foto_bukti = $data_faktur_baru['foto_bukti'];
        $foto_bukti_name = date('Y-m-d') . $foto_bukti->getClientOriginalName();
        $foto_bukti_path = 'foto_bukti/' . $foto_bukti_name;
        Storage::disk('public')->put($foto_bukti_path, file_get_contents($foto_bukti));
        $data_faktur_baru['foto_bukti'] =  $foto_bukti_name;



        $faktur_data = new Faktur($data_faktur_baru);
        $id->done_setup = 'menunggu verifikasi';
        $id->dataPribadi()->save($faktur_data);
        $id->save();
        return redirect(route('tungguVerifikasiPembayaran'));
    }

    public function verifikasiVoucher(Request $request): RedirectResponse
    {
        if (Voucher::where('code', $request->kode)->first()) {
            return redirect()->back()->withErrors(['success' => 'Voucher tersedia']);
        } else {
            return redirect()->back()->withErrors(['kode' => 'Kode voucher tidak ditemukan']);
        }
    }

    public function tungguVerifikasiPembayaran()
    {
        // if (!Auth()->user()->faktur) {
        //     return redirect('/');
        // }
        if (Auth()->user()->faktur && Auth()->user()->faktur->validasi == 1) {
            if (Auth()->user()->done_setup != 'done') {
                return redirect()->route('diterimaVerifikasi');
            }
        } else if (Auth()->user()->faktur && Auth()->user()->faktur->validasi === 2) {
                return redirect()->route('ditolakVerifikasi');
        }

        $user = Auth()->user();
        return inertia('User/UserTunggu', [
            'user' => $user,
        ]);

        return inertia('User/tungguVerifikasiPembayaran');
    }

    public function diterimaVerifikasi()
    {

        $conn = new mysqli("localhost", "root", "", "fisipol_cat");

        $id = Auth()->user();

        // Escape special characters in the input strings
        $name = $conn->real_escape_string($id->name);
        $npm = $conn->real_escape_string($id->nim);
        $password = md5($npm);
        $jurusan = $conn->real_escape_string($id->dataDaftar->program_studi);

        $sql_select_siswa = "SELECT * FROM m_siswa WHERE nim = '{$npm}'";
        $result_siswa = $conn->query($sql_select_siswa);
        $result_siswa_data = $result_siswa->fetch_assoc();

        $sql_select_user_ikut_ujian = "SELECT * FROM tr_ikut_ujian WHERE id_user = '{$result_siswa_data['id']}'";
        $result_siswa_ikut_ujian = $conn->query($sql_select_user_ikut_ujian);
        $result_siswa_ikut_ujian_data = $result_siswa_ikut_ujian->fetch_assoc();

        // get latest data from  tr_guru_tes table
        $sql_select_guru_tes = "SELECT * FROM tr_guru_tes ORDER BY id DESC LIMIT 1";
        $result_guru_tes = $conn->query($sql_select_guru_tes);
        $result_guru_tes_data = $result_guru_tes->fetch_assoc();


        if ($result_siswa_ikut_ujian_data !== null) {

            $user = User::find($id->id);
            $user->done_setup = 'pribadi';
            $user->save();

            return redirect(route('user.data-pribadi'));
        }

        if (!Auth()->user()->faktur) {
            return redirect('/');
        }
        if (Auth()->user()->faktur && Auth()->user()->faktur->validasi === 2) {
            return redirect(route('ditolakVerifikasi'));
        }

        $user = Auth()->user();
        return inertia('User/UserDiterima', [
            'user' => $user,
            'token' => $result_guru_tes_data['token']
        ]);
    }

    
    public function ditolakVerifikasi()
    {

        return inertia('User/UserDitolak', [
            'user' => Auth()->user(),
        ]);

    }

    public function verifikasiPembayaranUserIndex(): Response
    {

        $users4 = User::with(['dataDaftar.tahun', 'faktur'])
            ->orderBy('created_at', 'desc')
            ->whereHas('dataDaftar.tahun', function ($query) {
                $query->where('status', 'aktif');
            })
            ->where('done_setup', 'menunggu verifikasi')
            ->get();


        //user_verified is all user that done_setup = 'sedang mengikuti test';
        $user_verified = User::with(['dataDaftar.tahun', 'faktur'])
            ->orderBy('created_at', 'desc')
            ->whereHas('dataDaftar.tahun', function ($query) {
                $query->where('status', 'aktif');
            })
            ->where('done_setup', 'sedang mengikuti test')
            ->get();


        return inertia(
            'VerifikasiPembayarans/VerifikasiPembayaransView',
            [
                'users' => $users4,
                'user_verified' => $user_verified

            ]
        );
    }

    //function verifikasiPembayaranUser
    public function verifikasiPembayaranUser(User $id, Request $request)
    {


        // dd($id->dataDaftar->program_studi);
        // Create a new mysqli connection
        $conn = new mysqli("localhost", "root", "", "fisipol_cat");

        // Escape special characters in the input strings
        $name = $conn->real_escape_string($id->name);
        $npm = $conn->real_escape_string($id->nim);
        $password = md5($npm);
        $jurusan = $conn->real_escape_string($id->dataDaftar->program_studi);

        // Insert a new record into the m_siswa table
        $sql_add_siswa = "INSERT INTO m_siswa VALUES (null, '{$name}', '{$npm}', '{$jurusan}')";
        $conn->query($sql_add_siswa);


        // Retrieve the last 10 records from the m_siswa table
        $sql = "SELECT * FROM m_siswa ORDER BY id DESC LIMIT 10";
        $result = $conn->query($sql);
        $result2 = $result->fetch_assoc();
        $results = [];

        $sql_add_siswa_to_m_admin = "INSERT INTO m_admin VALUES (null, '{$npm}', '{$password}', 'siswa' , '{$result2['id']}')";
        $conn->query($sql_add_siswa_to_m_admin);

        // $sqladmin = "SELECT * FROM m_admin ORDER BY id DESC LIMIT 10";
        $sql_siswa = "SELECT * FROM m_siswa Where nim = '{$npm}'";
        $result_siswa = $conn->query($sql_siswa);
        $result_siswa2 = $result_siswa->fetch_assoc();
        $results_siswa = [];
        $sql_get_user_ikut_ujian = "select * from tr_ikut_ujian where id_user='{$result_siswa2['id']}'";
        $result_siswa_ikut_ujian = $conn->query($sql_get_user_ikut_ujian);
        $result_siswa_ikut_ujian2 = $result_siswa_ikut_ujian->fetch_assoc();
        // Convert the result set into an associative array
        foreach ($result as $key_1 => $value_1) {
            foreach ($value_1 as $key => $value) {
                $results[$key_1][$key] = $value;
            };
        };


        $validasiValues = [
            'terima' => 1,
            'tolak' => 2,
        ];


        $id->faktur->validasi = $validasiValues[$request->verifikasi] ?? 0;

        if ($validasiValues[$request->verifikasi] == 1) {
            $id->done_setup = 'sedang mengikuti test';
        } else if ($validasiValues[$request->verifikasi] == 2) {
            $id->done_setup = 'menunggu verifikasi';
            $id->status = 'pembayaran ditolak';
        } else {
            $id->done_setup = 'menunggu verifikasi';
        }
        $id->faktur->save();
        $id->save();


        $data = [
            'no-reply' => 'noreply@fisip.uniga.ac.id',
            'name'    => $id->name,
            'email'    => $id->email,
        ];

        if ($request->verifikasi == 'terima') {
            Mail::send(
                'vendor.notifications.emailverifypembayaran',
                ['data' => $data],
                function ($message) use ($data) {
                    $message
                        ->from($data['no-reply'])
                        ->to($data['email'])->subject('Verifikasi pembayaran PMB diterima');
                }
            );
        } else if ($request->verifikasi == 'tolak') {
            Mail::send(
                'vendor.notifications.emailverifypembayaran',
                ['data' => $data],
                function ($message) use ($data) {
                    $message
                        ->from($data['no-reply'])
                        ->to($data['email'])->subject('Verifikasi pembayaran PMB ditolak');
                }
            );
        }


        return Inertia::location('/dashboard');
    }


    public function tungguVerifikasi()
    {
        if (Auth()->user()->status == 'sudah' || Auth()->user()->status == 'tolak') {
            return redirect('/verifikasi-user-selesai');
        }

        $user = Auth()->user();
        return inertia('User/UserTungguVerifikasi', [
            'user' => $user,
        ]);
    }

    public function verifikasiSelesai()
    {
        if (Auth()->user()->status != 'sudah') {
            return Auth()->user()->status  == 'tolak' ? 
            redirect(route('ditolakVerifikasi')) : 'belum selesai daftar';
        }

        $user = Auth()->user();
        return inertia('User/UserVerifikasiSelesai', [
            'user' => $user,
        ]);
    }

    public function verifikasiUserShow(): Response
    {

        $users_belum = User::with(['dataDaftar.tahun', 'faktur', 'asalSekolah'])
            ->orderBy('created_at', 'desc')
            ->whereHas('dataDaftar.tahun', function ($query) {
                $query->where('status', 'aktif');
            })
            ->where('status', 'menunggu verifikasi')
            ->get();


        $users_sudah = User::with(['dataDaftar.tahun', 'faktur'])
            ->orderBy('created_at', 'desc')
            ->whereHas('dataDaftar.tahun', function ($query) {
                $query->where('status', 'aktif');
            })
            ->where('status', 'sudah')
            ->get();



        return inertia(
            'Users/VerifikasiUser',
            [
                'users' => $users_belum,
                'users_sudah' => $users_sudah,

            ]
        );
    }

    public function verifikasiUser($data)
    {
        $status = explode(',', $data);
        $user = User::find($data);

        if ($status[1] == 'terima') {
            $user->status = 'sudah';
            $user->save();
        } elseif ($status[1] == 'tolak') {
            $user->status = 'tolak';
            $user->save();
        }

        return redirect(route('dashboard'));
    }

    public function userAll()
    {
        //return latest tahun 

        $tahuns = Tahun::latest()->get();

        $prevTahun = null;
        $filteredTahuns = [];
        foreach ($tahuns as $tahun) {
            if ($prevTahun !== null && $tahun->tahun == $prevTahun) {
                continue;
            }
            $filteredTahuns[] = $tahun;
            $prevTahun = $tahun->tahun;
        }
        // dd($filteredTahuns);


        return Inertia::render('Users/UsersViewAll', [
            'tahuns' => $tahuns,
            'filteredTahuns' => $filteredTahuns

        ]);
    }

    public function userTahun($id)
    {
        //return latest tahun 
        $tahun = Tahun::find($id);

        //get all user where tahun == $tahun->tahun and gelombang == $tahun->gelombang
        $users = User::with(['dataDaftar.tahun', 'faktur'])->whereHas('dataDaftar.tahun', function ($query) use ($tahun) {
            $query->where('tahun', $tahun->tahun);
            $query->where('gelombang', $tahun->gelombang);
        })->orderBy('id', 'desc')->get();

        $users->load('asalSekolah');
        $users->load('dataDaftar');
    
        return Inertia::render('Users/UsersViewTahun', [
            'users' => $users,
            'tahun' => $tahun

        ]);
    }
}
