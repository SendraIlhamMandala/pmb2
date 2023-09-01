<?php

namespace Database\Seeders;

use App\Models\Alamat;
use App\Models\AsalSekolah;
use App\Models\DataDaftar;
use App\Models\DataPribadi;
use App\Models\Orangtua;
use App\Models\Tahun;
use App\Models\User;
use Faker\Core\Number;
use Faker\Factory;
use FFI;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Testing\Fakes\Fake;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $users1 = User::latest()->first();
        $usersnim = $users1->nim;
        
        for ($i=0; $i < 20 ; $i++) { 
            $users = User::latest()->first();
            $usersnim ++;



        $user = new User();


        $user->name = Factory::create()->name;
        //random faker email
        $user->email =  Factory::create()->unique()->safeEmail;
        $user->password =  bcrypt('a');
        $user->email_verified_at =  now();
        //nim + random number
        $user->nim =  '202430000' + Factory::create()->numberBetween(200, 1000);
        $user->remember_token = Str::random(10);
        $user->done_setup = 'done';
        $user->created_at = now();
        $user->updated_at = now();
        $user->status = 'belum selesai pendaftaran';
        $user->save();
        $user->assignRole('user');

        $tahun = Tahun::latest()->where('status', 'aktif')->first();


        if ($users->dataDaftar->tahun == $tahun) {

            $user->nim = $usersnim;
        } else {

            $user->nim = $tahun->no_utama +1;
        }


        $data_daftar_list = [
            'shift' => 'shift' . rand(1, 2),
            'jalur' => 'jalur' . rand(1, 3),
            'status' => 'belum selesai pendaftaran',
            'program_studi' => 'prodi' . rand(1, 3),
            'user_id' => $user->id
        ];
        $data_daftar = new DataDaftar($data_daftar_list);
        $tahun->dataDaftar()->save($data_daftar);
        $user->dataDaftar()->save($data_daftar);
        $data_daftar->save();
        $user->save();

        $user->dataPribadi()->save(new DataPribadi([
            'user_id' => $user->id,
            'no_ktp' => Factory::create()->unique()->numberBetween(1000, 9999),
            'nisn' => Factory::create()->numberBetween(1000, 9999),
            'tempat_lahir' => Factory::create()->city,
            'tanggal_lahir' => Factory::create()->date,
            'jenis_kelamin' => Factory::create()->numberBetween(0, 1) ? 'Laki - Laki' : 'Perempuan',
            'agama' => Factory::create()->numberBetween(1, 2) ? 'Islam' : 'Kristen',
            'ig' => Factory::create()->username,
            'facebook' => Factory::create()->username,
            'foto' => "2023-08-31test.jpg",
            'no_hp' => Factory::create()->numberBetween(1000000000, 9999999999),
            'created_at' => Factory::create()->date,
            'updated_at' => Factory::create()->date,
        ]));
        $user->asalSekolah()->save(new AsalSekolah([
            'user_id' => $user->id,
            'nama_sekolah' => 'SMA' . Factory::create()->city,
            'alamat_sekolah' => Factory::create()->city,
            'tahun_lulus' => Factory::create()->year,
            'jurusan' => Factory::create()->numberBetween(0, 1) ? 'IPA' : 'IPS',
            'nilai_skhun' => Factory::create()->numberBetween(0, 100),
            'skhun' => "2023-08-31test.jpg",
            'ijazah' => "2023-08-31test.jpg",
            'created_at' => Factory::create()->date,
            'updated_at' => Factory::create()->date,
        ]));
        $user->alamat()->save(new Alamat([
            'user_id' => $user->id,
            'alamat' => Factory::create()->city,
            'kelurahan' => 'lurah ' . Factory::create()->city,
            'kecamatan' => 'camat ' . Factory::create()->city,
            'kabupaten' => 'kab .' . Factory::create()->city,
            'provinsi' => 'provinsi ' . Factory::create()->city,
            'kodepos' => Factory::create()->numberBetween(10000, 99999),
            'created_at' => Factory::create()->date,
            'updated_at' => Factory::create()->date,
        ]));
        $user->orangtua()->save(new Orangtua([
            'user_id' => $user->id,
            'nama_ayah' => Factory::create()->name,
            'ktp_ayah' => Factory::create()->numberBetween(1000, 9999),
            'tempat_lahir_ayah' => Factory::create()->city,
            'tanggal_lahir_ayah' => Factory::create()->date,
            'no_hp_ayah' => Factory::create()->numberBetween(1000000000, 9999999999),
            'pekerjaan_ayah' => Factory::create()->randomElement(['Wiraswasta', 'PNS', 'lainnya']),
            'penghasilan_ayah' => Factory::create()->numberBetween(1000000, 9999999),
            
            'nama_ibu' => Factory::create()->name,
            'ktp_ibu' => Factory::create()->numberBetween(1000, 9999),
            'tempat_lahir_ibu' => Factory::create()->city,
            'tanggal_lahir_ibu' => Factory::create()->date,
            'no_hp_ibu' => Factory::create()->numberBetween(1000000000, 9999999999),
            'pekerjaan_ibu' => Factory::create()->randomElement(['Wiraswasta', 'PNS', 'lainnya']),
            'penghasilan_ibu' => Factory::create()->numberBetween(1000000, 9999999),
            'created_at' => Factory::create()->date,
            'updated_at' => Factory::create()->date,


        ]));
        $user->save();
    }
}}
