<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use mysqli;

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
        $npm = $conn->real_escape_string('69696969');
        $jurusan = $conn->real_escape_string('Ilmu Administrasi Negara');
        
        // Insert a new record into the m_siswa table
        $sql_add_siswa = "INSERT INTO m_siswa VALUES (null, '{$name}', '{$npm}', '{$jurusan}')";
        $conn->query($sql_add_siswa);
        
        // Retrieve the last 10 records from the m_siswa table
        $sql = "SELECT * FROM m_siswa ORDER BY id DESC LIMIT 10";
        $result = $conn->query($sql);
        $result2 = $result->fetch_assoc();
        $results = [];
        
        // Convert the result set into an associative array
        foreach ($result as $key_1 => $value_1) {
            foreach ($value_1 as $key => $value) {
                $results[$key_1][$key] = $value;
            };
        };
        

            dd($result2,$results,$name);
         

    }

    function getAdmin()  {
        $role =  \Spatie\Permission\Models\Role::all();
        $user = Auth()->user();
        // $user->assignRole('admin');
        // Role::create(['name' => 'user']);

        $user->syncRoles(['user', 'admin']);

        dd($user->roles);
    }
}