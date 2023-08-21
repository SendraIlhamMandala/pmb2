<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Response;
use mysqli;

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


        $conn = new mysqli("localhost","root","","fisipol_cat");

        $sql = "SELECT * FROM tr_guru_tes";
        $result = $conn->query($sql);
        $result2 =$result->fetch_assoc();
        $results = [];
        // Fetch associated key-value pairs in a loop
        
        foreach ($result as $key_1 => $value_1) {
            
            foreach ($value_1 as $key => $value) {
                $results[$key_1][$key] = $value ;
            };
        };

        $sql="SELECT * FROM tr_guru_tes WHERE id = 9";

        if ($result)
        {
            dd(mysqli_fetch_all($result),$results);
         }

}
}