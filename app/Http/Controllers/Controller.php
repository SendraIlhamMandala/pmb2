<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use mysqli;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    #function gethtmlpage

    public static function gethtmldata($width,$ttd){
        
        $tahun = Tahun::latest()->where('status', 'aktif')->get();
        $tahunselanjutnya = $tahun[0]->tahun+1;
        $userAuth = Auth::user();
        $html = "
                        <html lang='en' ><head></head><body style='size: a4;'>
                        <style>
                        @page {
                            size: auto;
                            margin: 8mm;
                        }
                        </style>
                        <table>
                        <tbody><tr>
                            <td width='{$width}%'>&nbsp;</td>
                            <td width='30%'>&nbsp;</td>
                            <td align='right'>TAHUN AKADEMIK: {$tahun[0]->tahun} / {$tahunselanjutnya}</td>
                        </tr>
                    </tbody></table> 
                    <br>
                    <table>
                        <tbody><tr>
                            <td width='40%'>&nbsp;</td>
                            <td width='15%' align='center'><img src='https://iili.io/JHPXrFf.png' style='width: 100px;'></td>
                            <td width='40%'>&nbsp;</td>
                        </tr>
                    </tbody></table>
                    <h3 style='text-align: center; font-family: times; '>UNIVERSITAS GARUT <br> Fakultas Ilmu Sosial dan Ilmu Politik</h3>
                    <p style='text-align: center; font-family: times; '>Jl. Cimanuk No.285A Tarogong Kidul 44151 Garut - 0262 2800221 <br> Homepage : <a href='http://fisip.uniga.ac.id'>www.fisip.uniga.ac.id</a> email: <a href=''>admin@fisip.uniga.ac.id</a> IG &amp; Twitter: @fisipuniga</p>
                    <hr>
                    <h3 style='text-align: center; font-family: times; '>FORMULIR PENDAFTARAN MAHASISWA BARU</h3>
                    <p align='center'>Kode Formulir</p>
                    <table>
                        <tbody><tr>
                            <td width='35%'>&nbsp;</td>
                            <td align='center'>
                                <input type='text' size='5'>
                            </td>
                            <td align='center'>
                                <input type='text' size='5'>
                            </td>
                            <td align='center'>
                                <input type='text' size='5'>
                            </td>
                            <td align='center'>
                                <input type='text' size='5'>
                            </td>
                            <td align='center'>
                                <input type='text' size='5'>
                            </td>
                            <td align='center'>
                                <input type='text' size='5'>
                            </td>
                            <td width='35%'>&nbsp;</td>
                        </tr>
                    </tbody></table>
                    <p align='center'>(Diisi oleh petugas PMB)</p>
                    <hr> 
                    <table style='text-align: justify-all;'>
                        <tbody><tr>
                            <td style='font-weight: bold;'>JALUR PENDAFTARAN</td> 
                            <td>:</td>
                            <td>{$userAuth->dataDaftar->jalur}</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold;'>SHIFT KELAS</td> 
                            <td>:</td>
                            <td>{$userAuth->dataDaftar->shift}</td>
                        </tr>
                        <tr>
                            <td style='font-weight: bold;'>STATUS PENDAFTARAN</td> 
                            <td>:</td>
                            <td>{$userAuth->dataDaftar->status}</td>
                        </tr>
                    </tbody></table>
                    <table style='text-align: justify-all;'>
                        <tbody><tr>
                            <td style='font-weight: bold;'>PILIHAN PROGRAM STUDI</td>
                            <td>
                                </td></tr><tr>
                                    <td></td>
                                    <td>1.</td>
                                    <td>{$userAuth->dataDaftar->program_studi}</td>
                                </tr>
                            
                        
                    </tbody></table> 
                    <hr>   
                        <h4 style='text-align: left; font-weight: bold;'>DATA DIRI CALON MAHASISWA BARU</h4>
                    <table style='text-align: justify-all;'>        
                        <tbody><tr>
                            <td>No Pendaftaran Online</td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->nim}</td>
                        </tr>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td> </td>
                            <td> : </td>
                            <td>".ucwords($userAuth->name)."</td>
                        </tr>
                        <tr>
                            <td>N I K </td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->dataPribadi->no_ktp}</td>
                        </tr>
                        <tr>
                            <td>Tempat &amp; Tgl. Lahir</td>
                            <td> </td>
                            <td> : </td>
                            <td>".ucwords($userAuth->dataPribadi->tempat_lahir).", {$userAuth->dataPribadi->tanggal_lahir}</td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->dataPribadi->agama}</td>            
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td> </td>
                            <td>:</td>
                            <td>{$userAuth->dataPribadi->jenis_kelamin}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> </td>
                            <td>:</td>
                            <td>{$userAuth->alamat->alamat}</td>
                        </tr>
                        <tr>
                            <td>Kelurahan</td>
                            <td></td>
                            <td>:</td>
                            <td>{$userAuth->alamat->kelurahan}</td>
                        </tr>
                        <tr>
                        <td>Kecamatan</td>
                        <td></td>
                            <td>:</td>
                            <td>{$userAuth->alamat->kecamatan}</td>
                        </tr>
                        <tr>
                        <td>Kabupaten</td>
                        <td></td>
                            <td>:</td>
                            <td>{$userAuth->alamat->kabupaten}</td>
                        </tr>
                        <tr>
                        <td>Provinsi</td>
                            <td></td>
                            <td>:</td>
                            <td>{$userAuth->alamat->provinsi}</td>
                        </tr>
                        <tr>
                            <td>No. Telp / HP</td>
                            <td> </td>
                            <td>:</td>
                            <td>{$userAuth->dataPribadi->no_hp}</td>
                        </tr>
                        <tr>
                            <td>Alamat Email Aktif</td>
                            <td> </td>
                            <td>:</td>
                            <td>{$userAuth->email}</td>
                        </tr>
                        <tr>
                            <td>Akun Media Sosial</td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                        <td>IG</td>
                        <td></td>
                            <td>:</td>
                            <td>{$userAuth->dataPribadi->ig}</td>
                        </tr>
                        <tr>
                        <td>Facebook</td>
                        <td></td>
                            <td>:</td>
                            <td>{$userAuth->dataPribadi->facebook}</td>
                        </tr>        
                    </tbody></table>
                    <hr>
                    <br>
                
                    <h4 style='text-align: left; font-weight: bold;'>DATA ASAL SEKOLAH CALON MAHASISWA BARU</h4>
                    <table style='text-align: justify-all;'>        
                        <tbody><tr>
                            <td>Asal Sekolah</td>
                            <td></td>
                            <td> : </td>
                            <td>{$userAuth->asalSekolah->nama_sekolah}</td>
                        </tr>
                        <tr>
                            <td>Jurusan</td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->asalSekolah->jurusan}</td>
                        </tr>
                        <tr>
                            <td>Thn. Lulus</td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->asalSekolah->tahun_lulus}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->asalSekolah->alamat_sekolah}</td>
                        </tr>
                        <tr>
                            <td>Nilai NEM</td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->asalSekolah->nilai_skhun}</td>
                        </tr>
                    </tbody></table>
                    
                        <hr>
                    <h4 style='text-align: left; font-weight: bold;'>DATA ORANG TUA/ WALI CALON MAHASISWA BARU</h4>
                    <table style='text-align: justify-all;'>        
                        <tbody><tr>
                            <td>Nama Ayah</td>
                            <td> </td>
                            <td> : </td>
                            <td>".ucwords($userAuth->orangtua->nama_ayah)."</td>
                        </tr>
                        <tr>
                            <td>N I K </td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->orangtua->ktp_ayah}</td>
                        </tr>
                        <tr>
                            <td>Tempat &amp; Tgl. Lahir</td>
                            <td> </td>
                            <td> : </td>
                            <td>".ucwords($userAuth->orangtua->tempat_lahir_ayah).", {$userAuth->orangtua->tanggal_lahir_ayah}</td>
                        </tr>
                        <tr>
                            <td>No. Telp/ Handphone</td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->orangtua->no_hp_ayah}</td>            
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td> </td>
                            <td>:</td>
                            <td>".ucwords($userAuth->orangtua->pekerjaan_ayah)."</td>
                        </tr>
                        <tr>
                            <td>Penghasilan</td>
                            <td> </td>
                            <td>:</td>
                            <td>{$userAuth->orangtua->penghasilan_ayah}</td>
                        </tr>
                        <tr>
                            <td>Nama Ibu</td>
                            <td> </td>
                            <td> : </td>
                            <td>".ucwords($userAuth->orangtua->nama_ibu)."</td>
                        </tr>
                        <tr>
                            <td>N I K </td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->orangtua->ktp_ibu}</td>
                        </tr>
                        <tr>
                            <td>Tempat &amp; Tgl. Lahir</td>
                            <td> </td>
                            <td> : </td>
                            <td>".ucwords($userAuth->orangtua->tempat_lahir_ibu).", {$userAuth->orangtua->tanggal_lahir_ibu}</td>
                        </tr>
                        <tr>
                            <td>No. Telp/ Handphone</td>
                            <td> </td>
                            <td> : </td>
                            <td>{$userAuth->orangtua->no_hp_ibu}</td>            
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td> </td>
                            <td>:</td>
                            <td>".ucwords($userAuth->orangtua->pekerjaan_ibu)."</td>
                        </tr>
                        <tr>
                            <td>Penghasilan</td>
                            <td> </td>
                            <td>:</td>
                            <td>{$userAuth->orangtua->penghasilan_ibu}</td>
                        </tr>        
                    </tbody></table>
                    <hr>
                    <h4 style='text-align: left; font-weight: bold;'>Mohon Informasi, darimana Saudara/i memperoleh informasi: Teman di FISIP UNIGA </h4>
                    <h4 style='font-weight: bold;'>DAFTAR CEKLIS KELENGKAPAN PERSYARATAN <br> (DIISI OLEH PETUGAS PENERIMA PENDAFTARAN MAHASISWA BARU) </h4>  
                    <hr>
                    <table style='text-align: justify-all;'>               
                        <tbody><tr>
                            <td><input type='text' size='5'></td>
                            <td>1. </td>
                            <td>Kelengkapan Isian Formulir Pendaftaran </td>
                        </tr>
                        <tr>
                            <td><input type='text' size='5'></td>
                            <td>2. </td>
                            <td>Copy STTB SMA/ SMK/ Sederajat yang dilegalisir/ Surat Keterangan Lulus </td>
                        </tr>
                        <tr>
                            <td><input type='text' size='5'></td>
                            <td>3. </td>
                            <td>Surat Keterangan Kelakuan Baik dari Sekolah/ Kepolisian </td>
                        </tr>
                        <tr>
                            <td><input type='text' size='5'></td>
                            <td>4. </td>
                            <td>Surat Keterangan Sehat Jasmani dan Bebas NARKOBA </td>
                        </tr>
                        <tr>
                            <td><input type='text' size='5'></td>
                            <td>5. </td>
                            <td>Copy Kartu Keluarga dan atau Copy KTP </td>
                        </tr>
                        <tr>
                            <td><input type='text' size='5'></td>
                            <td>6. </td>
                            <td>Pas Foto Berwarna 2 x 3 dan 3 x 4 masing-masing 4 lembar</td>
                        </tr>
                    </tbody
                    ></table>
                    
                    <p style='text-align: justify-all; page-break-before: always;'>Demikian formulir isian ini saya buat dengan sebenarnya, dan jika ditermia sebagai mahasiswa Fakultas Ilmu Sosial dan Ilmu Politik, saya bersedia untuk memenuhi dan mengikuti peraturan yang berlaku di Universitas Garut.</p>
                    <br>
                        <p align='center'>Garut,14 September 2023</p>
                    <br>
                    <table width='100%'>
                        <tbody><tr>
                            <td width='50%' align='center'> 
                                <p style='font-weight: bold;'>Petugas PMB,</p><br><br><br><br>
                                <hr width='{$ttd}%'>
                                <p>(nama jelas dan tanda tangan)</p>
                            </td> 
                            <td width='50%' align='center'> 
                                <p style='font-weight: bold;'>Calon Mahasiswa/ Orang Tua/ Wali,</p><br><br><br><br>
                                <hr width='{$ttd}%'>
                                <p>(nama jelas dan tanda tangan)</p>
                            </td>           
                        </tr>
                    </tbody></table>
                    
                                </body></html> 


        
        ";

        return $html;
    }

    public function gethtmlpage(): HttpResponse
    {

        $html = $this->gethtmldata(30, 30);

        return response($html, 200)->header('Content-Type', 'text/html');
    }

    public function print(): HttpResponse
    {

        $html = $this->gethtmldata(37, 80);


        return response($html."<script>window.print()</script>", 200)->header('Content-Type', 'text/html');
    }


    function cat()
    {

        // Create a new mysqli connection
        $conn = new mysqli("localhost", "root", "", "fisipol_cat");

        // Escape special characters in the input strings
        $name = $conn->real_escape_string('Asep_test 3');
        $npm = $conn->real_escape_string('4242');
        $password = md5($npm);
        $jurusan = $conn->real_escape_string('Ilmu Administrasi Negara');

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

        // foreach ($resultadmin as $key_admin => $value_admin) {
        //     foreach ($value_admin as $key => $value) {
        //         $results_admin[$key_admin][$key] = $value;
        //     };
        // }

        // $sorted = collect($results_admin)->sortBy([
        //     ['id', 'desc'],
        // ]);

        dd($result2['id'], $results, $name, $result_siswa_ikut_ujian2, $result_siswa, $result_siswa2['id']);
    }

    function createAdmin()
    {
       
        $user = Role::where('name', '=', 'admin')->first();
        if ($user === null) {
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'user']);
        }
        
        //create user admin

        try {
            
        
        $user = User::create([
            'name' => 'admin',
            'nim' => '1',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('asd'),
            'email_verified_at' => Date::now(),
        ]);
        $user->assignRole('admin');
        $user->nim = '1';
        $user->email_verified_at = Date::now();
        $user->save();
        } catch (\Throwable $th) {
            dd($th);
         }
        

        return Role::all();
    }

    function getAdmin()
    {
        $role =  \Spatie\Permission\Models\Role::all();
        $user = Auth()->user();
        // $user->assignRole('admin');
        // Role::create(['name' => 'user']);

        $user->syncRoles(['admin']);

        dd($user->roles->pluck('name'));
    }
}
