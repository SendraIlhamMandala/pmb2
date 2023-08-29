<?php

namespace App\Http\Controllers;



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
    public function gethtmlpage(): HttpResponse
    {
        $html = "<html> <center> <h1>All html document conddtent </h1> </center></html>";

        return response($html, 200)->header('Content-Type', 'text/html');
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
