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

    function cat()   {

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
        
    

        // $sql_get_user_ikut_ujian = "select * from tr_ikut_ujian where id_user='".$userid."'";

        // $sqladmin = "SELECT * FROM m_admin ORDER BY id DESC LIMIT 10";
        $sqladmin = "SELECT * FROM m_admin Where username = '{$npm}'";
        $resultadmin = $conn->query($sqladmin);
        $resultadmin2 = $resultadmin->fetch_assoc();
        $resultsadmin = [];

        // Convert the result set into an associative array
        foreach ($result as $key_1 => $value_1) {
            foreach ($value_1 as $key => $value) {
                $results[$key_1][$key] = $value;
            };
        };


        foreach ($resultsadmin as $key_admin => $value_admin) {
            foreach ($value_admin as $key => $value) {
                $results[$key_admin][$key] = $value;
            };
        }
        

            // dd($result2['id'],$results,$name,$resultadmin2,$resultuser);
            dd($resultadmin2);
         

    }

    function createAdmin()  {
        
        if (!Role::findByName('admin') && !Role::findByName('user')) {
            
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'user']);
        }
        return Role::all();
    }

    function getAdmin()  {
        $role =  \Spatie\Permission\Models\Role::all();
        $user = Auth()->user();
        // $user->assignRole('admin');
        // Role::create(['name' => 'user']);

        $user->syncRoles(['admin']);

        dd($user->roles->pluck('name'));
    }
}